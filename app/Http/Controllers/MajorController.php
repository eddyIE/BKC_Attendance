<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MajorController extends Controller
{
    public function index()
    {
        $data = Major::orderBy('created_at')->simplePaginate(10);
        return view('admin.major.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.major.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'codeName' => 'required',
        ]);

        $exist = Major::where($data)->get();
        if ($exist->isEmpty()){
            $data['created_by'] = auth()->user()->id;
            $result = Major::create($data);

            if ($result){
                Session::flash('type', 'success');
                Session::flash('message', 'Thêm thông tin thành công.');
                return redirect('admin/major');
            } else {
                Session::flash('type', 'error');
                Session::flash('message', 'Đã có sự cố xảy ra.');
                return redirect('admin/major');
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/major');
        }
    }

    public function show($id)
    {
        $data = Major::find($id);
        return view('admin.major.detail', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'codeName' => 'required',
        ]);
        $data['modified_by'] = auth()->user()->id;

        $major = Major::find($id);
        $result = $major->update($data);

        if ($result){
            Session::flash('type', 'success');
            Session::flash('message', 'Sửa thông tin thành công.');
            return redirect('admin/major');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/major');
        }
    }

    public function destroy($id)
    {
        $data = [
            'status' => 0,
            'modified_by' => auth()->user()->id,
        ];

        $major = Major::find($id);
        $result = $major->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã bị ẩn khỏi hệ thống.');
            return redirect('admin/major');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/major');
        }
    }

    public function restore($id)
    {
        $data = [
            'status' => 1,
            'modified_by' => auth()->user()->id,
        ];

        $major = Major::find($id);
        $result = $major->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã được khôi phục.');
            return redirect('admin/major');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/major');
        }
    }
}
