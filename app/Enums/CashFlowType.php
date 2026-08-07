<?php

namespace App\Enums;

enum CashFlowType: string
{
    case Operating = 'operating';
    case Investing = 'investing';
    case Financing = 'financing';

    public function label(): string
    {
        return match ($this) {
            self::Operating => 'Operating',
            self::Investing => 'Investing',
            self::Financing => 'Financing',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Operating => 'primary',
            self::Investing => 'success',
            self::Financing => 'info',
        };
    }
}
