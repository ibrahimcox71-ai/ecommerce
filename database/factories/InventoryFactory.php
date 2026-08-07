<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'product_variant_id' => null,
            'warehouse_id' => Warehouse::factory(),
            'quantity' => fake()->numberBetween(0, 500),
            'reserved_quantity' => fake()->numberBetween(0, 50),
            'incoming_stock' => fake()->numberBetween(0, 100),
            'damaged_stock' => fake()->numberBetween(0, 10),
            'returned_stock' => fake()->numberBetween(0, 20),
            'low_stock_threshold' => 10,
            'minimum_stock' => 5,
            'maximum_stock' => 1000,
            'reorder_level' => 20,
        ];
    }

    public function lowStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantity' => fake()->numberBetween(1, 10),
            'reserved_quantity' => 0,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantity' => 0,
            'reserved_quantity' => 0,
        ]);
    }

    public function inStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantity' => fake()->numberBetween(50, 500),
            'reserved_quantity' => fake()->numberBetween(0, 30),
        ]);
    }
}
