<?php

namespace App\Http\Requests\Checkout;

use App\Http\Requests\BaseRequest;

class PlaceOrderRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipping_address.name' => 'required|string|max:255',
            'shipping_address.email' => 'required|email|max:255',
            'shipping_address.phone' => 'required|string|max:30',
            'shipping_address.address_line1' => 'required|string|max:255',
            'shipping_address.address_line2' => 'nullable|string|max:255',
            'shipping_address.city' => 'required|string|max:100',
            'shipping_address.state' => 'nullable|string|max:100',
            'shipping_address.zip' => 'nullable|string|max:20',
            'shipping_address.country' => 'required|string|max:100',

            'billing_same' => 'boolean',
            'billing_address.name' => 'required_if:billing_same,false|string|max:255',
            'billing_address.email' => 'required_if:billing_same,false|email|max:255',
            'billing_address.phone' => 'required_if:billing_same,false|string|max:30',
            'billing_address.address_line1' => 'required_if:billing_same,false|string|max:255',
            'billing_address.address_line2' => 'nullable|string|max:255',
            'billing_address.city' => 'required_if:billing_same,false|string|max:100',
            'billing_address.state' => 'nullable|string|max:100',
            'billing_address.zip' => 'nullable|string|max:20',
            'billing_address.country' => 'required_if:billing_same,false|string|max:100',

            'shipping_method' => 'required|string|in:free,standard,express,overnight',
            'payment_method' => 'required|string|in:cod',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_address.name.required' => 'Full name is required.',
            'shipping_address.email.required' => 'Email is required.',
            'shipping_address.email.email' => 'Please enter a valid email.',
            'shipping_address.phone.required' => 'Phone number is required.',
            'shipping_address.address_line1.required' => 'Address is required.',
            'shipping_address.city.required' => 'City is required.',
            'shipping_address.country.required' => 'Country is required.',
            'shipping_method.required' => 'Please select a shipping method.',
            'payment_method.required' => 'Please select a payment method.',
        ];
    }
}
