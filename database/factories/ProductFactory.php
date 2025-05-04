<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->words(3, true),
            'color' => $this->faker->randomElement(['Red', 'Blue', 'Green', 'Black', 'White', 'Grey', 'Purple', 'Yellow']),
            'price' => $this->faker->randomFloat(2, 9.99, 199.99),
            'quantity' => $this->faker->numberBetween(0, 100),
            'thumbnail' => null,
            'image1' => null,
            'image2' => null,
            'isActive' => $this->faker->boolean(90), // 90% chance to be active
            'isFeatured' => $this->faker->boolean(20), // 20% chance to be featured
        ];
    }
}