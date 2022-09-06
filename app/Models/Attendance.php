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
        'attendant_status',
        'note',
        'created_by',
        'modified_by',
    ];
    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
    ];

    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
