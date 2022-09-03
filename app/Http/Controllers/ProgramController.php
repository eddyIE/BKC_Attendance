<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Program;
use App\Models\ProgramInfo;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $majors = Major::where('status', true)->get();
        $subjects = Subject::where('status', true)->get();
        return view('admin.program.add', ['majors' => $majors, 'subjects' => $subjects]);
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

        $data['created_by'] = auth()->user()->id;
        $new_program = Program::firstOrCreate($data);

        if ($new_program){
            $subjects = $request->subjects;

            foreach ($subjects as $subject) {
                ProgramInfo::create(['program_id' => $new_program->id, 'subject_id' => $subject, 'created_by' => auth()->user()->id]);
            }

            Session::flash('type', 'success');
            Session::flash('message', 'Thêm thông tin thành công.');
            return redirect('admin/program');
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Thông tin đã tồn tại trong hệ thống.');
            return redirect('admin/program');
        }
    }

    public function show($id)
    {
        $major = Major::where('status', true)->get();
        $subjects = Subject::where('status', true)->get();

        foreach ($subjects as $subject) {
            $selected_subject = Subject::leftJoin('program_info', 'subject.id', '=', 'program_info.subject_id')
                ->leftJoin('program', 'program_info.program_id', '=', 'program.id')
                ->where([
                    ['program.id', '=', $id],
                    ['subject.id', '=', $subject->id],
                    ['subject.status', '=', true]
                ])->get('subject.*');

            if (count($selected_subject)){
                $subject['selected'] = true;
            } else {
                $subject['selected'] = false;
            }
        }

        $data = Program::find($id);
        $data['date_range'] = date('d/m/Y', strtotime($data->start)).' - '.date('d/m/Y', strtotime($data->end));
        return view('admin.program.detail', ['data' => $data, 'major' => $major, 'subjects' => $subjects]);
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

        $current_subjects = ProgramInfo::where('program_id', $id)->pluck('subject_id')->toArray();
        $selected_subjects = [];
        if (!empty($request->subjects)){
            $selected_subjects = $request->subjects;
        }

        foreach ($current_subjects as $current) {
            if (!in_array($current, $selected_subjects)){
                dd($current.': deleted!');
            }
        }

        foreach ($selected_subjects as $selected){
            if (!in_array($selected, $current_subjects)){
                dd($selected.': created!');
            }
        }

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
