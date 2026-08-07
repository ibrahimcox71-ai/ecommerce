<?php

namespace App\Http\Requests\Supplier;

use App\Enums\SupplierStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class BulkUpdateStatusRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:suppliers,id'],
            'status' => ['required', 'string', Rule::in(SupplierStatus::values())],
        ];
    }
}
