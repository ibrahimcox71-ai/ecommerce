<?php

namespace App\Enums;

enum JournalEntryType: string
{
    case Standard = 'standard';
    case Adjusting = 'adjusting';
    case Closing = 'closing';
    case Reversing = 'reversing';
    case Opening = 'opening';

    public function label(): string
    {
        return match ($this) {
            self::Standard => 'Standard',
            self::Adjusting => 'Adjusting',
            self::Closing => 'Closing',
            self::Reversing => 'Reversing',
            self::Opening => 'Opening Balance',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Standard => 'primary',
            self::Adjusting => 'warning',
            self::Closing => 'danger',
            self::Reversing => 'info',
            self::Opening => 'secondary',
        };
    }
}
