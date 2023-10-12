<?php

namespace App\Enums;

enum TaskPriority: string
{
    case LOW      = 'Low';
    case HIGH     = 'High';
    case Critical = 'Critical';

    public static function getValues(): array
    {
        return [
            self::LOW->value,
            self::HIGH->value,
            self::Critical->value,
        ];
    }

    public static function colors(): array
    {
        return [
            self::LOW->value => 'positive',
            self::HIGH->value => 'warning',
            self::Critical->value => 'negative',
        ];
    }

    public static function getColor($priority): ?string
    {
        return self::colors()[$priority] ?? null;
    }
}
