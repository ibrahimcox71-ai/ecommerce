<?php

namespace App\Helpers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\JournalEntryItem;
use Illuminate\Support\Facades\DB;

class AccountingHelper
{
    public static function postJournalEntry(array $data, ?string $referenceType = null, ?int $referenceId = null): JournalEntry
    {
        return DB::transaction(function () use ($data, $referenceType, $referenceId) {
            $items = $data['items'] ?? [];
            unset($data['items']);

            $totalDebit = collect($items)->sum('debit');
            $totalCredit = collect($items)->sum('credit');

            if (abs($totalDebit - $totalCredit) > 0.01) {
                throw new \RuntimeException('Journal entry is not balanced. Debits: ' . $totalDebit . ', Credits: ' . $totalCredit);
            }

            $entry = JournalEntry::create([
                'entry_number' => JournalEntry::generateEntryNumber(),
                'type' => $data['type'] ?? 'standard',
                'description' => $data['description'] ?? null,
                'entry_date' => $data['entry_date'] ?? now(),
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
                'is_posted' => $data['is_posted'] ?? true,
                'posted_at' => ($data['is_posted'] ?? true) ? now() : null,
                'posted_by' => ($data['is_posted'] ?? true) ? auth()->guard('admin')->id() : null,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'finance_period_id' => $data['finance_period_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => auth()->guard('admin')->id(),
            ]);

            foreach ($items as $item) {
                JournalEntryItem::create([
                    'journal_entry_id' => $entry->id,
                    'chart_of_account_id' => $item['chart_of_account_id'],
                    'description' => $item['description'] ?? null,
                    'debit' => $item['debit'] ?? 0,
                    'credit' => $item['credit'] ?? 0,
                ]);

                $account = ChartOfAccount::find($item['chart_of_account_id']);
                if ($account) {
                    $balanceChange = ($item['debit'] ?? 0) - ($item['credit'] ?? 0);
                    if ($account->normal_balance === 'credit') {
                        $balanceChange = -$balanceChange;
                    }
                    $account->increment('current_balance', $balanceChange);
                }
            }

            return $entry->load('items.chartOfAccount');
        });
    }

    public static function calculateTax(float $amount, float $rate, bool $isCompound = false, float $previousTax = 0): float
    {
        if ($isCompound) {
            return ($amount + $previousTax) * ($rate / 100);
        }

        return $amount * ($rate / 100);
    }

    public static function formatAmount(float $amount, string $currency = 'USD'): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'INR' => '₹',
            'BDT' => '৳',
        ];

        $symbol = $symbols[$currency] ?? $currency . ' ';

        return $symbol . number_format($amount, 2);
    }

    public static function getAccountBalance(int $accountId, ?string $startDate = null, ?string $endDate = null): float
    {
        $query = JournalEntryItem::where('chart_of_account_id', $accountId)
            ->whereHas('journalEntry', function ($q) {
                $q->where('is_posted', true);
            });

        if ($startDate) {
            $query->whereHas('journalEntry', fn($q) => $q->where('entry_date', '>=', $startDate));
        }

        if ($endDate) {
            $query->whereHas('journalEntry', fn($q) => $q->where('entry_date', '<=', $endDate));
        }

        $totalDebit = (float) $query->sum('debit');
        $totalCredit = (float) $query->sum('credit');

        $account = ChartOfAccount::find($accountId);
        if (!$account) {
            return 0;
        }

        $balance = $totalDebit - $totalCredit;
        if ($account->normal_balance === 'credit') {
            $balance = -$balance;
        }

        return $balance;
    }

    public static function generateTrialBalance(?string $startDate = null, ?string $endDate = null): array
    {
        $accounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();

        return $accounts->map(function ($account) use ($startDate, $endDate) {
            $balance = self::getAccountBalance($account->id, $startDate, $endDate);
            $opening = (float) $account->opening_balance;
            $closing = $opening + $balance;

            return [
                'code' => $account->code,
                'name' => $account->name,
                'type' => $account->type,
                'opening_balance' => $opening,
                'movement' => $balance,
                'closing_balance' => $closing,
                'normal_balance' => $account->normal_balance,
            ];
        })->toArray();
    }
}
