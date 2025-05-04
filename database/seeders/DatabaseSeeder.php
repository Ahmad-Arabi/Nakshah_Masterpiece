<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use Database\Seeders\ProductReviewSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([

            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductReviewSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
