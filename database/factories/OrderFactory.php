<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $useCoupon = $this->faker->boolean(30); // 30% chance to use coupon
        $couponId = $useCoupon ? Coupon::inRandomOrder()->first()?->id : null;
        $discountApplied = $useCoupon ? $this->faker->randomFloat(2, 5, 50) : 0;
    
        return [
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()?->id ?? User::factory(),
            'total_price' => $this->faker->randomFloat(2, 20, 500),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'canceled']),
            'coupon_id' => $couponId,
            'discount_applied' => $discountApplied,
            'delivery_address' => $this->faker->address(), // ✅ New field
            'phone_number' => $this->faker->phoneNumber(), // ✅ New field
            'shipping_fees' => $this->faker->randomElement(['Free', 5.00]), // ✅ New field
        ];
    }
}