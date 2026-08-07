<?php

namespace App\Enums;

enum TransactionType: string
{
    case Sale = 'sale';
    case Purchase = 'purchase';
    case Expense = 'expense';
    case PaymentReceived = 'payment_received';
    case PaymentSent = 'payment_sent';
    case Refund = 'refund';
    case Transfer = 'transfer';
    case Deposit = 'deposit';
    case Withdrawal = 'withdrawal';
    case Adjustment = 'adjustment';

    public function label(): string
    {
        return match ($this) {
            self::Sale => 'Sale',
            self::Purchase => 'Purchase',
            self::Expense => 'Expense',
            self::PaymentReceived => 'Payment Received',
            self::PaymentSent => 'Payment Sent',
            self::Refund => 'Refund',
            self::Transfer => 'Transfer',
            self::Deposit => 'Deposit',
            self::Withdrawal => 'Withdrawal',
            self::Adjustment => 'Adjustment',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Sale => 'success',
            self::Purchase => 'primary',
            self::Expense => 'danger',
            self::PaymentReceived => 'success',
            self::PaymentSent => 'warning',
            self::Refund => 'danger',
            self::Transfer => 'info',
            self::Deposit => 'success',
            self::Withdrawal => 'warning',
            self::Adjustment => 'secondary',
        };
    }

    public function direction(): string
    {
        return match ($this) {
            self::Sale, self::PaymentReceived, self::Deposit => 'inflow',
            self::Purchase, self::Expense, self::PaymentSent, self::Withdrawal => 'outflow',
            self::Refund => 'outflow',
            self::Transfer, self::Adjustment => 'neutral',
        };
    }
}
