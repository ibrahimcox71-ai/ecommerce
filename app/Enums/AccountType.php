<?php

namespace App\Enums;

enum AccountType: string
{
    case Asset = 'asset';
    case Liability = 'liability';
    case Equity = 'equity';
    case Revenue = 'revenue';
    case Expense = 'expense';
    case ContraAsset = 'contra_asset';
    case ContraLiability = 'contra_liability';
    case ContraEquity = 'contra_equity';
    case ContraRevenue = 'contra_revenue';
    case ContraExpense = 'contra_expense';

    public function label(): string
    {
        return match ($this) {
            self::Asset => 'Asset',
            self::Liability => 'Liability',
            self::Equity => 'Equity',
            self::Revenue => 'Revenue',
            self::Expense => 'Expense',
            self::ContraAsset => 'Contra Asset',
            self::ContraLiability => 'Contra Liability',
            self::ContraEquity => 'Contra Equity',
            self::ContraRevenue => 'Contra Revenue',
            self::ContraExpense => 'Contra Expense',
        };
    }

    public function normalBalance(): string
    {
        return match ($this) {
            self::Asset, self::Expense, self::ContraLiability, self::ContraEquity, self::ContraRevenue => 'debit',
            self::Liability, self::Equity, self::Revenue, self::ContraAsset, self::ContraExpense => 'credit',
        };
    }

    public function category(): string
    {
        return match ($this) {
            self::Asset, self::ContraAsset => 'assets',
            self::Liability, self::ContraLiability => 'liabilities',
            self::Equity, self::ContraEquity => 'equity',
            self::Revenue, self::ContraRevenue => 'revenue',
            self::Expense, self::ContraExpense => 'expenses',
        };
    }
}
