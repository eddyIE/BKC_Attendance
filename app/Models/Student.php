<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_id',
        'full_name',
        'birthdate',
        'status',
        'created_by',
        'modified_by',
    ];
}