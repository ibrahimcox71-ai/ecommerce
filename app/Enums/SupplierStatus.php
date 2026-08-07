<?php

namespace App\Enums;

enum SupplierStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Blacklisted = 'blacklisted';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Blacklisted => 'Blacklisted',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'secondary',
            self::Blacklisted => 'danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Active => 'fa-check-circle',
            self::Inactive => 'fa-pause-circle',
            self::Blacklisted => 'fa-ban',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
