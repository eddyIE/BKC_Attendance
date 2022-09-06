<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerScheduling extends Model
{
    protected $table = 'lecturer_scheduling';
    protected $primaryKey = 'id';
    protected $fillable = [
        'course_id',
        'lecturer_id',
        'lesson_taught',
        'substitution',
        'status',
        'created_by',
        'modified_by',
    ];
    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}
