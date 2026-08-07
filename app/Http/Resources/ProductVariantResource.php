<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'price' => $this->price ?? $this->product->price,
            'current_price' => $this->current_price,
            'discount' => $this->discount,
            'cost_price' => $this->cost_price,
            'stock' => $this->stock,
            'unlimited_stock' => $this->unlimited_stock,
            'is_in_stock' => $this->is_in_stock,
            'image' => $this->image_url,
            'weight' => $this->weight,
            'status' => $this->status,
            'attributes' => $this->whenLoaded('attributeValues', function () {
                return $this->attributeValues->map(function ($av) {
                    return [
                        'attribute' => $av->attribute->name,
                        'value' => $av->display_value,
                        'color' => $av->attributeValue?->color,
                        'image' => $av->attributeValue?->image_url,
                    ];
                });
            }),
        ];
    }
}
