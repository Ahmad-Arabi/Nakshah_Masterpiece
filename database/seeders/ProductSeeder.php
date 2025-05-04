<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get all category IDs
        $categoryIds = Category::pluck('id')->toArray();
        
        // Create 50 products
        Product::factory()->count(50)->create([
            'category_id' => fn() => $categoryIds[array_rand($categoryIds)],
        ])->each(function ($product) {
            // Add sizes for each product
            $sizes = ['S', 'M', 'L', 'XL'];
            foreach ($sizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'stock' => rand(0, 30),
                ]);
            }
        });
    }
}
