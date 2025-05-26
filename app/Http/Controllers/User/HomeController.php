<?php

namespace App\Http\Controllers\User;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            ->whereHas('category', function ($query) {
                $query->where('isActive', 1);
            })
            ->latest()
            ->take(10)
            ->get();
        Log::info('Active products count: ' . $products->count());

        $featuredCoupons = Coupon::where('is_featured', 1)->get();

        foreach ($featuredCoupons as $coupon) {
            if ($coupon->discount_type === 'percentage') {
                $coupon->discount = $coupon->discount . '%';
            } else {
                $coupon->discount =  $coupon->discount . ' JOD';
            }
        }

        return view('userside.home', compact('categories', 'products', 'featuredCoupons'));
    }
}