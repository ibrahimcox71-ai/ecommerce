<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;

class UpdateCartRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:0|max:99',
        ];
    }

    public function messages(): array
    {
        return [
            'item_id.required' => 'Cart item is required.',
            'item_id.exists' => 'Cart item not found.',
            'quantity.min' => 'Quantity cannot be negative.',
        ];
    }
}
