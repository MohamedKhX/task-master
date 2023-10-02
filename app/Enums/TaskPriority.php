<?php

namespace App\Enums;

enum TaskPriority
{
    const LOW = 'Low';
    const NORMAL = 'Normal';
    const HIGH = 'High';
    const URGENT = 'Urgent';

    public static function getValues(): array
    {
        return [
            self::LOW,
            self::NORMAL,
            self::HIGH,
            self::URGENT,
        ];
    }

    public static function colors(): array
    {
        return [
            self::LOW => 'Positive',
            self::NORMAL => 'Amber',
            self::HIGH => 'Orange',
            self::URGENT => 'Negative',
        ];
    }

    public static function getColor($priority): ?string
    {
        return self::colors()[$priority] ?? null;
    }
}
