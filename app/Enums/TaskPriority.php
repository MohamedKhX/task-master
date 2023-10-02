<?php

namespace App\Enums;

enum TaskPriority
{
    const LOW = 'Low';
    const HIGH = 'High';
    const Critical = 'Critical';


    public static function getValues(): array
    {
        return [
            self::LOW,
            self::HIGH,
            self::Critical,
        ];
    }

    public static function colors(): array
    {
        return [
            self::LOW => 'positive',
            self::HIGH => 'warning',
            self::Critical => 'negative',
        ];
    }

    public static function getColor($priority): ?string
    {
        return self::colors()[$priority] ?? null;
    }
}
