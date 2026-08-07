<?php

namespace App\Http\Requests\Finance;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreJournalEntryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(['standard', 'adjusting', 'closing', 'reversing', 'opening'])],
            'description' => ['nullable', 'string', 'max:500'],
            'entry_date' => ['required', 'date'],
            'finance_period_id' => ['nullable', 'integer', 'exists:finance_periods,id'],
            'notes' => ['nullable', 'string', 'max:2000'],

            'items' => ['required', 'array', 'min:2'],
            'items.*.chart_of_account_id' => ['required', 'integer', 'exists:chart_of_accounts,id'],
            'items.*.description' => ['nullable', 'string', 'max:500'],
            'items.*.debit' => ['required_without:items.*.credit', 'nullable', 'numeric', 'min:0'],
            'items.*.credit' => ['required_without:items.*.debit', 'nullable', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            $totalDebit = collect($items)->sum('debit');
            $totalCredit = collect($items)->sum('credit');

            if (abs($totalDebit - $totalCredit) > 0.01) {
                $validator->errors()->add('items', 'Total debits (' . number_format($totalDebit, 2) . ') must equal total credits (' . number_format($totalCredit, 2) . '). Difference: ' . number_format(abs($totalDebit - $totalCredit), 2));
            }
        });
    }
}
