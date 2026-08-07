<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreAccountRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:chart_of_accounts,code'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(['asset', 'liability', 'equity', 'revenue', 'expense', 'contra_asset', 'contra_liability', 'contra_equity', 'contra_revenue', 'contra_expense'])],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
            'opening_balance' => ['nullable', 'numeric', 'min:0'],
            'parent_id' => ['nullable', 'integer', 'exists:chart_of_accounts,id'],
        ];
    }
}
