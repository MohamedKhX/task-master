<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case NOT_STARTED   = 'Not Started';
    case IN_PROGRESS   = 'In Progress';
    case ON_HOLD       = 'On Hold';
    case COMPLETED     = 'Completed';

    public static function getValues(): array
    {
        return [
            self::NOT_STARTED->value,
            self::IN_PROGRESS->value,
            self::ON_HOLD->value,
            self::COMPLETED->value,
        ];
    }

    public static function colors(): array
    {
        return [
            self::NOT_STARTED->value  => 'black',
            self::IN_PROGRESS->value  => 'warning',
            self::ON_HOLD->value      => 'negative',
            self::COMPLETED->value    => 'positive',
        ];
    }

    public static function getColor($status): ?string
    {
        return self::colors()[$status] ?? null;
    }
}
