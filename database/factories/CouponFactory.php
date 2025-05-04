<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    public function definition(): array
    {
        $discountType = $this->faker->randomElement(['fixed', 'percentage']);
        $discount = $discountType === 'fixed' 
            ? $this->faker->numberBetween(5, 50) 
            : $this->faker->numberBetween(5, 50);
            
        return [
            'code' => strtoupper($this->faker->unique()->bothify('????##')),
            'discount' => $discount,
            'discount_type' => $discountType,
            'valid_from' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'valid_to' => $this->faker->dateTimeBetween('now', '+3 months'),
            'is_active' => $this->faker->boolean(80), // 80% chance to be active
        ];
    }
}