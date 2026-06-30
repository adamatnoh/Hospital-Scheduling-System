<?php

namespace App\Domain\Applications\Enums;

enum ApplicationStatus: string
{
    case Pending = 'Pending';
    case Approved = 'Yes';
    case Rejected = 'No';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }
}
