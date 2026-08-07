<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')],
            'category_code' => ['nullable', 'string', 'max:50', Rule::unique('categories', 'category_code')],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],

            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:1024'],
            'icon' => ['nullable', 'string', 'max:100'],

            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', Rule::in(['active', 'inactive', 'draft', 'hidden'])],
            'featured' => ['nullable', 'boolean'],
            'popular' => ['nullable', 'boolean'],
            'show_on_homepage' => ['nullable', 'boolean'],
            'show_in_mega_menu' => ['nullable', 'boolean'],
            'show_in_mobile_menu' => ['nullable', 'boolean'],
            'show_in_sidebar' => ['nullable', 'boolean'],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'seo_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'canonical_url' => ['nullable', 'string', 'url', 'max:500'],
            'json_ld' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name must not exceed 255 characters.',
            'slug.unique' => 'This slug is already in use.',
            'category_code.unique' => 'This category code is already in use.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'status.in' => 'The status must be one of: active, inactive, draft, hidden.',
            'image.max' => 'The image must not exceed 2MB.',
            'banner.max' => 'The banner must not exceed 5MB.',
            'seo_image.max' => 'The SEO image must not exceed 2MB.',
            'canonical_url.url' => 'The canonical URL must be a valid URL.',
        ];
    }
}
