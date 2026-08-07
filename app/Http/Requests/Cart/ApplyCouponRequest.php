<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;

class ApplyCouponRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Coupon code is required.',
        ];
    }
}
