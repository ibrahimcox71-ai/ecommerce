<?php

namespace App\Enums;

enum ExpenseCategoryType: string
{
    case Operational = 'operational';
    case Administrative = 'administrative';
    case Payroll = 'payroll';
    case Marketing = 'marketing';
    case Utilities = 'utilities';
    case Rent = 'rent';
    case Travel = 'travel';
    case Maintenance = 'maintenance';
    case Insurance = 'insurance';
    case Tax = 'tax';
    case Depreciation = 'depreciation';
    case Miscellaneous = 'miscellaneous';

    public function label(): string
    {
        return match ($this) {
            self::Operational => 'Operational',
            self::Administrative => 'Administrative',
            self::Payroll => 'Payroll',
            self::Marketing => 'Marketing & Advertising',
            self::Utilities => 'Utilities',
            self::Rent => 'Rent & Leasing',
            self::Travel => 'Travel & Transportation',
            self::Maintenance => 'Maintenance & Repairs',
            self::Insurance => 'Insurance',
            self::Tax => 'Tax & Licenses',
            self::Depreciation => 'Depreciation',
            self::Miscellaneous => 'Miscellaneous',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Operational => 'primary',
            self::Administrative => 'secondary',
            self::Payroll => 'info',
            self::Marketing => 'warning',
            self::Utilities => 'danger',
            self::Rent => 'dark',
            self::Travel => 'purple',
            self::Maintenance => 'orange',
            self::Insurance => 'teal',
            self::Tax => 'danger',
            self::Depreciation => 'secondary',
            self::Miscellaneous => 'light',
        };
    }
}
