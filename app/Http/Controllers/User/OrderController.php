<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display order confirmation
     */
    public function confirmation(Order $order)
    {
        // Make sure the user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load order items and related products
        $order->load('orderItems.product');

        $shippingFees = 0;

        if ($order->shipping_fees == 5.00) {
            $subTotal = $order->total_price - $order->shipping_fees;
        }


        return view('userside.order-confirmation', compact('order', 'shippingFees'));
    }
    
    /**
     * Display user orders list
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('userside.orders', compact('orders'));
    }
    
    /**
     * Display order details
     */
    public function show(Order $order)
    {
        // Make sure the user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load order items and related products
        $order->load('orderItems.product');
        
        return view('userside.order-details', compact('order'));
    }
}