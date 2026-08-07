<?php

namespace App\Enums;

enum CustomerType: string
{
    case Individual = 'individual';
    case Business = 'business';

    public function label(): string
    {
        return match ($this) {
            self::Individual => 'Individual',
            self::Business => 'Business',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Individual => 'info',
            self::Business => 'primary',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Individual => 'fa-user',
            self::Business => 'fa-building',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
