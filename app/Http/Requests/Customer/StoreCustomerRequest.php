<?php

namespace App\Http\Requests\Customer;

use App\Enums\CustomerType;
use App\Enums\Gender;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_group_id' => ['nullable', 'integer', 'exists:customer_groups,id'],
            'customer_type' => ['nullable', 'string', Rule::in(CustomerType::values())],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_registration_number' => ['nullable', 'string', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', Rule::in(Gender::values())],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'password' => ['nullable', 'string', 'min:8'],
            'reward_points' => ['nullable', 'integer', 'min:0'],
            'wallet_balance' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', Rule::in(['active', 'suspended'])],
            'addresses' => ['nullable', 'array'],
            'addresses.*.type' => ['nullable', 'string', Rule::in(['shipping', 'billing', 'both'])],
            'addresses.*.is_default' => ['nullable', 'boolean'],
            'addresses.*.label' => ['nullable', 'string', 'max:100'],
            'addresses.*.name' => ['required_with:addresses', 'string', 'max:255'],
            'addresses.*.phone' => ['nullable', 'string', 'max:20'],
            'addresses.*.address_line_1' => ['required_with:addresses', 'string', 'max:255'],
            'addresses.*.address_line_2' => ['nullable', 'string', 'max:255'],
            'addresses.*.city' => ['required_with:addresses', 'string', 'max:100'],
            'addresses.*.state' => ['nullable', 'string', 'max:100'],
            'addresses.*.postal_code' => ['nullable', 'string', 'max:20'],
            'addresses.*.country' => ['nullable', 'string', 'max:100'],
        ];
    }
}
