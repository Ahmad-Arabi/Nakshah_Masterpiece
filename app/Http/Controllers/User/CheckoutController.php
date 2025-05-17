<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index()
    {
        // Get cart items from cookie
        $cartItemsJson = Cookie::get('cart', json_encode([]));
        $cartItems = json_decode($cartItemsJson, true);
        
        // If cart is empty, redirect to cart page
        if (empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('info', 'Your cart is empty. Please add some products before checkout.');
        }
        
        // Get user details
        $user = Auth::user();
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['subtotal'];
        }
        
        // Session variables for order information
        $discount = session('checkout.discount', 0);
        $appliedCoupon = session('checkout.coupon');
        $totalPrice = $subtotal - $discount;

        $shippingFees = 0;

        if ($totalPrice < 50) {
            $shippingFees = 5.00;
            $totalPrice += $shippingFees;
        } else {
            $shippingFees = "Free";
        }
        
        return view('userside.checkout', compact(
            'cartItems', 
            'subtotal', 
            'discount', 
            'totalPrice', 
            'user',
            'appliedCoupon',
            'shippingFees'
        ));
    }
    
    /**
     * Apply a coupon code to the order
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);
        
        $code = $request->coupon_code;
        $now = now();
        
        // Find the coupon
        $coupon = Coupon::where('code', $code)
            ->where('is_active', 1)
            ->where('valid_from', '<=', $now)
            ->where('valid_to', '>=', $now)
            ->first();
        
        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }
        
        // Get cart items from cookie
        $cartItemsJson = Cookie::get('cart', json_encode([]));
        $cartItems = json_decode($cartItemsJson, true);
        
        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['subtotal'];
        }
        
        // Calculate discount
        $discount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discount = ($coupon->discount / 100) * $subtotal;
        } else {
            $discount = $coupon->discount;
        }
        
        // Store discount and coupon in session
        session(['checkout.discount' => $discount]);
        session(['checkout.coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $coupon->discount,
            'discount_type' => $coupon->discount_type
        ]]);
        
        return back()->with('success', 'Coupon applied successfully!');
    }
    
    /**
     * Remove applied coupon
     */
    public function removeCoupon()
    {
        session()->forget('checkout.discount');
        session()->forget('checkout.coupon');
        
        return back()->with('success', 'Coupon removed successfully!');
    }
    
    /**
     * Process and store the order
     */
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_method' => 'required|in:cash_on_delivery,credit_card',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Get cart items from cookie
        $cartItemsJson = Cookie::get('cart', json_encode([]));
        $cartItems = json_decode($cartItemsJson, true);
        
        // If cart is empty, redirect to cart page
        if (empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('info', 'Your cart is empty. Please add some products before checkout.');
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['subtotal'];
        }
        
        // Get applied coupon and discount from session
        $discount = session('checkout.discount', 0);
        $appliedCoupon = session('checkout.coupon');
        $totalPrice = $subtotal - $discount;

         $shippingFees = 0;

        if ($totalPrice < 50) {
            $shippingFees = 5.00;
            $totalPrice += $shippingFees;
        } else {
            $shippingFees = "Free";
        }
        
        try {
            
            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'phone_number' => $request->phone_number,
                'coupon_id' => $appliedCoupon['id'] ?? null,
                'discount_applied' => $discount,
                'shipping_fees' => $shippingFees,
                'payment_method' => $request->payment_method,
            ]);
            
            // Add each item to the order
            foreach ($cartItems as $item) {
                // Create the order item
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'selected_color' => $item['selected_color'],
                    'selected_size' => $item['size'],
                    'custom_text' => $item['custom_text'],
                    'custom_text_color' => $item['custom_text_color'],
                ]);
                
                // Handle custom image if present
                if (!empty($item['custom_image'])) {
                    // Move image from temp storage to permanent storage
                    if (Storage::disk('public')->exists($item['custom_image'])) {
                        $newPath = 'order_images/' . $order->id . '/' . basename($item['custom_image']);
                        Storage::disk('public')->copy($item['custom_image'], $newPath);
                        
                        // Update the order item with the new path
                        $orderItem->custom_image = $newPath;
                        $orderItem->save();
                        
                        // Delete temp file
                        Storage::disk('public')->delete($item['custom_image']);
                    }
                }
                
                // Update product stock
                $productSize = ProductSize::where('id', $item['size_id'])->first();
                if ($productSize) {
                    $productSize->stock -= $item['quantity'];
                    $productSize->save();
                }
            }

            //check for stripe payment
            if ($request->payment_method === "credit_card") {
            try {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $charge = $stripe->charges->create([
                    'amount' => ceil($totalPrice * 100 * 1.41), // Convert amount
                    'currency' => 'usd',
                    'source' => $request->stripeToken,
                    'description' => 'Nakshah Order#' . $order->id . ' Payment',    
                ]);

                // If charge fails, throw an exception
                if (!$charge) {
                    throw new \Exception("Stripe charge failed");
                }
                } catch (\Exception $e) {
                return back()->with('error', 'Payment failed: ' . $e->getMessage());
                }
            }


            
            // Clear cart and checkout session data
            Cookie::queue(Cookie::forget('cart'));
            session()->forget('checkout');
            
            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Your order has been placed successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'There was an issue processing your order. Please try again.');
        }
    }
    
}