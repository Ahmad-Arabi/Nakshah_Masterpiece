<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Only show active products
        if (!$product->isActive) {
            abort(404);
        }
        
        // Load relationships needed for product details
        $product->load([
            'category', 
            'productSizes',
            'reviews' => function($query) {
                $query->where('is_approved', 1);
            }
        ]);
        
        // Get related products from the same category
        $relatedProducts = Product::where('isActive', 1)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get();
            
        Log::info('Showing product: ' . $product->name);
        
        return view('userside.product', compact('product', 'relatedProducts'));
    }
}