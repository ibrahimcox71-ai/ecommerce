<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'current_price' => $product->current_price,
                    'has_discount' => $product->has_discount,
                    'stock' => $product->stock,
                    'unlimited_stock' => $product->unlimited_stock,
                    'is_in_stock' => $product->is_in_stock,
                    'thumbnail' => $product->thumbnail_url,
                    'category' => $product->category?->name,
                    'brand' => $product->brand?->name,
                    'status' => $product->status->value,
                    'featured' => $product->featured,
                    'trending' => $product->trending,
                    'best_seller' => $product->best_seller,
                    'average_rating' => $product->average_rating,
                    'review_count' => $product->review_count,
                    'created_at' => $product->created_at?->toIso8601String(),
                ];
            }),
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
            ],
        ];
    }
}
