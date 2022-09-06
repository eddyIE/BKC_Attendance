<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $primaryKey = 'id';
    protected $fillable = [
        'program_id',
        'name',
        'status',
        'created_by',
        'modified_by',
    ];
    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
    ];

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function student(){
        return $this->hasMany(Student::class);
    }

    public function course(){
        return $this->hasMany(Course::class);
    }
}
