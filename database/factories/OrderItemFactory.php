<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $product->price,
            'selected_color' => $product->color,
            'selected_size' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
            'custom_text' => $this->faker->boolean(20) ? $this->faker->sentence() : null, // ✅ New: Random print text per item
            'custom_text_color' => $this->faker->randomElement(['black', 'blue', 'red', 'green']), // ✅ New: Random text color
            'custom_image' => $this->faker->boolean(10) ? 'custom/' . $this->faker->numberBetween(1, 5) . '.jpg' : null, // ✅ New: Custom image per item
        ];
    }
}