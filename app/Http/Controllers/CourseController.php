<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Course;
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
//        $classes = Classes::all();
//        foreach ($classes as $class){
//            $
//        }
        return view('admin.course.add', ['program' => $program]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'program_id' => 'required',
        ]);

        $exist = Course::where($data)->get();

        if ($exist->isEmpty()){
            $data['created_by'] = auth()->user()->id;
            $result = Course::create($data);
            if ($result){
                Session::flash('type', 'success');
                Session::flash('message', 'Thêm thông tin thành công.');
                return redirect('admin/course');
            } else {
                Session::flash('type', 'error');
                Session::flash('message', 'Đã có sự cố xảy ra.');
                return redirect('admin/course');
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
