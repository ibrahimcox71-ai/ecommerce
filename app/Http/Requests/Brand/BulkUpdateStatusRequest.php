<?php

namespace App\Http\Requests\Brand;

use App\Enums\BrandStatus;
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
            'ids.*' => ['required', 'integer', 'exists:brands,id'],
            'status' => ['required', 'string', Rule::in(BrandStatus::values())],
        ];
    }
}
