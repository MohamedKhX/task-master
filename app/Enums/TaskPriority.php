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
}
