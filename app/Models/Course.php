<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
