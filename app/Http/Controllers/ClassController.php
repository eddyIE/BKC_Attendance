<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    public function index()
    {
        $data = Classes::whereRelation('program', 'status', true)->get()->sortByDesc('created_at');
        return view('admin.class.index', ['data' => $data]);
    }

    public function create()
    {
        $program = Program::where('status', true)->get();
        return view('admin.class.add', ['program' => $program]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'program_id' => 'required',
        ]);

        $exist = Classes::where($data)->get();

        if ($exist->isEmpty()){
            $data['created_by'] = auth()->user()->id;
            $result = Classes::create($data);
            if ($result){
                Session::flash('type', 'success');
                Session::flash('message', 'Thêm thông tin thành công.');
                return redirect('admin/class');
            } else {
                Session::flash('type', 'error');
                Session::flash('message', 'Đã có sự cố xảy ra.');
                return redirect('admin/class');
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/class');
        }
    }

    public function show($id)
    {
        $data = Classes::find($id);
        $program = Program::where('status', true)->get();
        return view('admin.class.detail', ['data' => $data, 'program' => $program]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'program_id' => 'required',
        ]);
        $data['modified_by'] = auth()->user()->id;

        $class = Classes::find($id);
        $result = $class->update($data);

        if ($result){
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
