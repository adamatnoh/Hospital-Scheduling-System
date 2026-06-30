<?php

namespace App\Domain\Identity\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Scheduler = 'scheduler';
    case Regular = 'regular';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Scheduler => 'Scheduler',
            self::Regular => 'Staff',
        };
    }

    public function canManageStaff(): bool
    {
        return $this === self::Admin;
    }

    public function canReviewApplications(): bool
    {
        return in_array($this, [self::Admin, self::Scheduler], true);
    }

    public function canGenerateSchedules(): bool
    {
        return in_array($this, [self::Admin, self::Scheduler], true);
    }
}
