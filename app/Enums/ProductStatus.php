<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Draft = 'draft';
    case Archived = 'archived';
    case Hidden = 'hidden';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Published',
            self::Inactive => 'Inactive',
            self::Draft => 'Draft',
            self::Archived => 'Archived',
            self::Hidden => 'Hidden',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'secondary',
            self::Draft => 'warning',
            self::Archived => 'danger',
            self::Hidden => 'info',
        };
    }
}
