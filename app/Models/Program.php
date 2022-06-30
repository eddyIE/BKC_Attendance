<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
    protected $primaryKey = 'id';
    protected $fillable = [
        'major_id',
        'name',
        'session',
        'start',
        'end',
        'status',
        'created_by',
        'modified_by',
    ];
}
