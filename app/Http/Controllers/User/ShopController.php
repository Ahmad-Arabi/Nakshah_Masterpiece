<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get the 10 most recent featured and active products
        $featuredProducts = Product::where('isActive', 1)
            ->where('isFeatured', 1)
            ->latest()
            ->take(10)
            ->with('reviews')
            ->get();

        // Get all categories for filters
        $categories = Category::where('isActive', 1)->get();
        
        // Get all available sizes for filter
        $sizes = ProductSize::select('size')
            ->distinct()
            ->whereHas('product', function($query) {
                $query->where('isActive', 1);
            })
            ->get();
            
        // Get all available colors for filter (from the product table)
        $colors = Product::select('color')
            ->distinct()
            ->where('isActive', 1)
            ->whereNotNull('color')
            ->where('color', '!=', '')
            ->get();

        // Query builder for all active products
        $productsQuery = Product::where('isActive', 1);

        // Apply filters if they exist
        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category')) {
            $productsQuery->where('category_id', $request->category);
        }
        
        if ($request->filled('color')) {
            $productsQuery->where('color', $request->color);
        }
        
        if ($request->filled('size')) {
            $productsQuery->whereHas('productSizes', function($query) use ($request) {
                $query->where('size', $request->size);
            });
        }
        
        // Apply sorting
        $sort = $request->get('sort', 'newest');
        
        switch ($sort) {
            case 'price_high':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'price_low':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'newest':
            default:
                $productsQuery->latest();
                break;
        }
        
        // Eager load relationships to improve performance
        $productsQuery->with(['category', 'reviews', 'productSizes']);
        
        // Get the paginated results
        $products = $productsQuery->paginate(8)->withQueryString();
        
        Log::info('Featured products count: ' . $featuredProducts->count());
        Log::info('Total products count: ' . $products->total());
        
        return view('userside.shop', compact(
            'featuredProducts', 
            'products',
            'categories',
            'sizes',
            'colors'
        ));
    }
}