<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->words(2, true)),
            'thumbnail' => $this->faker->fixturesImage('products', 'products'),
            'price' => fake()->numberBetween(1000, 10000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
        ];
    }
}
