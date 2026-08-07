<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\BaseRequest;

class StoreTaxGroupRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
            'is_default' => ['boolean'],
        ];
    }
}
