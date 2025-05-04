<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'T-Shirts',
            'Hoodies',
            'Sweatshirts',
            'Jackets',
            'Polos',
            'Tank Tops',
            'Customized',
            'Accessories'
        ];
        
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'isActive' => true,
            ]);
        }
        
        // Create some additional random categories
        Category::factory()->count(3)->create();
    }
}
