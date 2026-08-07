<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();
        if (!$admin) {
            $admin = Admin::factory()->create();
        }

        $suppliers = Supplier::active()->get();
        if ($suppliers->isEmpty()) {
            $suppliers = Supplier::factory(3)->create();
        }

        $warehouses = Warehouse::active()->get();
        if ($warehouses->isEmpty()) {
            $warehouses = Warehouse::factory(2)->create();
        }

        $products = Product::take(10)->get();
        if ($products->isEmpty()) {
            $products = Product::factory(5)->create();
        }

        $statuses = ['draft', 'pending', 'approved', 'ordered', 'partially_received', 'completed', 'cancelled'];

        foreach (range(1, 15) as $i) {
            $supplier = $suppliers->random();
            $warehouse = $warehouses->random();
            $status = $statuses[array_rand($statuses)];

            $items = [];
            $subtotal = 0;

            foreach ($products->random(rand(1, 5)) as $product) {
                $qty = rand(1, 50);
                $price = $product->cost_price ?: rand(10, 500);
                $lineTotal = $qty * $price;
                $subtotal += $lineTotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'sku' => $product->sku,
                    'product_name' => $product->name,
                    'quantity' => $qty,
                    'received_quantity' => $status === 'completed' ? $qty : ($status === 'partially_received' ? rand(1, $qty - 1) : 0),
                    'returned_quantity' => 0,
                    'unit_price' => $price,
                    'discount' => 0,
                    'discount_percentage' => 0,
                    'tax' => 0,
                    'tax_rate' => 0,
                    'subtotal' => $lineTotal,
                    'total' => $lineTotal,
                ];
            }

            $discount = $subtotal > 1000 ? rand(50, 200) : 0;
            $total = $subtotal - $discount;

            $purchase = Purchase::create([
                'po_number' => Purchase::generatePONumber(),
                'supplier_id' => $supplier->id,
                'warehouse_id' => $warehouse->id,
                'purchase_date' => now()->subDays(rand(1, 60)),
                'expected_delivery_date' => now()->addDays(rand(1, 30)),
                'reference_number' => 'REF-' . strtoupper(substr(uniqid(), -8)),
                'status' => $status,
                'payment_status' => $status === 'completed' ? 'paid' : (rand(0, 1) ? 'partial' : 'unpaid'),
                'currency' => 'BDT',
                'exchange_rate' => 1,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'discount_percentage' => $subtotal > 0 ? round($discount / $subtotal * 100, 2) : 0,
                'tax_amount' => 0,
                'shipping_cost' => 0,
                'other_cost' => 0,
                'total_amount' => $total,
                'paid_amount' => $status === 'completed' ? $total : ($status === 'partially_received' ? $total * 0.5 : 0),
                'due_amount' => $status === 'completed' ? 0 : ($status === 'partially_received' ? $total * 0.5 : $total),
                'notes' => 'Seeder generated purchase order',
                'terms' => null,
                'created_by' => $admin->id,
                'approved_by' => in_array($status, ['approved', 'ordered', 'partially_received', 'completed']) ? $admin->id : null,
                'approved_at' => in_array($status, ['approved', 'ordered', 'partially_received', 'completed']) ? now()->subDays(rand(1, 30)) : null,
                'ordered_at' => in_array($status, ['ordered', 'partially_received', 'completed']) ? now()->subDays(rand(1, 20)) : null,
                'completed_at' => $status === 'completed' ? now()->subDays(rand(1, 10)) : null,
            ]);

            foreach ($items as $item) {
                $item['purchase_id'] = $purchase->id;
                PurchaseItem::create($item);
            }
        }
    }
}
