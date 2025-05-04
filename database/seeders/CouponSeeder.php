<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // Create fixed amount coupons
        Coupon::factory()->count(5)->create([
            'discount_type' => 'fixed',
            'discount' => function() {
                return rand(5, 50);
            },
        ]);
        
        // Create percentage coupons
        Coupon::factory()->count(5)->create([
            'discount_type' => 'percentage',
            'discount' => function() {
                return rand(5, 50);
            },
        ]);
    }
}
