<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 5, 250), // 2 decimals, 5-250 range
            'desc' => fake()->text(150),
            'stock' => fake()->numberBetween(0, 250),
            'origin' => fake()->country(),
            'tag' => fake()->randomElement(['Headphones', 'Shoes', 'Watches', 'Accessories']),
            'sale' => fake()->numberBetween(0, 1),
        ];
    }
}
