<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Course;
use App\Models\LecturerScheduling;
use App\Models\Program;
use App\Models\ProgramInfo;
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
        $week_days = [
            1 => 'Thứ Hai',
            2 => 'Thứ Ba',
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy',
            0 => 'Chủ Nhật'
        ];
        return view('admin.course.add', ['class' => $classes, 'lecturer' => $lecturers, 'week_days' => $week_days]);
    }

    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'start' => 'date_format:H:i|before:end',
            'end' => 'date_format:H:i'
        ]);
        $program_id = Classes::where('id', $request->class)->pluck('program_id')->toArray();
        $program_info = ProgramInfo::where(['program_id' => $program_id, 'subject_id' => $request->subject])->first('id');
        //khoảng cách giữa giờ bắt đầu và kết thúc học
        $time_gap = floor((strtotime($request->end) - strtotime($request->start)) / 3600);
        if ($time_gap <= 4){
            $course = [
                'name' => $request->name,
                'total_hours' => $request->total_hours,
                'class_id' => $request->class,
                'subject_id' => $program_info->id,
                'scheduled_day' => json_encode($request->scheduled_day,JSON_NUMERIC_CHECK),
                'scheduled_time' => $request->start . ' - ' . $request->end,
                'created_by' => auth()->user()->id
            ];

            $new_course = Course::firstOrCreate($course);
            if ($new_course) {
                Session::flash('message', 'Vui lòng phân công giảng viên.');
                Session::flash('type', 'info');
                return redirect('admin/course/' . $new_course->id);
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có lỗi xảy ra.');
            return redirect('admin/course/create');
        }
    }

    public function show($id)
    {
        $course = Course::find($id);
        $course->subject_id = ProgramInfo::where('id', $course->subject_id)->pluck('subject_id')->first();
        $course->scheduled_day = json_decode($course->scheduled_day);
        $course->scheduled_time = explode(' - ', $course->scheduled_time);
        $course->start = $course->scheduled_time[0];
        $course->end = $course->scheduled_time[1];
        $lecturers = LecturerScheduling::where(['course_id' => $id, 'status' => 1])->pluck('lecturer_id')->toArray();
        $week_days = [
            1 => 'Thứ Hai',
            2 => 'Thứ Ba',
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy',
            0 => 'Chủ Nhật'
        ];
        return view('admin.course.detail', ['course' => $course, 'lecturers' => $lecturers, 'week_days' => $week_days]);
    }

    //kiểm tra nếu giảng viên có lịch trùng với lớp môn học khác đã được phân công
    public function checkDuplicateSchedule($course, $lecturer_id){

        $validated = true;

        $scheduled_lecturer = LecturerScheduling::select('course.scheduled_day', 'course.scheduled_time')
            ->leftJoin('course','course.id','=','lecturer_scheduling.course_id')
            ->where([
                ['lecturer_scheduling.lecturer_id', '=', $lecturer_id],
                ['lecturer_scheduling.course_id', '!=', $course->id],
                ['lecturer_scheduling.status', '=', 1],
                ['course.status', '=', 1]
            ])->get();

        foreach ($scheduled_lecturer as $scheduled) {
            $scheduled->scheduled_day = json_decode($scheduled->scheduled_day);
            $scheduled->scheduled_time = explode(' - ',$scheduled->scheduled_time);
            $scheduled->start = strtotime($scheduled->scheduled_time[0]);
            $scheduled->end = strtotime($scheduled->scheduled_time[1]);

            if (array_intersect($course->scheduled_day,$scheduled->scheduled_day) || ($course->start >= $scheduled->start && $course->start <= $scheduled->end) || ($course->end >= $scheduled->start && $course->end <= $scheduled->end)){
                $validated = false;
            }
        }

        return $validated;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            '*' => 'required',
            'start' => 'date_format:H:i|before:end',
            'end' => 'date_format:H:i'
        ]);
        $program_id = Classes::where('id', $request->class)->pluck('program_id')->toArray();
        $program_info = ProgramInfo::where(['program_id' => $program_id, 'subject_id' => $request->subject])->first('id');
        //khoảng cách giữa giờ bắt đầu và kết thúc học
        $time_gap = floor((strtotime($request->end) - strtotime($request->start)) / 3600);
        if ($time_gap <= 4){
            $course = [
                'name' => $request->name,
                'total_hours' => $request->total_hours,
                'class_id' => $request->class,
                'subject_id' => $program_info->id,
                'scheduled_day' => json_encode($request->scheduled_day,JSON_NUMERIC_CHECK),
                'scheduled_time' => $request->start . ' - ' . $request->end,
                'updated_by' => auth()->user()->id
            ];

            $lecturers = LecturerScheduling::where(['course_id' => $id, 'status' => 1])->pluck('lecturer_id')->toArray();
            foreach ($lecturers as $lecturer) {
                $validated = $this->checkDuplicateSchedule($id, $lecturer);
            }

            $new_course = Course::updateOrCreate(
                ['id' => $id],
                $course
            );
            if ($new_course) {
                Session::flash('message', 'Sửa thông tin thành công.');
                Session::flash('type', 'success');
                return redirect('admin/course/' . $id);
            }
        } else {
            Session::flash('type', 'error');
            Session::flash('message', 'Đã có lỗi xảy ra.');
            return redirect('admin/course/create');
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
