<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'user';
    protected $fillable = [
        'username',
        'password',
        'role',
        'full_name',
        'phone',
        'gender',
        'status',
    ];
}
