<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Orders Overview
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $monthlyRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
    
        // Users Overview
        $totalUsers = User::count();
        $adminUsers = User::where('role', 'admin')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    
        // Products Overview
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('quantity', '<=', 5)->count();
        $mostExpensiveProduct = Product::orderBy('price', 'desc')->first();
        $mostOrderedItem = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->first();
    
        // Coupons Overview - Most Used Coupon
        $totalCoupons = Coupon::count();
        $activeCoupons = Coupon::where('valid_to', '>=', now())->count();
        $mostUsedCoupon = Order::whereNotNull('coupon_id')
            ->selectRaw('coupon_id, COUNT(*) as usage_count')
            ->groupBy('coupon_id')
            ->orderByDesc('usage_count')
            ->first();
    
        // Reviews Overview
        $totalReviews = ProductReview::count();
        $pendingReviews = ProductReview::whereNull('is_approved')->count();


        $mostSold = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(5)
            ->get(['name', 'order_items_count']);
    
        // Lowest Stock Products
        $lowStock = Product::where('quantity', '<=', 5)
            ->orderBy('quantity', 'asc')
            ->limit(5)
            ->get(['name', 'quantity']);
    
        // izes With Low Stock 
        $lowStockSizes = ProductSize::where('stock', '<=', 3)
            ->join('products', 'product_sizes.product_id', '=', 'products.id') // ✅ Joins product name
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get(['product_sizes.size', 'product_sizes.stock', 'products.name as product_name']);
    
        if ($request->ajax()) {
            return response()->json([
                'mostSold' => $mostSold,
                'lowStock' => $lowStock,
                'lowStockSizes' => $lowStockSizes
            ], 200);
        }
    
        return view('admin.homepage.index', compact(
            'totalOrders', 'completedOrders', 'pendingOrders', 'monthlyRevenue',
            'totalUsers', 'adminUsers', 'newUsersThisMonth',
            'totalProducts', 'lowStockProducts', 'mostExpensiveProduct', 'mostOrderedItem',
            'totalCoupons', 'activeCoupons', 'mostUsedCoupon',
            'totalReviews', 'pendingReviews', 'mostSold', 'lowStock', 'lowStockSizes'
        ));
    }

}