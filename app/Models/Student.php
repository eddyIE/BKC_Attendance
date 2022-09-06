<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_id',
        'full_name',
        'birthdate',
        'status',
        'created_by',
        'modified_by',
        'code'
    ];
    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
    ];

    public function attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function class(){
        return $this->belongsTo(Classes::class);
    }
}
