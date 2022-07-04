<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentDTO;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        return view('lecturer.index');
    }

    public function courseChooser()
    {
        // TODO: Chỉ lấy danh sách các khóa học theo phân công
        // Lấy danh sách các lớp
        $courses = Course::all();
        // Trả dữ liệu về view
        return view('lecturer.attendance.index', ['courses' => $courses]);
    }

    /* Lấy toàn bộ các thông tin về một khóa học
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

        // Tìm danh sách sinh viên của khóa học này
        $courseId = $request->all()['course-id'];
        $curCourse = Course::find($courseId);
        $curClass = $curCourse->class_id;
        $students = Student::where('class_id', $curClass)->get();
        $studentDTOs = self::studentToDTO($students, $courseId);
        return view('lecturer.attendance.index',
            ['courses' => $courses, 'students' => $students, 'curCourse' => $curCourse]);
    }

    /*
     * Chuyển Model Student sang StudentDTO để chứa thêm các thông tin số ngày nghỉ
     */
    private function studentToDTO($students, $courseId)
    {
        $result = array();

        $absentList = array();
        $permissionList = array();
        $curStatusList = array();
        // Array reasons chứa lí do nghỉ của một học sinh trong buổi học,
        // ngày học = $lessonDate
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

    private function getAbsentQuan($courseId, &$absentList,
                                   &$permissionList, &$curStatusList, &$reasonList)
    {
        // TODO: Nếu buổi học đã tồn tại

        // Đếm số buổi nghỉ/phép của sinh viên dựa theo các bản ghi attendance
        /*
        Kết quả sẽ có dạng:
            - $absentList = ("ID_học_sinh" => số_buổi_nghỉ, "18" => 1.3, "19" => 4)
            - $permissionList = ("ID_học_sinh" => số_buổi_có_phép, "18" => 1, "19" => 0)
        */
        $lessons = Lesson::where('course_id', $courseId)->get();
        foreach ($lessons as $lesson) {
            $attends = Attendance::where('lesson_id', $lesson->id)->get();
            if (!isset($attends)) {
                return;
            }
            foreach ($attends as $attend) {
                // Start
                if (!isset($absentList[$attend->student_id])) {
                    $absentList[$attend->student_id] = 0;
                }
                if (!isset($permissionList[$attend->student_id])) {
                    $permissionList[$attend->student_id] = 0;
                }

                // Một bản ghi nghỉ không phép => +1
                if ($attend->attendance_status == 'without reason') {
                    $absentList[$attend->student_id] += 1;
                } // Một bản ghi đi muộn => +0.3
                else if ($attend->attendance_status == 'late') {
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

    public function createAttendance(Request $request)
    {
        // TODO: Check buổi học đã tồn tại thì gọi Update
        // Tạo buổi học (lesson)
        $lessonId = self::createLesson($request);

        // Tạo (tạo lại) các bản ghi điểm danh
        $data = $request->{'students'};
        foreach ($data as $student) {
            if (!is_null($student["status"])) {
                $attendance = new Attendance();
                $attendance->student_id = $student['student_id'];
                $attendance->attendance_status = $student['status'];
                $attendance->note = $student['absent_reason'];
                $attendance->lesson_id = $lessonId;
                // TODO: Lấy id người tạo từ session
                $attendance->created_by = 2;
                $attendance->save();
            }
        }


    }

    private function createLesson(Request $request): string
    {
        // Tạo mới buổi học
        $newLesson = new Lesson();
        $newLessonId = uniqid();
        $newLesson->id = $newLessonId;
        $newLesson->start = $request->start['hour'] . ":" . $request->start['minutes'];
        $newLesson->end = $request->end['hour'] . ":" . $request->end['minutes'];
        $newLesson->note = $request->note;
        // TODO: Lấy ID theo session
        $newLesson->lecturer_id = 2;
        $newLesson->course_id = $request->{'current-course-id'};
        // TODO: Lấy ID theo session
        $newLesson->created_by = 2;

        return $newLessonId;
    }
}
