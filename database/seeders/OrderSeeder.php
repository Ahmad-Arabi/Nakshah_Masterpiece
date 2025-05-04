<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::where('role', 'user')->pluck('id')->toArray();
        $products = Product::all();
    
        Order::factory()->count(30)->create([
            'user_id' => fn() => $userIds[array_rand($userIds)],
            'delivery_address' => fn() => fake()->address(),
            'phone_number' => fn() => fake()->phoneNumber(),
        ])->each(function ($order) use ($products) {
            $itemCount = rand(1, 5);
            $totalPrice = 0;
    
            for ($i = 0; $i < $itemCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;
    
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'selected_color' => $product->color,
                    'selected_size' => ['S', 'M', 'L', 'XL'][array_rand(['S', 'M', 'L', 'XL'])],
                    'custom_text' =>  null, // ✅ Now per item
                    'custom_text_color' => fake()->randomElement(['black', 'blue', 'red', 'green']), // ✅ Now per item
                    'custom_image' =>  null, // ✅ Now per item
                ]);
    
                $totalPrice += ($price * $quantity);
            }
    
            $order->update(['total_price' => $totalPrice - $order->discount_applied]);
        });
    }
}
