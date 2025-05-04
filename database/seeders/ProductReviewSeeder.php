<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();
        
        // Create 100 reviews
        foreach($products->random(20) as $product) {
            foreach($users->random(rand(1, 5)) as $user) {
                ProductReview::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5), // Most reviews are positive
                    'review' => fake()->paragraph(),
                    'is_approved' => true,
                ]);
            }
        }
    }
}
