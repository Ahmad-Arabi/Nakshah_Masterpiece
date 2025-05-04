<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Models\Product;

class AdminReviewsController extends Controller
{
    public function index(Request $request) {
        $query = ProductReview::with(['user', 'product'])->orderBy('is_approved', 'asc');
    
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'LIKE', "%{$request->search}%");
            });
        }
    
        if ($request->filled('product')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->product}%");
            });
        }
    
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
    
        if ($request->filled('is_approved')) {
            if ($request->is_approved === 'null') {
                $query->whereNull('is_approved');
            } else {
                $query->where('is_approved', $request->is_approved);
            }
        }
    
        $reviews = $query->paginate(7);
    
        if ($request->ajax()) {
            return view('admin.reviews.table', compact('reviews'))->render();
        }
    
        return view('admin.reviews.index', compact('reviews'));
    }


    public function update(Request $request, $id, $actionType) {

    $review = ProductReview::findOrFail($id);

        if ($actionType === 'approve') {
            $review->is_approved = 1;
            $message = 'The review has been approved successfully!';
        } elseif ($actionType === 'reject') {
            $review->is_approved = 0;
            $message = 'The review has been rejected successfully!';
        } else {
            return redirect()->back()->with('error', 'Invalid action.');
        }
        $review->save();

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        dd($review);
        $review->delete(); // This sets the 'deleted_at' timestamp
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }
}