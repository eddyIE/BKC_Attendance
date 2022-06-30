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
}
