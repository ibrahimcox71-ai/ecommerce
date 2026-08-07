<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 500, 50000);
        $discount = fake()->randomFloat(2, 0, $subtotal * 0.1);
        $tax = fake()->randomFloat(2, 0, $subtotal * 0.05);
        $shipping = fake()->randomFloat(2, 0, 500);
        $total = $subtotal - $discount + $tax + $shipping;

        return [
            'po_number' => Purchase::generatePONumber(),
            'supplier_id' => Supplier::factory(),
            'warehouse_id' => Warehouse::factory(),
            'purchase_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'expected_delivery_date' => fake()->optional()->dateTimeBetween('now', '+2 months'),
            'reference_number' => fake()->optional()->bothify('REF-####-????'),
            'status' => fake()->randomElement(['draft', 'pending', 'approved', 'ordered', 'completed']),
            'payment_status' => fake()->randomElement(['unpaid', 'partial', 'paid']),
            'currency' => 'BDT',
            'exchange_rate' => 1,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'discount_percentage' => $subtotal > 0 ? round($discount / $subtotal * 100, 2) : 0,
            'tax_amount' => $tax,
            'shipping_cost' => $shipping,
            'other_cost' => 0,
            'total_amount' => $total,
            'paid_amount' => 0,
            'due_amount' => $total,
            'notes' => fake()->optional()->sentence(),
            'terms' => fake()->optional()->paragraph(),
            'created_by' => Admin::factory(),
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft']);
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed', 'completed_at' => now()]);
    }
}
