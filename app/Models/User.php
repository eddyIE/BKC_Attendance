<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'password',
        'role',
        'full_name',
        'phone',
        'gender',
    ];
    protected $attributes = [
        'status' => 1,
        'role' => 0,
    ];

    public function lesson(){
        return $this->hasMany(Lesson::class);
    }

    public function lecturer_scheduling(){
        return $this->hasMany(LecturerScheduling::class, 'lecturer_id');
    }
}
