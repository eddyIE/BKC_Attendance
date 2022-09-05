<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\LecturerScheduling;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Schedule extends Component
{
    public $lecturers;
    public $lecturer = [];
    public $course;

    public function mount(){
        $this->lecturers = User::where(['role' => 0, 'status' => 1])->get();
    }

    public function newLecturer(){
        $this->lecturer[] = (string)$this->lecturers[0]->id;
    }

    public function removeLecturer($index){
        unset($this->lecturer[$index]);
        $this->lecturer = array_values($this->lecturer);
    }

    //kiểm tra nếu giảng viên có lịch trùng với lớp môn học khác đã được phân công (true = không trùng, false = trùng)
    public function checkDuplicateSchedule($course_id, $lecturer_id){
        $course = Course::select('scheduled_day', 'scheduled_time')->where(['id' => $course_id, 'status' => 1])->first();
        $course->scheduled_day = json_decode($course->scheduled_day);
        $course->scheduled_time = explode(' - ',$course->scheduled_time);
        $course->start = strtotime($course->scheduled_time[0]);
        $course->end = strtotime($course->scheduled_time[1]);

        $validated = true;

        $scheduled_lecturer = LecturerScheduling::select('course.scheduled_day', 'course.scheduled_time')
            ->leftJoin('course','course.id','=','lecturer_scheduling.course_id')
            ->where([
                ['lecturer_scheduling.lecturer_id', '=', $lecturer_id],
                ['lecturer_scheduling.course_id', '!=', $course_id],
                ['lecturer_scheduling.status', '=', 1],
                ['course.status', '=', 1]
            ])->get();

        foreach ($scheduled_lecturer as $scheduled) {
            $scheduled->scheduled_day = json_decode($scheduled->scheduled_day);
            $scheduled->scheduled_time = explode(' - ',$scheduled->scheduled_time);
            $scheduled->start = strtotime($scheduled->scheduled_time[0]);
            $scheduled->end = strtotime($scheduled->scheduled_time[1]);

            if (array_intersect($course->scheduled_day,$scheduled->scheduled_day)){
                if (($course->start >= $scheduled->start && $course->start <= $scheduled->end) || ($course->end >= $scheduled->start && $course->end <= $scheduled->end)){
                    $validated = false;
                }
            }
        }

        return $validated;
    }

    public function fireAlert($type, $message){
        $this->dispatchBrowserEvent('swal', [
            'toast' => 'true',
            'timer' => 3000,
            'timerProgressBar' => true,
            'position' => 'top-end',
            'iconColor' => 'white',
            'customClass' => ['popup' => 'colored-toast'],
            'showConfirmButton' => false,
            'icon' => $type,
            'title' => $message
        ]);
    }

    public function schedule(){
        //kiểm tra việc phân công 1 giảng viên nhiều hơn 1 lần cho 1 lớp môn học
        $duplicate = max(array_count_values($this->lecturer));
        if ($duplicate <= 1){
            $type = 'success';
            $message = 'Phân công giảng viên thành công.';

            /** so sánh 2 mảng để thêm hoặc xóa phân công:
            * @param $this->lecturer (mảng từ phía client)
            * @param $schedules (mảng trên hệ thống)
            */

            $schedules = LecturerScheduling::where(['course_id' => $this->course, 'status' => 1])->pluck('lecturer_id')->toArray();

            //nếu phần tử của mảng hệ thống không có trong mảng client, thực hiện xóa
            foreach ($schedules as $schedule) {
                if (!in_array($schedule, $this->lecturer)){
                    //kiểm tra nếu giảng viên đã từng điểm danh lớp môn học thì ẩn khỏi hệ thống, nếu không thì xóa
                    $scheduled_lecturer = LecturerScheduling::where(['course_id' => $this->course, 'lecturer_id' => $schedule]);
                    $lesson_taught = LecturerScheduling::select('lesson.id')
                        ->leftJoin('lesson','lesson.lecturer_id','=','lecturer_scheduling.lecturer_id')
                        ->groupBy('lecturer_scheduling.course_id','lecturer_scheduling.lecturer_id','lesson.id')
                        ->havingRaw('lecturer_scheduling.course_id =' . $this->course . ' and lecturer_scheduling.lecturer_id =' . $schedule)
                        ->count('id');
                    if ($lesson_taught > 0){
                        $scheduled_lecturer->update(['status' => 0, 'modified_by' => auth()->user()->id]);
                    } else {
                        $scheduled_lecturer->delete();
                    }
                }
            }

            $insert_data = [];
            $validated = false;
            //nếu phần tử của mảng client không có trong mảng hệ thống, thực hiện thêm phân công
            foreach ($this->lecturer as $index => $lecturer){
                if (!in_array($lecturer, $schedules)){
                    $validated = $this->checkDuplicateSchedule($this->course,$lecturer);
                    if ($validated == true){
                        //xác định giảng viên chính
                        if ($index == 0){
                            $insert_data[] = [
                                'course_id' => $this->course,
                                'lecturer_id' => $lecturer,
                                'created_by' => auth()->user()->id,
                            ];
                        } else {
                            $insert_data[] = [
                                'course_id' => $this->course,
                                'lecturer_id' => $lecturer,
                                'substitution' => 1,
                                'created_by' => auth()->user()->id,
                            ];
                        }
                    } else {
                        $type = 'error';
                        $message = 'Trùng lịch của giảng viên với lớp môn học khác.';
                    }
                }
            }
            if ($validated == true){
                LecturerScheduling::insert($insert_data);
            }
        } else {
            $type = 'error';
            $message = 'Trùng lặp giảng viên.';
        }

        $this->fireAlert($type, $message);
    }

    public function render()
    {
        return view('livewire.schedule');
    }
}
