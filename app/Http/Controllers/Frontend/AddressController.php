<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(): View
    {
        $userId = Auth::guard('web')->id();
        $addresses = Address::where('user_id', $userId)
            ->latest()
            ->get();

        return view('customer.addresses', compact('addresses'));
    }

    public function create(): View
    {
        return view('customer.address-form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        $userId = Auth::guard('web')->id();

        if ($request->boolean('is_default')) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
        }

        $validated['user_id'] = $userId;
        Address::create($validated);

        return redirect()->route('customer.addresses')
            ->with('success', 'Address added successfully!');
    }

    public function edit(Address $address): View
    {
        if ($address->user_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        return view('customer.address-form', compact('address'));
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        if ($address->user_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        $userId = Auth::guard('web')->id();

        if ($request->boolean('is_default')) {
            Address::where('user_id', $userId)
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('customer.addresses')
            ->with('success', 'Address updated successfully!');
    }

    public function destroy(Address $address): RedirectResponse
    {
        if ($address->user_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('customer.addresses')
            ->with('success', 'Address deleted successfully!');
    }

    public function setDefault(Address $address): RedirectResponse
    {
        if ($address->user_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        $userId = Auth::guard('web')->id();

        Address::where('user_id', $userId)->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('customer.addresses')
            ->with('success', 'Default address updated!');
    }
}
