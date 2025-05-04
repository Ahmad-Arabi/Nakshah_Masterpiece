<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'product_id' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->boolean(80) ? $this->faker->paragraph() : null,
            'is_approved' => $this->faker->boolean(70), // 70% chance to be approved
        ];
    }
}