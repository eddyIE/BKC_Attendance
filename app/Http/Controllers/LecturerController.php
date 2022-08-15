<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LecturerController extends Controller
{
    public function index()
    {
        return view('lecturer.index');
    }

    // ===================== CHỌN LỚP ĐỂ ĐIỂM DANH ============================
    /*
     * Query các lớp phân công của lecturer đang đăng nhập
     */
    public function courseChooser()
    {
        // Lấy danh sách các lớp
        $courses = Course::select('course.*')
            ->join('lecturer_scheduling', 'course.id', '=',
                'lecturer_scheduling.course_id')
            ->join('user', 'user.id', '=', 'lecturer_scheduling.lecturer_id')
            ->where('course.status', 0)
            ->get();
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

        // Lấy thông tin của khóa học
        $courseId = $request->all()['course-id'];
        $curCourse = Course::find($courseId);
        // Lấy thông tin lớp theo học khóa học
        $curClass = Classes::find($curCourse->class_id);

        // Lấy danh sách các sinh viên
        $students = Student::where('class_id', $curCourse->class_id)->get();
        // Lấy ds DTO chứa các thông tin số buổi nghỉ, muộn, phép
        $studentDTOs = self::studentToDTO($students, $courseId);

        // Lấy danh sách các buổi học trước
        $lessons = Lesson::where('course_id', $courseId)->get();
        // Bỏ buổi học hiện tại (nếu có) ra khỏi list
        if ((new AttendanceController)->getExistLesson($courseId) != null) {
            $lessons->forget(count($lessons) - 1);
        }

        return view('lecturer.attendance.index', ['courses' => $courses,
            'students' => $studentDTOs,
            'curCourse' => $curCourse,
            'curClass' => $curClass,
            'lessons' => $lessons]);
    }

    /*
     * Chuyển Model Student sang StudentDTO để chứa thêm các thông tin số ngày nghỉ
     */
    private
    function studentToDTO($students, $courseId, $specificLessonId = null): array
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
        self::getAbsentQuan($courseId, $absentList, $permissionList,
            $curStatusList, $reasonList, $specificLessonId);

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
    private
    function getAbsentQuan($courseId, &$absentList,
                           &$permissionList, &$curStatusList,
                           &$reasonList, $specificLessonId = null)
    {
        // lấy trạng thái đi học của buổi học hiện tại
        if ($specificLessonId != null) {
            $attendances = Attendance::where('lesson_id', $specificLessonId)->get();
            foreach ($attendances as $attendance) {
                // Set trạng thái đi học buổi hiện tại của sinh viên
                $curStatusList[$attendance->student_id] = $attendance->attendant_status;
                // Set lý do nghỉ
                $reasonList[$attendance->student_id] = $attendance->note;
                // => Kết quả sẽ có dạng:
                // - $curStatusList = ("1" => "with reason", "2" => "late");
                // - $reasonList = ("1" => "Ốm", "2" => "Hỏng xe nên đi muộn");
            }
        } else {
            $curLesson = (new AttendanceController)->getExistLesson($courseId);

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
        }

        // Đếm số buổi nghỉ/phép của sinh viên dựa theo các bản ghi attendance
        // Kết quả sẽ có dạng:
        //    - $absentList = ("ID_sv" => số_buổi_nghỉ, "1" => 1.3, "2" => 4)
        //    - $permissionList = ("ID_sv" => số_buổi_phép, "1" => 1, "2" => 0)
        $lessons = Lesson::where('course_id', $courseId)->get();
        foreach ($lessons as $lesson) {
            // Lấy các bản ghi điểm danh để thao tác
            $attends = Attendance::where('lesson_id', $lesson->id)->get();
            if (is_null($attends)) {
                return;
            }

            foreach ($attends as $attend) {
                // Init?
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

    public function prevLessonDetail($lessonId)
    {
        // Lấy lại danh sách các khóa học
        // để truyền lên thanh tìm kiếm khóa học
        $courses = Course::all();

        // Lấy các thông tin về previous lesson được chọn
        $prevLesson = Lesson::find($lessonId);
        if (is_null($prevLesson)) {
            return;
        }

        // Lấy thông tin của khóa học
        $courseId = $prevLesson->course_id;
        $curCourse = Course::find($courseId);
        // Lấy thông tin lớp theo học khóa học
        $curClass = Classes::find($curCourse->class_id);

        // Lấy danh sách các sinh viên
        $students = Student::where('class_id', $curCourse->class_id)->get();
        // Lấy ds DTO chứa các thông tin số buổi nghỉ, muộn, phép
        $studentDTOs = self::studentToDTO($students, $courseId, $lessonId);

        // Lấy danh sách các buổi học trước
        $prevLessons = Lesson::where('course_id', $courseId)->get();
        // Bỏ buổi học hiện tại (nếu có) ra khỏi list
        if ((new AttendanceController)->getExistLesson($courseId) != null) {
            $prevLessons->forget(count($prevLessons) - 1);
        }

        return view('lecturer.attendance.history_view', ['courses' => $courses,
            'students' => $studentDTOs,
            'curCourse' => $curCourse,
            'curClass' => $curClass,
            'lessons' => $prevLessons,
            'prevLesson' => $prevLesson]);
    }

    /*
     * Quản lí các lớp được phân công
     */
    public function courseManagement()
    {
        // Lấy danh sách các lớp được phân công
        $courses = Course::select('course.*')
            ->join('lecturer_scheduling', 'course.id', '=',
                'lecturer_scheduling.course_id')
            ->join('user', 'user.id', '=', 'lecturer_scheduling.lecturer_id')
            ->get();
        // Trả dữ liệu về view
        return view('lecturer.course.course', ['courses' => $courses]);
    }

    /*
     * Update status của phân công
     */
    public function courseUpdateVisibility($id)
    {
        $course = Course::find($id);
        if ($course->status == 1) {
            $data = [
                'status' => 0,
                'modified_by' => auth()->user()->id,
            ];
        } else {
            $data = [
                'status' => 1,
                'modified_by' => auth()->user()->id,
            ];
        }

        $result = $course->update($data);

        if ($result) {
            Session::flash('type', 'info');
            Session::flash('message', 'Khóa học đã kết thúc.');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
        }
        return redirect('/my-course');
    }

    /*
     * Lịch chấm công
     */
    public function timeKeeping()
    {
        if (isset(request()->month)) {
            $monthStart = date('Y-m-01', strtotime(request()->month));
            $monthEnd = date('Y-m-t', strtotime(request()->month));
        } else {
            $monthStart = date('Y-m-01');
            $monthEnd = date('Y-m-t');
        }

        // Lấy danh sách các lớp được phân công
        $courses = Course::select('course.*')
            ->join('lecturer_scheduling', 'course.id', '=',
                'lecturer_scheduling.course_id')
            ->join('user', 'user.id', '=', 'lecturer_scheduling.lecturer_id')
            ->get();

        // Thời gian làm việc tháng này
        $totalWorkTime = 0;
        // Lấy danh sách các buổi học
        $lessons = new Collection();
        foreach ($courses as $course) {
            $queries = Lesson::where('course_id', $course->id)
                ->whereBetween('created_at', [$monthStart, $monthEnd])->get();
            // Set thêm tên khóa học vào các lesson
            foreach ($queries as $query) {
                $query->course_name = $course->name;
                // Tính luôn tổng số giờ dạy tháng
                $totalWorkTime +=
                    strtotime($query->end) - strtotime($query->start);
            }
            $lessons->push($queries);
        }

        // Biến đổi giờ dạy từ giây sang Giờ:Phút:Giây
        $totalWorkTime = floor($totalWorkTime / 3600) . gmdate(":i", $totalWorkTime % 3600);
        // Lấy phần tử đầu của $lessons
        if (isset(request()->month)) {
            return view('lecturer.time_keeping.time_keeping', [
                'lessons' => $lessons[0],
                'totalWorkTime' => $totalWorkTime,
                'month' => request()->month
            ]);
        }
        return view('lecturer.time_keeping.time_keeping', [
            'lessons' => $lessons[0],
            'totalWorkTime' => $totalWorkTime
        ]);
    }
}
