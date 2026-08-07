<?php

namespace App\Services;

use App\Helpers\AccountingHelper;
use App\Models\ChartOfAccount;
use App\Models\FinancePeriod;
use App\Models\JournalEntry;
use App\Models\JournalEntryItem;
use Illuminate\Support\Facades\DB;

class AccountingService
{
    public function createJournalEntry(array $data, ?string $referenceType = null, ?int $referenceId = null): JournalEntry
    {
        return AccountingHelper::postJournalEntry($data, $referenceType, $referenceId);
    }

    public function updateJournalEntry(int $id, array $data): JournalEntry
    {
        return DB::transaction(function () use ($id, $data) {
            $entry = JournalEntry::findOrFail($id);

            if ($entry->isPosted()) {
                throw new \RuntimeException('Cannot update a posted journal entry. Reverse it instead.');
            }

            $items = $data['items'] ?? [];
            unset($data['items']);

            $totalDebit = collect($items)->sum('debit');
            $totalCredit = collect($items)->sum('credit');

            if (abs($totalDebit - $totalCredit) > 0.01) {
                throw new \RuntimeException('Journal entry is not balanced.');
            }

            $entry->update(array_merge($data, [
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
            ]));

            $entry->items()->delete();

            foreach ($items as $item) {
                JournalEntryItem::create([
                    'journal_entry_id' => $entry->id,
                    'chart_of_account_id' => $item['chart_of_account_id'],
                    'description' => $item['description'] ?? null,
                    'debit' => $item['debit'] ?? 0,
                    'credit' => $item['credit'] ?? 0,
                ]);
            }

            return $entry->fresh(['items.chartOfAccount']);
        });
    }

    public function postJournalEntry(int $id): JournalEntry
    {
        return DB::transaction(function () use ($id) {
            $entry = JournalEntry::findOrFail($id);

            if ($entry->isPosted()) {
                throw new \RuntimeException('Journal entry is already posted.');
            }

            if (!$entry->isBalanced()) {
                throw new \RuntimeException('Cannot post an unbalanced journal entry.');
            }

            $entry->update([
                'is_posted' => true,
                'posted_at' => now(),
                'posted_by' => auth()->guard('admin')->id(),
            ]);

            foreach ($entry->items as $item) {
                $account = $item->chartOfAccount;
                if ($account) {
                    $balanceChange = $item->debit - $item->credit;
                    if ($account->normal_balance === 'credit') {
                        $balanceChange = -$balanceChange;
                    }
                    $account->increment('current_balance', $balanceChange);
                }
            }

            return $entry->fresh(['items.chartOfAccount']);
        });
    }

    public function reverseJournalEntry(int $id, ?string $reason = null): JournalEntry
    {
        return DB::transaction(function () use ($id, $reason) {
            $original = JournalEntry::findOrFail($id);

            if (!$original->isPosted()) {
                throw new \RuntimeException('Can only reverse a posted journal entry.');
            }

            $reversedItems = $original->items->map(function ($item) {
                return [
                    'chart_of_account_id' => $item->chart_of_account_id,
                    'description' => 'Reversal: ' . ($reason ?? $item->description ?? ''),
                    'debit' => $item->credit,
                    'credit' => $item->debit,
                ];
            })->toArray();

            return $this->createJournalEntry([
                'type' => 'reversing',
                'description' => 'Reversal of ' . $original->entry_number . ($reason ? ': ' . $reason : ''),
                'entry_date' => now()->format('Y-m-d'),
                'is_posted' => true,
                'notes' => 'Auto-generated reversal',
                'items' => $reversedItems,
            ], 'App\Models\JournalEntry', $original->id);
        });
    }

    public function createAccount(array $data): ChartOfAccount
    {
        $data['normal_balance'] = (new \App\Enums\AccountType($data['type']))->normalBalance();
        $data['current_balance'] = $data['opening_balance'] ?? 0;

        return ChartOfAccount::create($data);
    }

    public function updateAccount(int $id, array $data): ChartOfAccount
    {
        $account = ChartOfAccount::findOrFail($id);

        if (isset($data['type'])) {
            $data['normal_balance'] = (new \App\Enums\AccountType($data['type']))->normalBalance();
        }

        $account->update($data);

        return $account->fresh();
    }

    public function getTrialBalance(?string $startDate = null, ?string $endDate = null): array
    {
        return AccountingHelper::generateTrialBalance($startDate, $endDate);
    }

    public function getIncomeStatement(?string $startDate = null, ?string $endDate = null): array
    {
        return ChartOfAccount::where('is_active', true)
            ->whereIn('type', ['revenue', 'contra_revenue', 'expense', 'contra_expense'])
            ->orderBy('code')
           ->get()
            ->map(function ($account) use ($startDate, $endDate) {
                $balance = AccountingHelper::getAccountBalance($account->id, $startDate, $endDate);

                return [
                    'code' => $account->code,
                    'name' => $account->name,
                    'type' => $account->type,
                    'balance' => $balance,
                ];
            })->toArray();
    }

    public function getBalanceSheet(?string $asOfDate = null): array
    {
        return ChartOfAccount::where('is_active', true)
            ->whereIn('type', ['asset', 'contra_asset', 'liability', 'contra_liability', 'equity', 'contra_equity'])
            ->orderBy('code')
            ->get()
            ->map(function ($account) use ($asOfDate) {
                $balance = AccountingHelper::getAccountBalance($account->id, null, $asOfDate);

                return [
                    'code' => $account->code,
                    'name' => $account->name,
                    'type' => $account->type,
                    'balance' => (float) $account->opening_balance + $balance,
                ];
            })->toArray();
    }
}
