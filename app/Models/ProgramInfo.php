<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramInfo extends Model
{
    protected $table = 'program_info';
    protected $primaryKey = 'id';
    protected $fillable = [
        'program_id',
        'subject_id',
        'status',
        'created_by',
        'modified_by',
    ];
    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function course(){
        return $this->hasMany(Course::class, 'subject_id', 'id');
    }
}
