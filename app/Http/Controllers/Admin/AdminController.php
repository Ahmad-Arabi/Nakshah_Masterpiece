<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ProductReview;

class AdminController extends Controller
{
    public function dashboard()
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
    
        return view('admin.homepage.index', compact(
            'totalOrders', 'completedOrders', 'pendingOrders', 'monthlyRevenue',
            'totalUsers', 'adminUsers', 'newUsersThisMonth',
            'totalProducts', 'lowStockProducts', 'mostExpensiveProduct', 'mostOrderedItem',
            'totalCoupons', 'activeCoupons', 'mostUsedCoupon',
            'totalReviews', 'pendingReviews'
        ));
    }

}