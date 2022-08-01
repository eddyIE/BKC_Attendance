<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentDTO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    public function index()
    {
        return view('lecturer.index');
    }

    // ===================== CHỌN LỚP ĐỂ ĐIỂM DANH ============================
    public function courseChooser()
    {
        // TODO: Chỉ lấy danh sách các khóa học theo phân công
        // Lấy danh sách các lớp
        $courses = Course::all();
        // Trả dữ liệu về view
        return view('lecturer.attendance.index', ['courses' => $courses]);
    }

    /* ================ LẤY TOÀN BỘ CÁC THÔNG TIN VỀ MỘT KHÓA HỌC =============
     *  - Thông tin chung: số giờ dạy, tên lớp học, v.v
     *  - Danh sách sinh viên
     *  - Lịch sử
     *  - ?
     */
    public function courseDetail(Request $request)
    {
        // Lấy lại danh sách các khóa học
        // để truyền lên thanh tìm kiếm khóa học
        $courses = Course::all();

        /*
         * Tìm danh sách sinh viên của khóa học này
         */
        // Lấy thông tin của khóa học
        $courseId = $request->all()['course-id'];
        $curCourse = Course::find($courseId);
        // Lấy thông tin lớp theo học khóa học
        $curClass = Classes::find($curCourse->class_id);

        // Lấy danh sách các sinh viên
        $students = Student::where('class_id', $curCourse->class_id)->get();
        // Lấy ds DTO chứa các thông tin số buổi nghỉ, muộn, phép
        $studentDTOs = self::studentToDTO($students, $courseId);

        return view('lecturer.attendance.index', [
            'courses' => $courses,
            'students' => $studentDTOs,
            'curCourse' => $curCourse,
            'curClass' => $curClass
        ]);
    }

    /*
     * Chuyển Model Student sang StudentDTO để chứa thêm các thông tin số ngày nghỉ
     */
    private function studentToDTO($students, $courseId): array
    {
        $result = array();

        $absentList = array();
        $permissionList = array();
        $curStatusList = array();

        // Chứa cột `note` của một học sinh trong buổi học,
        // với ngày học = $lessonDate
        $reasonList = array();

        // Lấy danh sách số buổi nghỉ, nghỉ phép, trạng thái đi học hôm nay
        // của các sinh viên trong 1 course
        self::getAbsentQuan($courseId, $absentList,
            $permissionList, $curStatusList, $reasonList);

        foreach ($students as $student) {

            $studentDTO = new StudentDTO();

            //Truyền các thông tin cơ bảo vào DTO
            $studentDTO->id = $student->id;
            $studentDTO->full_name = $student->full_name;
            $studentDTO->birthdate = $student->birthdate;
            $studentDTO->class_id = $student->class_id;

            // Lấy số buổi nghỉ của sinh viên hiện tại
            $studentDTO->absentQuan = $absentList[$studentDTO->id] ?? 0;
            // Lấy số buổi nghỉ có phép của sinh viên hiện tại
            $studentDTO->permissionQuan = $permissionList[$studentDTO->id] ?? 0;
            // Lấy trạng thái đi học hôm nay của sinh viên hiện tại
            $studentDTO->currentStatus = $curStatusList[$studentDTO->id] ?? "";
            // Lấy lý do nghỉ hôm nay của sinh viên hiện tại
            $studentDTO->absentReason = $reasonList[$studentDTO->id] ?? "";

            // Thêm DTO vào array kết quả
            $result[] = $studentDTO;
        }

        return $result;
    }

    /*
     * Xử lí lấy số buổi nghỉ, phép, muộn của các sinh viên
     */
    private function getAbsentQuan($courseId, &$absentList,
                                   &$permissionList, &$curStatusList,
                                   &$reasonList)
    {
        $curLessonId = (new AttendanceController)->lessonIsExist($courseId);

        if ($curLessonId != null) {
            $attendances = Attendance::where('lesson_id', $curLessonId)->get();
            foreach ($attendances as $attendance) {
                // Set trạng thái đi học buổi hiện tại của sinh viên
                $curStatusList[$attendance->student_id] = $attendance->attendant_status;
                // Set lý do nghỉ
                $reasonList[$attendance->student_id] = $attendance->note;
                // => Kết quả sẽ có dạng:
                // - $curStatusList = ("1" => "with reason", "2" => "late");
                // - $reasonList = ("1" => "Ốm", "2" => "Hỏng xe nên đi muộn");
            }
        }

        // Đếm số buổi nghỉ/phép của sinh viên dựa theo các bản ghi attendance
        /*
        Kết quả sẽ có dạng:
            - $absentList = ("ID_sv" => số_buổi_nghỉ, "1" => 1.3, "2" => 4)
            - $permissionList = ("ID_sv" => số_buổi_phép, "1" => 1, "2" => 0)
        */
        $lessons = Lesson::where('course_id', $courseId)->get();
        foreach ($lessons as $lesson) {
            $attends = Attendance::where('lesson_id', $lesson->id)->get();
            if (!isset($attends)) {
                return;
            }
            foreach ($attends as $attend) {
                // Init
                if (!isset($absentList[$attend->student_id])) {
                    $absentList[$attend->student_id] = 0;
                }
                if (!isset($permissionList[$attend->student_id])) {
                    $permissionList[$attend->student_id] = 0;
                }

                // Một bản ghi nghỉ không phép => +1
                if ($attend->attendant_status == 'without reason') {
                    $absentList[$attend->student_id] += 1;
                } // Một bản ghi đi muộn => +0.3
                else if ($attend->attendant_status == 'late') {
                    $absentList[$attend->student_id] += 0.3;
                    // Xử lí 0.9 -> 1
                    if ($absentList[$attend->student_id] * 10 % 10 == 9) {
                        $absentList[$attend->student_id] += 0.1;
                    }
                } // Một buổi có phép => P: +1
                else {
                    $permissionList[$attend->student_id] += 1;
                }
            }
        }
    }
}
