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
        // Check buổi học có tồn tại chưa (yếu tố: ca học, ngày học)
        $shift = self::getShift();
        $curDate = Carbon::now("Asia/Ho_Chi_Minh")->toDateString();

        $curLesson = Lesson::where('course_id', $courseId)
            ->where('created_at', 'like', '%'.$curDate.'%')
            ->where('shift', $shift)
            ->first();

        if ($curLesson != null) {
            $attendances = Attendance::where('lesson_id', $curLesson->id)->get();
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

    // ============================  XỬ LÝ ĐIỂM DANH ==========================
    public function createAttendance(Request $request)
    {
        // TODO: Check buổi học đã tồn tại thì gọi Update
        // Tạo buổi học (lesson)
        $lessonId = self::createLesson($request);

        // Update số buổi, giờ đã dạy của course
        self::courseFinishedTimeAndLessonHandler($request);

        // Tạo (tạo lại) các bản ghi điểm danh
        $data = $request->{'students'};
        foreach ($data as $student) {
            if (!is_null($student["status"])) {
                $attendance = new Attendance();
                $attendance->student_id = $student['student_id'];
                $attendance->attendant_status = $student['status'];
                $attendance->note = $student['absent_reason'];
                $attendance->lesson_id = $lessonId;
                $attendance->created_by = Auth::user()->id;
                $attendance->save();
            }
        }

        return redirect('/course');
    }

    private function updateLesson(Request $request)
    {
        $updatedLesson = Lesson::where();
    }

    private function createLesson(Request $request)
    {
        // Tạo mới buổi học
        $newLesson = new Lesson();
        $newLesson->start = $request->start['hour'] . ":" . $request->start['minutes'];
        $newLesson->end = $request->end['hour'] . ":" . $request->end['minutes'];
        $newLesson->note = $request->note;
        $newLesson->lecturer_id = Auth::user()->id;
        $newLesson->course_id = $request->{'current-course-id'};
        $newLesson->created_by = Auth::user()->id;
        $newLesson->shift = $request->{'shift'};

        $newLesson->save();

        return $newLesson->id;
    }

    /*
     * Method dùng để xử lí cập nhật số giờ,
     * số buổi đã dạy của một khóa học
     */
    private function courseFinishedTimeAndLessonHandler($request, $prevStart = null,
                                                        $prevEnd = null)
    {
        // Xử lí lấy các thông tin cơ bản
        $start = $request->start['hour'] . ":" . $request->start['minutes'];
        $end = $request->end['hour'] . ":" . $request->end['minutes'];
        $courseId = $request->{'current-course-id'};

        // Tính thời lượng buổi học
        // và làm tròn đến góc phần tư gần nhất (.0, .25, .5, .75)
        $lessonDuration = strtotime($start) - strtotime($end);
        $lessonDuration = floor(
                round(abs($lessonDuration) / 3600, 2) * 4) / 4;

        // Nếu buổi học đã tồn tại thì update thời lượng
        if ($prevStart != null && $prevEnd != null) {
            // Xử lí khác biệt về thời lượng so với bản ghi đã có trước:
            // Tính thời lượng giờ bản ghi cũ
            $prevLessonDuration = strtotime($prevEnd) - strtotime($prevStart);
            $prevLessonDuration = floor(
                    round(abs($prevLessonDuration) / 3600, 2) * 4) / 4;
            // Thời lượng mới - thời lượng cũ ra khác biệt để update
            $newDuration = $lessonDuration - $prevLessonDuration;

            // Cập nhật và số giờ đã dạy mà ko làm tăng số buổi đã học
            $course = Course::find($courseId);
            $course->finished_hours += $newDuration;
            $course->save();
        } // Nếu buổi học chưa tồn tại
        else {
            //Cập nhật số buổi và số giờ đã dạy
            $course = Course::find($courseId);
            $course->finished_hours += $lessonDuration;
            $course->finished_lessons += 1;
            $course->save();
        }
    }

    private function getShift()
    {
        // Các thời gian ca học bắt đầu và kết thúc
        // Vẫn được điểm nhanh sau khi kết thúc ca 30p
        define("MORNING_SHIFT_START", "08:00");
        define("MORNING_SHIFT_END", "12:30");
        define("AFTERNOON_SHIFT_START", "13:00");
        define("AFTERNOON_SHIFT_END", "17:30");
        define("EVENING_SHIFT_START", "18:00");
        define("EVENING_SHIFT_END", "21:30");

        $curTime = Carbon::now("Asia/Ho_Chi_Minh");

        if ($curTime > Carbon::parse(MORNING_SHIFT_START) &&
            $curTime < Carbon::parse(MORNING_SHIFT_END)) {
            $shift = 0;
        } else if ($curTime > Carbon::parse(AFTERNOON_SHIFT_START) &&
            $curTime < Carbon::parse(AFTERNOON_SHIFT_END)) {
            $shift = 1;
        } else if ($curTime > Carbon::parse(EVENING_SHIFT_START) &&
            $curTime < Carbon::parse(EVENING_SHIFT_END)) {
            $shift = 2;
        } else {
            $shift = 4;
        }
        return $shift;
    }
}
