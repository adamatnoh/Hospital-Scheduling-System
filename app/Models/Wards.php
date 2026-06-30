<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wards extends Model
{
    protected $fillable = [
        'name',
        'department',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(AssignWard::class, 'ward_id');
    }
}
