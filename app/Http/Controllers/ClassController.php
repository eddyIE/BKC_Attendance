<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    public function index()
    {
        $data = Classes::whereRelation('program', 'status', 1)->latest()->simplePaginate(10);
        return view('admin.class.index', ['data' => $data]);
    }

    public function create()
    {
        $program = Program::where('status', 1)->get();
        $students = Student::where(['class_id' => null, 'status' => 1])->get();
        return view('admin.class.add', ['program' => $program, 'students' => $students]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'program_id' => 'required',
        ]);
        $data['created_by'] = auth()->user()->id;

        $new_class = Classes::firstOrCreate($data);
        if ($new_class){
            if ($request->student){
                Student::whereIn('id', $request->student)->update([
                    'class_id' => $new_class->id,
                    'modified_by' => auth()->user()->id
                ]);
            }

            Session::flash('type', 'success');
            Session::flash('message', 'Thêm thông tin thành công.');
            return redirect('admin/class');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/class');
        }
    }

    public function show($id)
    {
        $data = Classes::find($id);
        $program = Program::where('status', 1)->get();
        $students = Student::whereNull('class_id')->get();
        foreach ($students as $student) {
            $student->selected = false;
        }
        $selected_students = Student::where(['class_id' => $id, 'status' => 1])->get();
        foreach ($selected_students as $student) {
            $student->selected = true;
            $students->push($student);
        }

        return view('admin.class.detail', ['data' => $data, 'program' => $program, 'students' => $students]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'program_id' => 'required'
        ]);
        $data['modified_by'] = auth()->user()->id;

        $class = Classes::where('id',$id)->update($data);

        $current_students = Student::where(['class_id' => $id, 'status' => 1])->pluck('id')->toArray();
        $selected_students = [];
        if ($request->student){
            $selected_students = $request->student;
        }

        foreach ($current_students as $current) {
            if (!in_array($current, $selected_students)){
                Student::find($current)->update([
                    'class_id' => null,
                    'modified_by' => auth()->user()->id
                ]);
            }
        }

        foreach ($selected_students as $selected){
            if (!in_array($selected, $current_students)){
                Student::find($selected)->update([
                    'class_id' => $id,
                    'modified_by' => auth()->user()->id
                ]);
            }
        }

        if ($class){
            Session::flash('type', 'success');
            Session::flash('message', 'Sửa thông tin thành công.');
            return redirect('admin/class');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/class');
        }
    }

    public function destroy($id)
    {
        $data = [
            'status' => 0,
            'modified_by' => auth()->user()->id,
        ];

        $class = Classes::find($id);
        $result = $class->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã bị ẩn khỏi hệ thống.');
            return redirect('admin/class');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/class');
        }
    }

    public function restore($id)
    {
        $data = [
            'status' => 1,
            'modified_by' => auth()->user()->id,
        ];

        $class = Classes::find($id);
        $result = $class->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã được khôi phục.');
            return redirect('admin/class');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/class');
        }
    }
}
