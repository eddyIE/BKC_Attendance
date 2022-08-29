<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Livewire\Component;

class ShowSubject extends Component
{
    public $classes;
    public $subjects;
    public $classId;
    public $subjectId;
    public $schedule = [''];
    public $lecturers;
    public $new_lecturer;


    public function mount(){
        $this->lecturers = User::where(['role' => 0, 'status' => 1])->get();
        $this->classes = Classes::where('status', 1)->get()->sortByDesc('created_at');

        if ($this->classId != ''){
            $this->subjects = Subject::leftJoin('program_info', 'subject.id', '=', 'program_info.subject_id')
                ->leftJoin('class', 'program_info.program_id', '=', 'class.program_id')
                ->where([
                    ['class.id', '=', $this->classId],
                    ['class.status', '=', 1],
                ])->get('subject.*');
        } else {
            $this->subjects = [];
        }
    }

    public function updatedClassId(){
        if ($this->classId != ''){
            $this->subjects = Subject::leftJoin('program_info', 'subject.id', '=', 'program_info.subject_id')
                ->leftJoin('class', 'program_info.program_id', '=', 'class.program_id')
                ->where([
                    ['class.id', '=', $this->classId],
                    ['class.status', '=', 1],
                ])->get('subject.*');
        } else {
            $this->subjects = [];
        }
    }

    public function newLecturer(){
        $this->schedule[] = '';
    }

    public function render()
    {
        return view('livewire.show-subject');
    }
}