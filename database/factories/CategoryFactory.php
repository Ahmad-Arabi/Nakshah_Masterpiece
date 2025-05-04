<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'image' => 'categories/' . $this->faker->numberBetween(1, 5) . '.jpg',
            'isActive' => $this->faker->boolean(80), // 80% chance to be active
        ];
    }
}