<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProgramController extends Controller
{
    public function index()
    {
        $data = Program::whereRelation('major', 'status', true)->get()->sortByDesc('created_at');
        return view('admin.program.index', ['data' => $data]);
    }

    public function create()
    {
        $major = Major::where('status', true)->get();
        return view('admin.program.add', ['major' => $major]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'major_id' => 'required',
            'session' => 'required',
        ]);
        $date_range = explode(' - ', $request->date_range);
        $data['start'] = date('Y-m-d', strtotime(str_replace('/', '-', $date_range[0])));
        $data['end'] = date('Y-m-d', strtotime(str_replace('/', '-', $date_range[1])));

        $exist = Program::where($data)->get();

        if ($exist->isEmpty()){
            $data['created_by'] = auth()->user()->id;
            $result = Program::create($data);

            if ($result){
                Session::flash('type', 'success');
                Session::flash('message', 'Thêm thông tin thành công.');
                return redirect('admin/program');
            } else {
                Session::flash('type', 'error');
                Session::flash('message', 'Đã có sự cố xảy ra.');
                return redirect('admin/program');
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/program');
        }
    }

    public function show($id)
    {
        $major = Major::where('status', true)->get();
        $data = Program::find($id);
        $data['date_range'] = date('d/m/Y', strtotime($data->start)).' - '.date('d/m/Y', strtotime($data->end));
        return view('admin.program.detail', ['data' => $data, 'major' => $major]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'major_id' => 'required',
            'session' => 'required',
        ]);
        $date_range = explode(' - ', $request->date_range);
        $data['start'] = date('Y-m-d', strtotime(str_replace('/', '-', $date_range[0])));
        $data['end'] = date('Y-m-d', strtotime(str_replace('/', '-', $date_range[1])));
        $data['modified_by'] = auth()->user()->id;

        $program = Program::find($id);
        $result = $program->update($data);

        if ($result){
            Session::flash('type', 'success');
            Session::flash('message', 'Sửa thông tin thành công.');
            return redirect('admin/program');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/program');
        }
    }

    public function destroy($id)
    {
        $data = [
            'status' => 0,
            'modified_by' => auth()->user()->id,
        ];

        $program = Program::find($id);
        $result = $program->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã bị ẩn khỏi hệ thống.');
            return redirect('admin/program');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/program');
        }
    }

    public function restore($id)
    {
        $data = [
            'status' => 1,
            'modified_by' => auth()->user()->id,
        ];

        $program = Program::find($id);
        $result = $program->update($data);

        if ($result){
            Session::flash('type', 'info');
            Session::flash('message', 'Thông tin đã được khôi phục.');
            return redirect('admin/program');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có sự cố xảy ra.');
            return redirect('admin/program');
        }
    }
}