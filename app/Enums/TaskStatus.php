<?php

namespace App\Enums;

enum TaskStatus
{
    const COMPLETED = 'Completed';
    const IN_PROGRESS = 'In Progress';
    const PENDING = 'Pending';


    public static function getValues(): array
    {
        return [
            self::COMPLETED,
            self::IN_PROGRESS,
            self::PENDING,
        ];
    }

    public static function colors(): array
    {
        return [
            self::COMPLETED => 'positive',
            self::IN_PROGRESS => 'warning',
            self::PENDING => 'negative',
        ];
    }

    public static function getColor($status): ?string
    {
        return self::colors()[$status] ?? null;
    }
}
