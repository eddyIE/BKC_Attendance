<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

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
            $course->scheduled_time = explode(' - ',$course->scheduled_time);
            $course->start = $course->scheduled_time[0];
            $course->end = $course->scheduled_time[1];
            $course->total_lessons = $course->total_hours/(count($course->scheduled_time));
        }
        return view('admin.index', ['courses' => $courses]);
    }

    public function statistic(){
        $lecturerQuan = User::where('role', 0)->count();
        $courseQuan = Course::where('status', 1)->count();
        $studentQuan = Student::where('status', 1)->count();
        return view('admin.statistic.index', [
            'lecturerQuan' => $lecturerQuan,
            'courseQuan' => $courseQuan,
            'studentQuan' => $studentQuan
        ]);
    }
}
