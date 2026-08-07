<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryLogFactory extends Factory
{
    protected $model = InventoryLog::class;

    public function definition(): array
    {
        $before = fake()->numberBetween(0, 500);
        $change = fake()->numberBetween(-100, 100);
        $after = max(0, $before + $change);

        return [
            'product_id' => Product::factory(),
            'product_variant_id' => null,
            'warehouse_id' => Warehouse::factory(),
            'reference_type' => fake()->randomElement(['add', 'subtract', 'reserve', 'release', 'adjustment']),
            'reference_id' => null,
            'quantity_before' => $before,
            'quantity_after' => $after,
            'quantity_change' => $change,
            'reason' => fake()->randomElement(['Stock In', 'Stock Out', 'Manual Adjustment', 'Order Fulfillment', 'Return']),
            'note' => fake()->optional()->sentence(),
            'causer_type' => Admin::class,
            'causer_id' => Admin::factory(),
        ];
    }

    public function increase(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantity_change' => fake()->numberBetween(10, 200),
        ]);
    }

    public function decrease(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantity_change' => fake()->numberBetween(-200, -10),
        ]);
    }
}
