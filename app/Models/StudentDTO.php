<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Data transfer object cho Student (chứa thông tin số buổi nghỉ, số phép)
class StudentDTO extends Model
{
    use HasFactory;

    public $id;
    public $class_id;
    public $full_name;
    public $birthdate;
    public $modified_by;
    public $absentQuan;
    public $permissionQuan;

    public $currentStatus;
    public $absentReason;
}
