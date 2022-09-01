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
        $courses = Course::where([
                ['scheduled_day', '!=', null],
                ['scheduled_time', '!=', null],
                ['status', '=', 1]]
        )->get();
        foreach ($courses as $course) {
            $course->scheduled_time = explode(' - ', $course->scheduled_time);
            $course->start = $course->scheduled_time[0];
            $course->end = $course->scheduled_time[1];
            $course->total_lessons = $course->total_hours / (count($course->scheduled_time));
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

        $attendanceAbsents = self::getStudentAbsentTooMuch(30, 2, 0);

        $courses = Course::all();

        $dataset = (new CourseController)->qualifiedStudent($courseId);

        $lecturers = User::where('role', 0)->get();

        return view('admin.statistic.index', [
            'lecturerQuan' => $lecturerQuan,
            'courseQuan' => $courseQuan,
            'studentQuan' => $studentQuan,
            'classQuan' => $classQuan,
            'attendanceNoReason' => $attendanceAbsents,
            'courses' => $courses,
            'courseDataSet' => $dataset,
            'lecturers' => $lecturers
        ]);
    }

    /*
     * Lấy danh sách sinh viên nghỉ quá nhiều
     * $duration: Khoảng thời gian bắt đầu tính (vd: 14 -> 14 ngày gần nhất)
     * times: Số lần vi phạm tối đa
     * $status: Trạng thái nghỉ (0 - Nghỉ, 1 - Muộn, 2 - Nghỉ có phép
     */
    private function getStudentAbsentTooMuch($duration, $times, $status){
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

        $count = count($results);
        for ($i = 0; $i < $count; $i++) {
            if ($results[$i]->count <= $times) {
                $results->forget($i);
            }
        }
        return $results;
    }
}
