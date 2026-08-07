<?php

namespace App\Http\Requests\Purchase;

use App\Http\Requests\BaseRequest;

class GoodsReceiptRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receipt_type' => ['required', 'string', 'in:full,partial,remaining'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required_if:receipt_type,partial', 'nullable', 'array'],
            'items.*' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
