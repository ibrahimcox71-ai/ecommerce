<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'barcode' => ['nullable', 'string', 'max:100', 'unique:products,barcode'],
            'product_type' => ['nullable', 'string', 'in:simple,variable,digital'],

            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'child_category_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],

            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],

            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:500'],

            'price' => ['required', 'numeric', 'min:0', 'max:999999999.99'],
            'cost_price' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'tax' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'tax_type' => ['nullable', 'string', 'in:exclusive,inclusive'],
            'currency' => ['nullable', 'string', 'max:3'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'discount_type' => ['nullable', 'string', 'in:percentage,fixed'],
            'discount_start' => ['nullable', 'date', 'after_or_equal:today'],
            'discount_end' => ['nullable', 'date', 'after:discount_start'],

            'stock' => ['required', 'integer', 'min:0'],
            'unlimited_stock' => ['nullable', 'boolean'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'min_stock' => ['nullable', 'integer', 'min:0'],

            'status' => ['nullable', 'string', Rule::enum(ProductStatus::class)],
            'featured' => ['nullable', 'boolean'],
            'trending' => ['nullable', 'boolean'],
            'best_seller' => ['nullable', 'boolean'],
            'is_hidden' => ['nullable', 'boolean'],
            'is_new_arrival' => ['nullable', 'boolean'],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'schema_markup' => ['nullable', 'string'],

            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:100'],

            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['required', 'string', 'max:100'],
            'specifications.*.value' => ['required', 'string', 'max:500'],

            'weight' => ['nullable', 'numeric', 'min:0'],
            'weight_unit' => ['nullable', 'string', 'in:kg,g,lb,oz'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'dimension_unit' => ['nullable', 'string', 'in:cm,m,inch,ft'],

            'warranty_type' => ['nullable', 'string', 'in:no_warranty,manufacturer,seller'],
            'warranty_period' => ['nullable', 'integer', 'min:1'],

            'is_virtual' => ['nullable', 'boolean'],
            'download_link' => ['nullable', 'url', 'max:500'],
            'min_order_quantity' => ['nullable', 'integer', 'min:1'],
            'max_order_quantity' => ['nullable', 'integer', 'min:1', 'gte:min_order_quantity'],

            'sort_order' => ['nullable', 'integer', 'min:0'],

            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'images' => ['nullable', 'array'],
            'images.*.id' => ['nullable', 'integer'],
            'images.*.image' => ['required', 'string'],
            'images.*.alt_text' => ['nullable', 'string', 'max:255'],
            'images.*.title' => ['nullable', 'string', 'max:255'],
            'images.*.is_primary' => ['nullable', 'boolean'],
            'images.*.sort_order' => ['nullable', 'integer'],

            'variants' => ['nullable', 'array'],
            'variants.*.id' => ['nullable', 'integer', 'exists:product_variants,id'],
            'variants.*.name' => ['required_with:variants', 'string', 'max:255'],
            'variants.*.sku' => ['nullable', 'string', 'max:100'],
            'variants.*.barcode' => ['nullable', 'string', 'max:100'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.discount' => ['nullable', 'numeric', 'min:0'],
            'variants.*.cost_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.unlimited_stock' => ['nullable', 'boolean'],
            'variants.*.status' => ['nullable', 'boolean'],
            'variants.*.weight' => ['nullable', 'numeric', 'min:0'],
            'variants.*.image' => ['nullable', 'string'],
            'variants.*.attribute_values' => ['nullable', 'array'],
            'variants.*.attribute_values.*' => ['integer', 'exists:attribute_values,id'],

            'warehouses' => ['nullable', 'array'],
            'warehouses.*.warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'warehouses.*.is_default' => ['nullable', 'boolean'],
            'warehouses.*.lead_time' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'sub_category_id.exists' => 'Selected sub-category does not exist.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'price.required' => 'Product price is required.',
            'price.min' => 'Price cannot be negative.',
            'stock.required' => 'Stock quantity is required.',
            'discount_end.after' => 'Discount end date must be after start date.',
            'sku.unique' => 'This SKU is already in use.',
            'barcode.unique' => 'This barcode is already in use.',
            'slug.unique' => 'This URL slug is already in use.',
            'variants.*.name.required_with' => 'Variant name is required.',
            'gallery.*.max' => 'Each image must not exceed 5MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'unlimited_stock' => $this->boolean('unlimited_stock'),
            'featured' => $this->boolean('featured'),
            'trending' => $this->boolean('trending'),
            'best_seller' => $this->boolean('best_seller'),
            'is_hidden' => $this->boolean('is_hidden'),
            'is_new_arrival' => $this->boolean('is_new_arrival'),
            'is_virtual' => $this->boolean('is_virtual'),
            'product_type' => $this->input('product_type', 'simple'),
        ]);

        if ($this->has('tags_string') && is_string($this->tags_string)) {
            $this->merge([
                'tags' => array_map('trim', explode(',', $this->tags_string)),
            ]);
        }

        if (!$this->has('status')) {
            $this->merge(['status' => ProductStatus::Draft]);
        }
    }
}
