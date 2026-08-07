<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $warehouses = Warehouse::where('status', true)->get();

        if ($products->isEmpty() || $warehouses->isEmpty()) {
            $this->command?->warn('Products or Warehouses not found. Skipping inventory seeding.');
            return;
        }

        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                $quantity = fake()->numberBetween(0, 500);
                $reserved = fake()->numberBetween(0, min(50, $quantity));

                Inventory::create([
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => $quantity,
                    'reserved_quantity' => $reserved,
                    'incoming_stock' => fake()->numberBetween(0, 100),
                    'damaged_stock' => fake()->numberBetween(0, min(10, $quantity)),
                    'returned_stock' => fake()->numberBetween(0, 20),
                    'low_stock_threshold' => 10,
                    'minimum_stock' => 5,
                    'maximum_stock' => 1000,
                    'reorder_level' => 20,
                ]);

                if ($product->variants()->exists()) {
                    foreach ($product->variants as $variant) {
                        $varQty = fake()->numberBetween(0, 200);
                        Inventory::create([
                            'product_id' => $product->id,
                            'product_variant_id' => $variant->id,
                            'warehouse_id' => $warehouse->id,
                            'quantity' => $varQty,
                            'reserved_quantity' => fake()->numberBetween(0, min(20, $varQty)),
                            'incoming_stock' => fake()->numberBetween(0, 50),
                            'damaged_stock' => 0,
                            'returned_stock' => 0,
                            'low_stock_threshold' => 5,
                            'minimum_stock' => 2,
                            'maximum_stock' => 500,
                            'reorder_level' => 10,
                        ]);
                    }
                }
            }
        }

        $this->command?->info('Inventory records seeded successfully.');
    }
}
