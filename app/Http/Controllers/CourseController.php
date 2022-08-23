<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Course;
use App\Models\LecturerScheduling;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    public function index()
    {
        $data = Course::with([
            'class' => function($query){
                $query->where('class.status', true);
            },
            'program_info' => function($query){
                $query->where('program_info.status', true);
            },
            'program_info.subject' => function($query){
                $query->where('subject.status', true);
            },
            'lecturer_scheduling' => function($query){
                $query->where('lecturer_scheduling.status', true);
            },
            'lecturer_scheduling.user' => function($query){
                $query->where('user.status', true);
            },
        ])->get()->sortByDesc('course.created_at');
        return view('admin.course.index', ['data' => $data]);
    }

    public function create()
    {
        $classes = Classes::all();
        $lecturers = User::where('role', 0)->get();
        return view('admin.course.add', ['class' => $classes, 'lecturer' => $lecturers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'total_hours' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'lecturer' => 'required',
            'scheduled_day' => 'required',
            'scheduled_time' => 'required'
        ]);
        $course = [
            'name' => $request->name,
            'total_hours' => $request->total_hours,
            'class_id' => $request->class,
            'subject_id' => $request->subject,
            'scheduled_day' => json_encode($request->scheduled_day),
            'scheduled_time' => $request->start . ' - ' . $request->end,
            'created_by' => auth()->user()->id
        ];
        dd($course);

        $exist = Course::where($course)->get();

        if ($exist->isEmpty()){
            $course['created_by'] = auth()->user()->id;
            $new_course = Course::create($course);

            if ($new_course){
                $lecturer = [
                    'course_id' => $new_course->id,
                    'lecturer_id' => $request->lecturer,
                    'substitution' => 0,
                    'created_by' => auth()->user()->id
                ];

                $scheduled_lecturer = LecturerScheduling::create($lecturer);

                if ($request->substitute_lecturer){
                    $substitute = [
                        'course_id' => $new_course->id,
                        'lecturer_id' => $request->substitute_lecturer,
                        'substitution' => 1,
                        'created_by' => auth()->user()->id
                    ];

                    $scheduled_substitute = LecturerScheduling::create($substitute);
                }

                if ($scheduled_lecturer){
                    Session::flash('type', 'success');
                    Session::flash('message', 'Thêm thông tin thành công.');
                    return redirect('admin/course');
                } else {
                    Session::flash('type', 'error');
                    Session::flash('message', 'Đã có sự cố xảy ra.');
                    return redirect('admin/course');
                }
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/course');
        }
    }

    public function show($id)
    {
        $data = Course::find($id);
        $program = Program::all();
        return view('admin.course.detail', ['data' => $data, 'program' => $program]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'program_id' => 'required',
        ]);
        $data['modified_by'] = auth()->user()->id;

        $course = Course::find($id);
        $result = $course->update($data);

        if ($result){
            Session::flash('type', 'success');
            Session::flash('message', 'Sửa thông tin thành công.');
            return redirect('admin/course');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/course');
        }
    }

    public function destroy($id)
    {
        $data = [
            'status' => 0,
            'modified_by' => auth()->user()->id,
        ];

        $course = Course::find($id);
        $result = $course->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã bị ẩn khỏi hệ thống.');
            return redirect('admin/course');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/course');
        }
    }

    public function restore($id)
    {
        $data = [
            'status' => 1,
            'modified_by' => auth()->user()->id,
        ];

        $course = Course::find($id);
        $result = $course->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã được khôi phục.');
            return redirect('admin/course');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/course');
        }
    }
}
