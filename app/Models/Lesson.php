<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lesson';
    protected $primaryKey = 'id';
    protected $fillable = [
        'lecturer_id',
        'course_id',
        'start',
        'end',
        'note',
        'status',
        'created_by',
        'modified_by',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function attendance(){
        return $this->hasMany(Attendance::class);
    }
}
