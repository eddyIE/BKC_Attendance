<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function index()
    {
        $data = Student::whereRelation('class', 'status', true)->orderBy('created_at')->simplePaginate(10);
        return view('admin.student.index', ['data' => $data]);
    }

    public function create()
    {
        $class = Classes::where('status', true)->get();
        return view('admin.student.add', ['class' => $class]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'class_id' => 'required',
            'birthdate' => 'required',
        ]);
        $data['birthdate'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['birthdate'])));

        $exist = Student::where($data)->get();

        if ($exist->isEmpty()){
            $data['created_by'] = auth()->user()->id;
            $result = Student::create($data);
            if ($result){
                Session::flash('type', 'success');
                Session::flash('message', 'Thêm thông tin thành công.');
                return redirect('admin/student');
            } else {
                Session::flash('type', 'error');
                Session::flash('message', 'Đã có sự cố xảy ra.');
                return redirect('admin/student');
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/student');
        }
    }

    public function show($id)
    {
        $data = Student::find($id);
        $class = Classes::where('status', true)->get();
        return view('admin.student.detail', ['data' => $data, 'class' => $class]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'class_id' => 'required',
            'birthdate' => 'required',
        ]);
        $data['birthdate'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['birthdate'])));
        $data['modified_by'] = auth()->user()->id;

        $student = Student::find($id);
        $result = $student->update($data);

        if ($result){
            Session::flash('type', 'success');
            Session::flash('message', 'Sửa thông tin thành công.');
            return redirect('admin/student');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/student');
        }
    }

    public function destroy($id)
    {
        $data = [
            'status' => 0,
            'modified_by' => auth()->user()->id,
        ];

        $student = Student::find($id);
        $result = $student->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã bị ẩn khỏi hệ thống.');
            return redirect('admin/student');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/student');
        }
    }

    public function restore($id)
    {
        $data = [
            'status' => 1,
            'modified_by' => auth()->user()->id,
        ];

        $student = Student::find($id);
        $result = $student->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã được khôi phục.');
            return redirect('admin/student');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/student');
        }
    }
}
