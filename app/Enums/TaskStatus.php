<?php

namespace App\Enums;

enum TaskStatus: string
{
    case COMPLETED   = 'Completed';
    case IN_PROGRESS = 'In Progress';
    case PENDING     = 'Pending';

    public static function getValues(): array
    {
        return [
            self::COMPLETED->value,
            self::IN_PROGRESS->value,
            self::PENDING->value,
        ];
    }

    public static function colors(): array
    {
        return [
            self::COMPLETED->value    => 'positive',
            self::IN_PROGRESS->value  => 'warning',
            self::PENDING->value     => 'negative',
        ];
    }

    public static function getColor($status): ?string
    {
        return self::colors()[$status] ?? null;
    }
}
