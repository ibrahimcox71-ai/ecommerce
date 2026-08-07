<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city() . ' Warehouse',
            'manager_name' => fake()->name(),
            'code' => 'WH-' . strtoupper(fake()->unique()->bothify('####')),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'is_default' => false,
            'status' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => ['status' => true]);
    }

    public function default(): static
    {
        return $this->state(fn(array $attributes) => ['is_default' => true, 'status' => true]);
    }
}
