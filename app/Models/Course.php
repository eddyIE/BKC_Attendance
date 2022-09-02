<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_id',
        'subject_id',
        'name',
        'total_hours',
        'finished_hours',
        'finished_lessons',
        'scheduled_day',
        'scheduled_time',
        'status',
        'created_by',
        'modified_by',
    ];

    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }

    public function lecturer_scheduling()
    {
        return $this->hasMany(LecturerScheduling::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function program_info()
    {
        return $this->belongsTo(ProgramInfo::class, 'subject_id', 'id');
    }

    /*
     * Tìm khóa học được phân công của giảng viên
     */
    public function findCoursesOfLecturer($userId, $onlyUnfinishedCourse = true)
    {
        if (!$onlyUnfinishedCourse) {
            return Course::select('course.*')
                ->join('lecturer_scheduling', 'course.id', '=',
                    'lecturer_scheduling.course_id')
                ->join('user', 'user.id', '=', 'lecturer_scheduling.lecturer_id')
                ->where(['lecturer_scheduling.lecturer_id' => $userId])
                ->get();
        }
        return Course::select('course.*')
            ->join('lecturer_scheduling', 'course.id', '=',
                'lecturer_scheduling.course_id')
            ->join('user', 'user.id', '=', 'lecturer_scheduling.lecturer_id')
            ->where(['course.status' => 1,
                'lecturer_scheduling.lecturer_id' => $userId])
            ->get();
    }
}
