<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrdersController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        $coupons = Coupon::all();
        $query = Order::with(['user:id,name,email', 'coupon:id,code,discount']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%");
            });
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
    
        if ($request->ajax()) {
            return view('admin.orders.table', compact('orders', 'users', 'coupons'))->render();
        }
    
        return view('admin.orders.index', compact('orders', 'users', 'coupons'));
    }

    public function show($id) {
        $order = Order::with([
            'user:id,name,email', 
            'coupon:id,code,discount', 
            'orderItems.product:id,name,color,price,thumbnail'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function create() {
        return view('admin.orders.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'coupon_id'  => 'nullable|exists:coupons,id',
            'total_price' => 'required|numeric|min:0',
            'status'     => 'required|in:pending,processing,shipped,delivered,canceled',
            'delivery_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);
    

        $discountApplied = 0;
 
        if ($request->coupon_id) {
            $coupon = Coupon::find($request->coupon_id);
            if ($coupon) {
                if ($coupon->discount_type === 'fixed') {
                    $discountApplied = min($coupon->discount, $validatedData['total_price']); // Ensure discount doesn't exceed total price
                } elseif ($coupon->discount_type === 'percentage') {
                    $discountApplied = round($validatedData['total_price'] * ($coupon->discount / 100), 2);
                }
            }
        }

        $validatedData['discount_applied'] = $discountApplied;
        $validatedData['total_price'] -= $discountApplied; 
    
        Order::create($validatedData); 
    
        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully!');
    }
    

    public function edit($id) {
        $users = User::all(['id', 'name', 'email']);
        $coupons = Coupon::all(['id', 'code', 'discount']);
        $order = Order::with(['orderItems.product.productSizes'])->findOrFail($id); // ✅ Eager load productSizes
    
        if (request()->ajax()) {
            $view = view('admin.orders.edit', compact('order', 'users', 'coupons'))->render();
            return response()->json(['html' => $view]);
        }
    
        return view('admin.orders.edit', compact('order', 'users', 'coupons'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,canceled',
            'delivery_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'order_items' => 'required|array',
            'order_items.*.selected_size' => 'required|string',
            'order_items.*.custom_image'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order_items.*.custom_text'=> 'nullable|string|max:255',
            'order_items.*.custom_text_color'=> 'nullable|string|max:255',
        ]);
    
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $validatedData['status'],
            'delivery_address' => $validatedData['delivery_address'],
            'phone_number' => $validatedData['phone_number']
        ]);
    
        foreach ($request->order_items as $itemData) {
            $orderItem = OrderItem::where('order_id', $order->id)
                                  ->where('product_id', $itemData['product_id'])
                                  ->first();
    
            if ($orderItem) {
                $oldSize = $orderItem->selected_size;
                $newSize = $itemData['selected_size'];
    
                if ($oldSize !== $newSize) {
                    // ✅ Increase stock for the previous size
                    ProductSize::where('product_id', $itemData['product_id'])
                               ->where('size', $oldSize)
                               ->increment('stock', 1);
    
                    // ✅ Decrease stock for the new size
                    ProductSize::where('product_id', $itemData['product_id'])
                               ->where('size', $newSize)
                               ->decrement('stock', 1);
                }
    
                $orderItem->update(['selected_size' => $newSize]);
            }

            if (isset($itemData['custom_image'])) {
                $oldImage = $orderItem->custom_image;
                $newImage = $itemData['custom_image'] ?? null;
                if ( $newImage !== $oldImage) {
                    $imagePath = $itemData['custom_image']->store('order_images/' . $order->id . '/', 'public');
                    $orderItem->update(['custom_image' => $imagePath]);
                }
            }
            
            if ($orderItem->custom_text !== null) {
                $oldText = $orderItem->custom_text;
                $newText = $itemData['custom_text'] ?? null;
                if ($newText !== $oldText) {
                    $orderItem->update(['custom_text' => $newText]);
                }
            }

            if ($orderItem->custom_text_color !== null) {
                $oldTextColor = $orderItem->custom_text_color;
                $newTextColor = $itemData['custom_text_color'] ?? null;
                if ($newTextColor !== $oldTextColor) {
                    $orderItem->update(['custom_text_color' => $newTextColor]);
                }
            }
        }
        
    
        return redirect()->back()->with('success', 'Order updated successfully!');
    }

    public function destroy($id) {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}