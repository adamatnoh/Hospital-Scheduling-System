<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnCallApplication extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'reason', 'start_date', 'end_date', 'status'];
}
