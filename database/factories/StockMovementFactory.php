<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockMovementFactory extends Factory
{
    protected $model = StockMovement::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 100);

        return [
            'product_id' => Product::factory(),
            'product_variant_id' => null,
            'from_warehouse_id' => null,
            'to_warehouse_id' => Warehouse::factory(),
            'movement_type' => 'stock_in',
            'quantity' => $quantity,
            'quantity_before' => fake()->numberBetween(0, 500),
            'quantity_after' => fn(array $attrs) => $attrs['quantity_before'] + $quantity,
            'reference_number' => StockMovement::generateReferenceNumber(),
            'reason' => fake()->randomElement(['Purchase Order Received', 'Manual Adjustment', 'Return from Customer']),
            'notes' => fake()->optional()->sentence(),
            'causer_type' => Admin::class,
            'causer_id' => Admin::factory(),
        ];
    }

    public function stockIn(): static
    {
        return $this->state(fn(array $attributes) => [
            'movement_type' => 'stock_in',
            'to_warehouse_id' => Warehouse::factory(),
            'from_warehouse_id' => null,
        ]);
    }

    public function stockOut(): static
    {
        $quantity = fake()->numberBetween(1, 50);
        return $this->state(fn(array $attributes) => [
            'movement_type' => 'stock_out',
            'from_warehouse_id' => Warehouse::factory(),
            'to_warehouse_id' => null,
            'quantity' => $quantity,
            'quantity_after' => fn(array $attrs) => max(0, $attrs['quantity_before'] - $quantity),
        ]);
    }

    public function transfer(): static
    {
        return $this->state(fn(array $attributes) => [
            'movement_type' => 'transfer',
            'from_warehouse_id' => Warehouse::factory(),
            'to_warehouse_id' => Warehouse::factory(),
        ]);
    }
}
