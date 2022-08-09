<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{
    public function index()
    {
        $data = Subject::all()->sortByDesc('created_at');
        return view('admin.subject.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.subject.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'recommend_hours' => 'required',
        ]);

        $exist = Subject::where($data)->get();

        if ($exist->isEmpty()){
            $data['created_by'] = auth()->user()->id;
            $result = Subject::create($data);
            if ($result){
                Session::flash('type', 'success');
                Session::flash('message', 'Thêm thông tin thành công.');
                return redirect('admin/subject');
            } else {
                Session::flash('type', 'error');
                Session::flash('message', 'Đã có sự cố xảy ra.');
                return redirect('admin/subject');
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/subject');
        }
    }

    public function show($id)
    {
        $data = Subject::find($id);
        return view('admin.subject.detail', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'recommend_hours' => 'required',
        ]);
        $data['modified_by'] = auth()->user()->id;

        $subject = Subject::find($id);
        $result = $subject->update($data);

        if ($result){
            Session::flash('type', 'success');
            Session::flash('message', 'Sửa thông tin thành công.');
            return redirect('admin/subject');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/subject');
        }
    }

    public function destroy($id)
    {
        $data = [
            'status' => 0,
            'modified_by' => auth()->user()->id,
        ];

        $subject = Subject::find($id);
        $result = $subject->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã bị ẩn khỏi hệ thống.');
            return redirect('admin/subject');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/subject');
        }
    }

    public function restore($id)
    {
        $data = [
            'status' => 1,
            'modified_by' => auth()->user()->id,
        ];

        $subject = Subject::find($id);
        $result = $subject->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã được khôi phục.');
            return redirect('admin/subject');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/subject');
        }
    }
}
