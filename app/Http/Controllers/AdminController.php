<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $courses = Course::select('course.*', 'user.full_name')
            ->leftJoin('lecturer_scheduling','course.id','=','lecturer_scheduling.course_id')
            ->leftJoin('user','user.id','=','lecturer_scheduling.lecturer_id')
            ->where([
                ['scheduled_day', '!=', null],
                ['scheduled_time', '!=', null],
                ['course.status', '=', 1],
                ['lecturer_scheduling.substitution', '=', 0],
                ['lecturer_scheduling.status', '=', 1],
                ['user.status', '=', 1]
            ])->get();
        foreach ($courses as $course) {
            $course->dow = json_decode($course->scheduled_day);
            $course->scheduled_time = explode(' - ', $course->scheduled_time);
            $course->start = $course->scheduled_time[0];
            $course->end = $course->scheduled_time[1];
            $course->total_week = ceil($course->total_hours / floor((strtotime($course->end) - strtotime($course->start)) / 3600) / (count($course->dow)));
        }
        return view('admin.index', ['courses' => $courses]);
    }

    public function statistic($courseId = 2)
    {
        // Thống kê chung
        $lecturerQuan = User::where('role', 0)->count();
        $courseQuan = Course::where('status', 1)->count();
        $studentQuan = Student::where('status', 1)->count();
        $classQuan = Classes::where('status', 1)->count();

        // Danh sách sinh viên nghỉ nhiều
        $absents = self::getStudentAbsentTooMuch(30, 0);
        $absentsWithReason = self::getStudentAbsentTooMuch(30, 2);
        dump($absentsWithReason);
        foreach ($absentsWithReason as $absentWithReason) {
            $flag = false;
            foreach ($absents as $absent) {
                if ($absentWithReason->id == $absent->id) {
                    $absent->count += $absentWithReason->count;
                    $flag = true;
                }
            }
            if (!$flag) {
                $absents->push($absentWithReason);
            }
        }

        dump($absents);

        $absents = self::countAbsent(3, $absents);

        // Danh sách các khóa học
        $courses = Course::all();
        // Tên khóa học được chọn
        $chosenCourseName = Course::where('id', $courseId)->first();
        $chosenCourseName = $chosenCourseName->name;
        // Chart chuyên cần của khóa học
        $dataset = (new CourseController)->qualifiedStudent($courseId);
        // Lấy danh sách các giảng viên dạy trong một khóa học
        $taughtTimeInCourse = (new CourseController)->getTaughtTime($courseId);

        // Danh sách giảng viên
        $lecturers = User::where('role', 0)->get();

        return view('admin.statistic.index', [
            'lecturerQuan' => $lecturerQuan,
            'courseQuan' => $courseQuan,
            'studentQuan' => $studentQuan,
            'classQuan' => $classQuan,
            'attendanceNoReason' => $absents,
            'courses' => $courses,
            'courseDataSet' => $dataset,
            'chosenCourseName' => $chosenCourseName,
            'lecturers' => $lecturers,
            'taughtTimeInCourse' => $taughtTimeInCourse
        ]);
    }

    /*
     * Lấy danh sách sinh viên nghỉ quá nhiều
     * $duration: Khoảng thời gian bắt đầu tính (vd: 14 -> 14 ngày gần nhất)
     * times: Số lần vi phạm tối đa
     * $status: Trạng thái nghỉ (0 - Nghỉ, 1 - Muộn, 2 - Nghỉ có phép
     */
    private function getStudentAbsentTooMuch($duration, $status)
    {
        $statusConvert = ["without reason", "late", "with reason"];
        $date = Carbon::now()->subDays($duration);

        $results = Student::selectRaw('student.id, student.full_name, student.code,
            student.class_id, student.birthdate, attendance.attendant_status,
            count(attendance.attendant_status) as count')
            ->leftJoin('attendance', 'student.id', '=', 'attendance.student_id')
            ->where("attendance.created_at", '>=', $date)
            ->groupBy('student.id', 'attendance.attendant_status')
            ->having('attendance.attendant_status', $statusConvert[$status])
            ->get();

        return $results;
    }

    private function countAbsent($times, $data)
    {
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {
            if ($data[$i]->count <= $times) {
                $data->forget($i);
            }
        }
        return $data;
    }
}
