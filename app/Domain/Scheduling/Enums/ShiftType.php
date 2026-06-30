<?php

namespace App\Domain\Scheduling\Enums;

enum ShiftType: string
{
    case Morning = 'Morning';
    case Evening = 'Evening';
    case Night = 'Night';

    public function color(): string
    {
        return match ($this) {
            self::Morning => '#8da399',
            self::Evening => '#d65302',
            self::Night => '#311F62',
        };
    }
}
