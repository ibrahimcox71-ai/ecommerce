<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreAccountRequest;
use App\Http\Requests\Finance\UpdateAccountRequest;
use App\Models\ChartOfAccount;
use App\Services\AccountingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(
        protected AccountingService $accountingService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'type', 'is_active']);
        $accounts = ChartOfAccount::with('parent')
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where(function($sq) use ($v) {
                $sq->where('name', 'like', "%{$v}%")->orWhere('code', 'like', "%{$v}%");
            }))
            ->when($filters['type'] ?? null, fn($q, $v) => $q->where('type', $v))
            ->when(isset($filters['is_active']), fn($q) => $q->where('is_active', $filters['is_active']))
            ->orderBy('code')
            ->paginate(15);

        return view('admin.finance.accounts.index', compact('accounts', 'filters'));
    }

    public function create(): View
    {
        $parentAccounts = ChartOfAccount::whereNull('parent_id')->orderBy('code')->get(['id', 'code', 'name', 'type']);

        return view('admin.finance.accounts.create', compact('parentAccounts'));
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        try {
            $account = $this->accountingService->createAccount($request->validated());

            return redirect()
                ->route('admin.finance.accounts.index')
                ->with('success', "Account '{$account->name}' created successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(ChartOfAccount $account): View
    {
        $account->load(['parent', 'journalEntryItems' => fn($q) => $q->latest()->limit(20)]);

        return view('admin.finance.accounts.show', compact('account'));
    }

    public function edit(ChartOfAccount $account): View
    {
        $parentAccounts = ChartOfAccount::whereNull('parent_id')
            ->where('id', '!=', $account->id)
            ->orderBy('code')
            ->get(['id', 'code', 'name', 'type']);

        return view('admin.finance.accounts.edit', compact('account', 'parentAccounts'));
    }

    public function update(UpdateAccountRequest $request, ChartOfAccount $account): RedirectResponse
    {
        try {
            $this->accountingService->updateAccount($account->id, $request->validated());

            return redirect()
                ->route('admin.finance.accounts.index')
                ->with('success', "Account '{$account->name}' updated successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(ChartOfAccount $account): RedirectResponse
    {
        try {
            if ($account->journalEntryItems()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete account with journal entries.');
            }

            $account->delete();

            return redirect()
                ->route('admin.finance.accounts.index')
                ->with('success', 'Account deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus(ChartOfAccount $account): RedirectResponse
    {
        $account->update(['is_active' => !$account->is_active]);

        return redirect()->back()->with('success', 'Account status updated!');
    }
}
