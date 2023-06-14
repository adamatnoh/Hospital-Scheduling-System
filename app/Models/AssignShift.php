<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignShift extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'department', 'shift', 'start_date', 'end_date'];
}
