<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        return view('lecturer.index');
    }

    public function courseChooser()
    {
        // Lấy danh sách các lớp
        $courses = Course::all();
        // Trả dữ liệu về view
        return view('lecturer.attendance.index', ['courses' => $courses]);
    }

    // Lấy toàn bộ các thông tin về một khóa học
    //    - Thông tin chung: số giờ dạy, tên lớp học, v.v
    //    - Danh sách sinh viên
    //    - Lịch sử
    //    - ?
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

        return view('lecturer.attendance.index',
            ['courses' => $courses, 'students' => $students, 'curCourse' => $curCourse]);
    }
}
