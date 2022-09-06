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
    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
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
}
