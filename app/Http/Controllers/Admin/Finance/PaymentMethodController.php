<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StorePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(): View
    {
        $methods = PaymentMethod::sorted()->paginate(15);

        return view('admin.finance.payment-methods.index', compact('methods'));
    }

    public function store(StorePaymentMethodRequest $request): RedirectResponse
    {
        try {
            if ($request->is_default) {
                PaymentMethod::where('is_default', true)->update(['is_default' => false]);
            }

            PaymentMethod::create($request->validated());

            return redirect()
                ->route('admin.finance.payment-methods.index')
                ->with('success', 'Payment method created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, PaymentMethod $payment_method): RedirectResponse
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'type' => ['required', 'string', 'in:cash,bank,mobile,credit,online,other'],
                'description' => ['nullable', 'string', 'max:1000'],
                'is_active' => ['boolean'],
                'is_default' => ['boolean'],
                'sort_order' => ['nullable', 'integer', 'min:0'],
            ]);

            if ($data['is_default'] ?? false) {
                PaymentMethod::where('is_default', true)->update(['is_default' => false]);
            }

            $payment_method->update($data);

            return redirect()
                ->route('admin.finance.payment-methods.index')
                ->with('success', 'Payment method updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(PaymentMethod $payment_method): RedirectResponse
    {
        try {
            $payment_method->delete();

            return redirect()
                ->route('admin.finance.payment-methods.index')
                ->with('success', 'Payment method deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
