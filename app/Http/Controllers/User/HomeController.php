<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Get all categories from the database first (for debugging)
        $allCategories = Category::all();
        Log::info('All categories count: ' . $allCategories->count());
        
        // Get active categories from the database
        $categories = Category::where('isActive', true)->get();
        Log::info('Active categories count: ' . $categories->count());
        
        // Log category details if any exist
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                Log::info('Category: ' . $category->name . ', Image: ' . $category->image . ', Active: ' . $category->isActive);
            }
        }
        
        // Get the 10 most recent active products
        $products = Product::where('isActive', 1)
            ->latest()
            ->take(10)
            ->get();
        Log::info('Active products count: ' . $products->count());
        
        return view('userside.home', compact('categories', 'products'));
    }
}