<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreBudgetRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', Rule::in(['monthly', 'quarterly', 'semi_annually', 'annually', 'custom'])],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'notes' => ['nullable', 'string', 'max:2000'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.expense_category_id' => ['nullable', 'integer', 'exists:expense_categories,id'],
            'items.*.category_name' => ['required_without:items.*.expense_category_id', 'nullable', 'string', 'max:255'],
            'items.*.budgeted_amount' => ['required', 'numeric', 'min:0'],
            'items.*.notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
