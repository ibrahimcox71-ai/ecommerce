<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $qty = fake()->numberBetween(1, 100);
        $price = fake()->randomFloat(2, 10, 1000);
        $subtotal = $qty * $price;

        return [
            'product_id' => $product->id,
            'product_variant_id' => null,
            'sku' => $product->sku,
            'product_name' => $product->name,
            'quantity' => $qty,
            'received_quantity' => 0,
            'returned_quantity' => 0,
            'unit_price' => $price,
            'discount' => 0,
            'discount_percentage' => 0,
            'tax' => 0,
            'tax_rate' => 0,
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ];
    }
}
