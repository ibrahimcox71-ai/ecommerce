<?php

namespace App\Http\Requests\Inventory;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class DirectAdjustmentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'product_variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'adjustment_type' => ['required', 'string', Rule::in(['add', 'subtract', 'set'])],
            'new_quantity' => ['required_if:adjustment_type,set', 'nullable', 'integer', 'min:0'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
