<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreJournalEntryRequest;
use App\Models\ChartOfAccount;
use App\Models\FinancePeriod;
use App\Models\JournalEntry;
use App\Services\AccountingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalEntryController extends Controller
{
    public function __construct(
        protected AccountingService $accountingService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'type', 'is_posted', 'date_from', 'date_to']);

        $entries = JournalEntry::with(['creator', 'postedBy'])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where('entry_number', 'like', "%{$v}%")
                ->orWhere('description', 'like', "%{$v}%"))
            ->when($filters['type'] ?? null, fn($q, $v) => $q->where('type', $v))
            ->when(isset($filters['is_posted']), fn($q) => $q->where('is_posted', $filters['is_posted'] === 'posted'))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('entry_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('entry_date', '<=', $v))
            ->latest()
            ->paginate(15);

        return view('admin.finance.journal-entries.index', compact('entries', 'filters'));
    }

    public function create(): View
    {
        $accounts = ChartOfAccount::active()->orderBy('code')->get(['id', 'code', 'name', 'type', 'normal_balance']);
        $periods = FinancePeriod::open()->get(['id', 'name']);

        return view('admin.finance.journal-entries.create', compact('accounts', 'periods'));
    }

    public function store(StoreJournalEntryRequest $request): RedirectResponse
    {
        try {
            $entry = $this->accountingService->createJournalEntry($request->validated());

            return redirect()
                ->route('admin.finance.journal-entries.show', $entry->id)
                ->with('success', "Journal entry {$entry->entry_number} created successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(JournalEntry $journal_entry): View
    {
        $journal_entry->load(['items.chartOfAccount', 'creator', 'postedBy', 'financePeriod']);

        return view('admin.finance.journal-entries.show', ['entry' => $journal_entry]);
    }

    public function edit(JournalEntry $journal_entry): View
    {
        if ($journal_entry->isPosted()) {
            abort(403, 'Cannot edit a posted journal entry.');
        }

        $accounts = ChartOfAccount::active()->orderBy('code')->get(['id', 'code', 'name', 'type', 'normal_balance']);
        $periods = FinancePeriod::open()->get(['id', 'name']);

        return view('admin.finance.journal-entries.edit', [
            'entry' => $journal_entry,
            'accounts' => $accounts,
            'periods' => $periods,
        ]);
    }

    public function update(StoreJournalEntryRequest $request, JournalEntry $journal_entry): RedirectResponse
    {
        try {
            $this->accountingService->updateJournalEntry($journal_entry->id, $request->validated());

            return redirect()
                ->route('admin.finance.journal-entries.show', $journal_entry->id)
                ->with('success', 'Journal entry updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(JournalEntry $journal_entry): RedirectResponse
    {
        try {
            if ($journal_entry->isPosted()) {
                throw new \RuntimeException('Cannot delete a posted journal entry.');
            }

            $journal_entry->delete();

            return redirect()
                ->route('admin.finance.journal-entries.index')
                ->with('success', 'Journal entry deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function post(JournalEntry $journal_entry): RedirectResponse
    {
        try {
            $this->accountingService->postJournalEntry($journal_entry->id);

            return redirect()
                ->route('admin.finance.journal-entries.show', $journal_entry->id)
                ->with('success', 'Journal entry posted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reverse(JournalEntry $journal_entry, Request $request): RedirectResponse
    {
        try {
            $reason = $request->input('reason');
            $reversal = $this->accountingService->reverseJournalEntry($journal_entry->id, $reason);

            return redirect()
                ->route('admin.finance.journal-entries.show', $reversal->id)
                ->with('success', 'Journal entry reversed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
