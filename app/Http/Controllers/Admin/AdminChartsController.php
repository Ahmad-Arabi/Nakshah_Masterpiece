<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AdminChartsController extends Controller
{
    public function products(Request $request) {
        //  Most Sold Products
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
    
        return view('admin.charts.products', compact('mostSold', 'lowStock', 'lowStockSizes'));
    }

    public function index() {
        
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $ordersLastWeek = Order::whereBetween('created_at', [now()->subDays(7), now()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');
            
        // Fill missing dates with zeros
        $chartData = $dates->mapWithKeys(function ($date) use ($ordersLastWeek) {
            return [$date => $ordersLastWeek->get($date, 0)];
        });

        // Format dates for display
        $formattedDates = $chartData->keys()->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('M d');
        });
    
        $ordersChart = (new LarapexChart)
            ->setType('bar')
            ->setTitle('Orders Last 7 Days')
            ->setSubtitle('Last 7 days orders data')
            ->setDataset([
                [
                    'name' => 'Orders',
                    'data' => $chartData->values()->toArray()
                ]
            ])
            ->setXAxis($formattedDates->toArray());
            
    
        // User Growth 
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }
        
        $usersPerMonth = User::whereYear('created_at', '>=', now()->subYear()->year)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->pluck('total', 'month');
            
        $chartUserData = $months->mapWithKeys(function ($month) use ($usersPerMonth) {
            return [$month => $usersPerMonth->get($month, 0)];
        });
        
        // Format months for display
        $formattedMonths = $chartUserData->keys()->map(function($month) {
            return \Carbon\Carbon::parse($month.'-01')->format('M Y');
        });
    
        $userGrowthChart = (new LarapexChart)
            ->setType('line')
            ->setTitle('User Growth (Monthly)')
            ->setSubtitle('Monthly user registration data')
            ->setDataset([
                [
                    'name' => 'Users',
                    'data' => $chartUserData->values()->toArray()
                ]
            ])
            ->setXAxis($formattedMonths->toArray());
    
        //  Revenue By Month 
        $revenuePerMonth = Order::where('status', 'delivered')
            ->whereYear('created_at', '>=', now()->subYear()->year)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as revenue")
            ->groupBy('month')
            ->pluck('revenue', 'month');
            
        $chartRevenueData = $months->mapWithKeys(function ($month) use ($revenuePerMonth) {
            return [$month => $revenuePerMonth->get($month, 0)];
        });
        
        $revenueChart = (new LarapexChart)
            ->setType('area')
            ->setTitle('Revenue by Month (JOD)')
            ->setSubtitle('Monthly revenue from delivered orders')
            ->setDataset([
                [
                    'name' => 'Revenue (JOD)',
                    'data' => $chartRevenueData->values()->toArray()
                ]
            ])
            ->setXAxis($formattedMonths->toArray());
    
        //  Product Stock Levels
        $lowStockProducts = Product::where('quantity', '<=', 5)
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get(['name', 'quantity']);
            
        $stockChart = (new LarapexChart)
            ->setType('donut')  // Changed to donut for better visualization
            ->setTitle('Low Stock Products')
            ->setSubtitle('Products with 5 or less items in stock')
            ->setLabels($lowStockProducts->pluck('name')->toArray())
            ->setDataset($lowStockProducts->pluck('quantity')->toArray());
    
        return view('admin.charts.index', compact(
            'ordersChart', 'userGrowthChart', 'revenueChart', 'stockChart'
        ));
    }
}
