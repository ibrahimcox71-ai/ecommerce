<?php

namespace App\Http\Requests\Supplier;

use App\Enums\SupplierStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('supplier');

        return [
            'supplier_code' => ['nullable', 'string', 'max:50', Rule::unique('suppliers', 'supplier_code')->ignore($id)],
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('suppliers', 'email')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'alternative_phone' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'url', 'max:255'],
            'trade_license_number' => ['nullable', 'string', 'max:100'],
            'tax_vat_number' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'full_address' => ['nullable', 'string', 'max:2000'],
            'description' => ['nullable', 'string', 'max:5000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['nullable', 'string', Rule::in(SupplierStatus::values())],
            'payment_terms' => ['nullable', 'string', 'max:100'],
            'credit_limit' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
            'currency' => ['nullable', 'string', 'max:10'],
            'bank_information' => ['nullable', 'string', 'max:2000'],
            'outstanding_balance' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
            'last_purchase_date' => ['nullable', 'date'],
            'remove_logo' => ['nullable', 'boolean'],
        ];
    }
}
