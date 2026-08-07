<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'supplier_code' => Supplier::generateCode(),
            'name' => fake()->company(),
            'company_name' => fake()->company(),
            'contact_person' => fake()->name(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'alternative_phone' => fake()->optional(0.3)->phoneNumber(),
            'website' => fake()->optional(0.7)->url(),
            'trade_license_number' => strtoupper(fake()->bothify('TL-####-????')),
            'tax_vat_number' => fake()->bothify('VAT-########'),
            'country' => fake()->country(),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'full_address' => fake()->address(),
            'description' => fake()->optional(0.6)->paragraph(),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']),
            'payment_terms' => fake()->randomElement(['Net 15', 'Net 30', 'Net 45', 'Net 60', 'Due on Receipt']),
            'credit_limit' => fake()->optional(0.7)->randomFloat(2, 1000, 100000),
            'currency' => fake()->randomElement(['USD', 'EUR', 'GBP', 'BDT']),
            'bank_information' => fake()->optional(0.5)->text(200),
            'outstanding_balance' => fake()->randomFloat(2, 0, 50000),
            'last_purchase_date' => fake()->optional(0.6)->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn() => ['status' => 'active']);
    }

    public function inactive(): static
    {
        return $this->state(fn() => ['status' => 'inactive']);
    }
}
