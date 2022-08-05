<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'major';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'codeName',
        'status',
        'created_by',
        'modified_by',
    ];

    public function program(){
        return $this->hasMany(Program::class);
    }
}
