<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->company();

        return [
            'brand_code' => 'BRN-' . strtoupper(fake()->unique()->bothify('####')),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(4),
            'description' => fake()->paragraph(),
            'website' => fake()->url(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'country' => fake()->country(),
            'sort_order' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(['active', 'inactive', 'hidden']),
            'featured' => fake()->boolean(20),
            'popular' => fake()->boolean(15),
            'is_hidden' => false,
            'meta_title' => fake()->sentence(6),
            'meta_description' => fake()->sentence(12),
            'meta_keywords' => implode(', ', fake()->words(5)),
            'canonical_url' => fake()->url(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'active']);
    }

    public function featured(): static
    {
        return $this->state(fn(array $attributes) => ['featured' => true]);
    }

    public function popular(): static
    {
        return $this->state(fn(array $attributes) => ['popular' => true]);
    }
}
