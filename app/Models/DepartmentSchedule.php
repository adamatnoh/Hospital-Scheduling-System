<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'department', 'ward', 'shift', 'start_date', 'end_date'];
}
