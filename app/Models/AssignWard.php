<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignWard extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'department', 'ward', 'ward_id', 'start_date', 'end_date'];
}
