<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class BulkEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:products,id'],
            'fields' => ['required', 'array'],
            'fields.price' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'fields.cost_price' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'fields.stock' => ['nullable', 'integer', 'min:0'],
            'fields.status' => ['nullable', 'string', 'in:active,inactive,draft,archived,hidden'],
            'fields.category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'fields.brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'fields.featured' => ['nullable', 'boolean'],
            'fields.trending' => ['nullable', 'boolean'],
            'fields.best_seller' => ['nullable', 'boolean'],
            'fields.tax' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fields.discount' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'fields.low_stock_threshold' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('fields')) {
            $fields = $this->fields;
            if (isset($fields['featured'])) {
                $fields['featured'] = filter_var($fields['featured'], FILTER_VALIDATE_BOOLEAN);
            }
            if (isset($fields['trending'])) {
                $fields['trending'] = filter_var($fields['trending'], FILTER_VALIDATE_BOOLEAN);
            }
            if (isset($fields['best_seller'])) {
                $fields['best_seller'] = filter_var($fields['best_seller'], FILTER_VALIDATE_BOOLEAN);
            }
            $this->merge(['fields' => $fields]);
        }
    }
}
