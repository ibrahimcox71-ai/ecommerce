<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            
            // Pricing
            'price' => $this->price,
            'current_price' => $this->current_price,
            'discount' => $this->discount,
            'discount_percentage' => $this->discount_percentage,
            'has_discount' => $this->has_discount,
            'is_discount_active' => $this->isDiscountActive(),
            'cost_price' => $this->cost_price,
            'profit_margin' => $this->getProfitMargin(),
            
            // Stock
            'stock' => $this->stock,
            'total_stock' => $this->total_stock,
            'unlimited_stock' => $this->unlimited_stock,
            'is_in_stock' => $this->is_in_stock,
            'is_low_stock' => $this->is_low_stock,
            'is_out_of_stock' => $this->is_out_of_stock,
            
            // Descriptions
            'short_description' => $this->short_description,
            'description' => $this->description,
            
            // Media
            'thumbnail' => $this->thumbnail_url,
            'video_url' => $this->video_url,
            
            // Relations
            'category' => new CategoryResource($this->whenLoaded('category')),
            'sub_category' => new SubCategoryResource($this->whenLoaded('subCategory')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            
            // Flags
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'featured' => $this->featured,
            'trending' => $this->trending,
            'best_seller' => $this->best_seller,
            
            // SEO
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'canonical_url' => $this->canonical_url,
            
            // Tags
            'tags' => $this->tags ?? [],
            
            // Specifications
            'specifications' => $this->specifications ?? [],
            
            // Dimensions
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'dimensions' => [
                'length' => $this->length,
                'width' => $this->width,
                'height' => $this->height,
                'unit' => $this->dimension_unit,
            ],
            
            // Warranty
            'warranty' => [
                'type' => $this->warranty_type,
                'period' => $this->warranty_period,
            ],
            
            // Reviews
            'average_rating' => $this->average_rating,
            'review_count' => $this->review_count,
            
            // Timestamps
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
