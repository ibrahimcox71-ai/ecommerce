<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StorePeriodRequest;
use App\Models\FinancePeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeriodController extends Controller
{
    public function index(Request $request): View
    {
        $periods = FinancePeriod::with('closedBy')->latest()->paginate(15);

        return view('admin.finance.periods.index', compact('periods'));
    }

    public function store(StorePeriodRequest $request): RedirectResponse
    {
        try {
            FinancePeriod::create($request->validated());

            return redirect()
                ->route('admin.finance.periods.index')
                ->with('success', 'Finance period created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function close(FinancePeriod $finance_period): RedirectResponse
    {
        try {
            if ($finance_period->isClosed() || $finance_period->isLocked()) {
                throw new \RuntimeException('Period is already closed or locked.');
            }

            $finance_period->update([
                'status' => 'closed',
                'closed_by' => auth()->guard('admin')->id(),
                'closed_at' => now(),
            ]);

            return redirect()
                ->route('admin.finance.periods.index')
                ->with('success', 'Period closed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function lock(FinancePeriod $finance_period): RedirectResponse
    {
        try {
            $finance_period->update(['status' => 'locked']);

            return redirect()
                ->route('admin.finance.periods.index')
                ->with('success', 'Period locked successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(FinancePeriod $finance_period): RedirectResponse
    {
        try {
            if ($finance_period->isLocked()) {
                throw new \RuntimeException('Cannot delete a locked period.');
            }

            $finance_period->delete();

            return redirect()
                ->route('admin.finance.periods.index')
                ->with('success', 'Period deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
