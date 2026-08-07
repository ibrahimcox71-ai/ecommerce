<?php

namespace App\Enums;

enum BrandStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Hidden = 'hidden';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Hidden => 'Hidden',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'secondary',
            self::Hidden => 'dark',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Active => 'fa-check-circle',
            self::Inactive => 'fa-pause-circle',
            self::Hidden => 'fa-eye-slash',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
