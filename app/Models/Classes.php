<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'class';
    protected $primaryKey = 'id';
    protected $fillable = [
        'program_id',
        'name',
        'status',
        'created_by',
        'modified_by',
    ];
}