<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'role',
        'email',
        'department',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function leaveApplications(): HasMany
    {
        return $this->hasMany(LeaveApplication::class, 'user_id');
    }

    public function onCallApplications(): HasMany
    {
        return $this->hasMany(OnCallApplication::class, 'user_id');
    }

    public function onCallAssignments(): HasMany
    {
        return $this->hasMany(Assign::class, 'user_id');
    }

    public function wardAssignments(): HasMany
    {
        return $this->hasMany(AssignWard::class, 'user_id');
    }

    public function shiftAssignments(): HasMany
    {
        return $this->hasMany(AssignShift::class, 'user_id');
    }
}
