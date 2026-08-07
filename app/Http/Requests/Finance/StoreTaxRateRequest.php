<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\BaseRequest;

class StoreTaxRateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tax_group_id' => ['required', 'integer', 'exists:tax_groups,id'],
            'name' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['nullable', 'string', 'in:percentage,fixed'],
            'region' => ['nullable', 'string', 'max:100'],
            'is_compound' => ['boolean'],
            'priority' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ];
    }
}
