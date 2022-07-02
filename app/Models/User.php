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

    public function hasRole($role){
        switch ($role){
            case 'lecturer':    $role = 0; break;
            case 'admin':       $role = 1; break;
            case 'superadmin':  $role = 2; break;
        }
        if (Auth::user()->role == $role){
            return true;
        }
    }
}
