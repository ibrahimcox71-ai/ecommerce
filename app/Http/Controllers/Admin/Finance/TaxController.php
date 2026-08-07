<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreTaxGroupRequest;
use App\Http\Requests\Finance\StoreTaxRateRequest;
use App\Models\TaxGroup;
use App\Models\TaxRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaxController extends Controller
{
    public function index(): View
    {
        $groups = TaxGroup::withCount('taxRates')->latest()->get();
        $rates = TaxRate::with('taxGroup')->latest()->paginate(20);
        $totalTaxCollected = \App\Models\TaxItem::sum('amount');

        return view('admin.finance.taxes.index', compact('groups', 'rates', 'totalTaxCollected'));
    }

    public function storeGroup(StoreTaxGroupRequest $request): RedirectResponse
    {
        try {
            if ($request->is_default) {
                TaxGroup::where('is_default', true)->update(['is_default' => false]);
            }

            TaxGroup::create($request->validated());

            return redirect()
                ->route('admin.finance.taxes.index')
                ->with('success', 'Tax group created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function updateGroup(Request $request, TaxGroup $tax_group): RedirectResponse
    {
        try {
            if ($request->is_default) {
                TaxGroup::where('is_default', false)->update(['is_default' => true]);
            }

            $tax_group->update($request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:1000'],
                'is_active' => ['boolean'],
                'is_default' => ['boolean'],
            ]));

            return redirect()
                ->route('admin.finance.taxes.index')
                ->with('success', 'Tax group updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroyGroup(TaxGroup $tax_group): RedirectResponse
    {
        try {
            if ($tax_group->taxRates()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete group with associated tax rates.');
            }

            $tax_group->delete();

            return redirect()
                ->route('admin.finance.taxes.index')
                ->with('success', 'Tax group deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeRate(StoreTaxRateRequest $request): RedirectResponse
    {
        try {
            TaxRate::create($request->validated());

            return redirect()
                ->route('admin.finance.taxes.index')
                ->with('success', 'Tax rate created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function updateRate(Request $request, TaxRate $tax_rate): RedirectResponse
    {
        try {
            $tax_rate->update($request->validate([
                'tax_group_id' => ['required', 'integer', 'exists:tax_groups,id'],
                'name' => ['required', 'string', 'max:255'],
                'rate' => ['required', 'numeric', 'min:0', 'max:100'],
                'type' => ['nullable', 'string', 'in:percentage,fixed'],
                'region' => ['nullable', 'string', 'max:100'],
                'is_compound' => ['boolean'],
                'priority' => ['nullable', 'integer', 'min:0'],
                'description' => ['nullable', 'string', 'max:1000'],
                'is_active' => ['boolean'],
            ]));

            return redirect()
                ->route('admin.finance.taxes.index')
                ->with('success', 'Tax rate updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroyRate(TaxRate $tax_rate): RedirectResponse
    {
        try {
            $tax_rate->delete();

            return redirect()
                ->route('admin.finance.taxes.index')
                ->with('success', 'Tax rate deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
