<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true),
            'content' => fake()->paragraphs(3, true),
            'status' => true,
        ];
    }
}
