<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'id';
    protected $fillable = [
        'lesson_id',
        'student_id',
        'attendance_status',
        'note',
        'created_by',
        'modified_by',
    ];
}
