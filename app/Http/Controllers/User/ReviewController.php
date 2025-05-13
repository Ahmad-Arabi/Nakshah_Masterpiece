<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display the review form for a specific product
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to write a review');
        }
        
        // Check if user has already reviewed this product
        $existingReview = ProductReview::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReview) {
            return redirect()->route('product.show', $product)->with('error', 'You have already reviewed this product');
        }
        
        return view('userside.review', compact('product'));
    }
    
    /**
     * Store a newly created review in storage
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        // Validate the request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:500'
        ]);
        
        // Create the review
        $review = new ProductReview([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'is_approved' => null // Pending approval
        ]);
        
        $review->save();
        
        return redirect()->route('product.show', $product)->with('success', 'Your review has been submitted and is awaiting approval');
    }
}