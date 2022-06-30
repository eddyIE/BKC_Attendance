<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'recommended_hours',
        'status',
        'created_by',
        'modified_by',
    ];
}
