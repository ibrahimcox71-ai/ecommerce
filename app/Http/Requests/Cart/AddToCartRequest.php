<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\BaseRequest;
use App\Models\Product;
use App\Models\ProductVariant;

class AddToCartRequest extends BaseRequest
{
    protected ?Product $product = null;
    protected ?ProductVariant $variant = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
            'product_variant_id' => 'nullable|exists:product_variants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product is required.',
            'product_id.exists' => 'Product not found.',
            'quantity.min' => 'Quantity must be at least 1.',
            'quantity.max' => 'Quantity must not exceed 99.',
            'product_variant_id.exists' => 'Variant not found.',
        ];
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $productId = $this->input('product_id');
            $this->product = Product::published()->find($productId);

            if (!$this->product) {
                $validator->errors()->add('product_id', 'Product is not available.');
                return;
            }

            $variantId = $this->input('product_variant_id');
            if ($variantId) {
                $this->variant = $this->product->variants()->where('id', $variantId)->first();
                if (!$this->variant || !$this->variant->status) {
                    $validator->errors()->add('product_variant_id', 'Variant is not available.');
                    return;
                }
                if (!$this->variant->hasStock($this->input('quantity', 1))) {
                    $validator->errors()->add('quantity', 'Insufficient stock for this variant.');
                }
            } elseif (!$this->product->hasStock($this->input('quantity', 1))) {
                $validator->errors()->add('quantity', 'Insufficient stock.');
            }
        });
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getVariant(): ?ProductVariant
    {
        return $this->variant;
    }
}
