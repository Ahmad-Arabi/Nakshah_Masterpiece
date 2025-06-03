<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public $cookieExpiraton = 1440; // 1 day in minutes
    

    private function getUserCartItems()
    {
        $cartJson = Cookie::get('cart', json_encode([]));
        $allCartItems = json_decode($cartJson, true);
        
        // Filter items for current user
        $userCartItems = [];
        $currentUserId = Auth::id();
        
        if ($currentUserId) {
            foreach ($allCartItems as $itemId => $item) {
                if (isset($item['user_id']) && $item['user_id'] == $currentUserId) {
                    $userCartItems[$itemId] = $item;
                }
            }
        }
        
        return $userCartItems;
    }
    
    /**
     * Save cart items back to cookie
     */
    private function saveCartToCookie($userCartItems)
    {
        // Get all cart items from cookie
        $cartJson = Cookie::get('cart', json_encode([]));
        $allCartItems = json_decode($cartJson, true);
        
        // Remove old items for current user
        $currentUserId = Auth::id();
        foreach ($allCartItems as $itemId => $item) {
            if (isset($item['user_id']) && $item['user_id'] == $currentUserId) {
                unset($allCartItems[$itemId]);
            }
        }
        
        // Add updated user items
        $allCartItems = array_merge($allCartItems, $userCartItems);
        
        // Save back to cookie
        Cookie::queue('cart', json_encode($allCartItems), $this->cookieExpiraton);
    }
    
    /**
     * Display the cart contents
     */
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to view your cart');
        }
        
        $cartItems = $this->getUserCartItems();
        $totalPrice = $this->calculateTotal($cartItems);
        
        return view('userside.cart', compact('cartItems', 'totalPrice'));
    }

    /**
     * Add a product to the cart
     */
    public function addToCart(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to add items to your cart');
        }
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|exists:product_sizes,id',
            'customization_type' => 'required|in:text,image',
        ]);
        
        try {
            // Get product
            $product = Product::findOrFail($request->product_id);
            $productSize = ProductSize::findOrFail($request->size);
            
            // Check if product is active
            if (!$product->isActive) {
                return back()->with('error', 'This product is currently unavailable');
            }
            
            // Check stock availability
            if ($productSize->stock < $request->quantity) {
                return back()->with('error', 'Not enough stock available for the selected size (Only ' . $productSize->stock . ' left)');
            }
            
            // Process customization data
            $customData = [];
            if ($request->customization_type == 'text') {
                $request->validate([
                    'custom_text' => 'required|string|max:100',
                    'text_color' => 'required|string',
                ]);
                $customData['custom_text'] = $request->custom_text;
                $customData['custom_text_color'] = $request->text_color;
                $customData['custom_image'] = null;
            } else {
                // Handle image upload
                if ($request->hasFile('custom_image')) {
                    $request->validate([
                        'custom_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    ]);
                    
                    // Store the image temporarily - will be properly saved on checkout
                    $imagePath = $request->file('custom_image')->store('temp/custom_images', 'public');
                    $customData['custom_image'] = $imagePath;
                    $customData['custom_text'] = null;
                    $customData['custom_text_color'] = null;
                } else {
                    return back()->with('error', 'Please upload an image for custom image option');
                }
            }
            
            // Generate a unique cart item ID
            $cartItemId = uniqid();
            
            // Prepare cart item data with user ID
            $cartItem = [
                'id' => $cartItemId,
                'user_id' => Auth::id(), // Add user ID to cart item
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'size_id' => $productSize->id,
                'size' => $productSize->size,
                'selected_color' => $product->color ?? null,
                'image' => $product->thumbnail ?? 'images/fallback.jpg',
                'customization_type' => $request->customization_type,
                'custom_text' => $customData['custom_text'] ?? null,
                'custom_text_color' => $customData['custom_text_color'] ?? null,
                'custom_image' => $customData['custom_image'] ?? null,
                'subtotal' => $product->price * $request->quantity,
            ];
            
            // Get current user's cart items
            $userCartItems = $this->getUserCartItems();
            
            // Add item to user's cart
            $userCartItems[$cartItemId] = $cartItem;
            
            // Save cart to cookie
            $this->saveCartToCookie($userCartItems);
            
            Log::info('Item added to cart', ['user' => Auth::id(), 'product' => $product->id]);
            
            if($request->action_type == "buyNow") {
                return redirect()->route('checkout');
            } else {

                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
            
        } catch (\Exception $e) {
            Log::error('Error adding item to cart: ' . $e->getMessage());
            return back()->with('error', 'Please make sure to select the required options.');
        }
    }

    /**
     * Update the quantity of a cart item
     */
    public function updateQuantity(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login first']);
        }
        
        $request->validate([
            'item_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $userCartItems = $this->getUserCartItems();
        
        if (isset($userCartItems[$request->item_id])) {
            // Verify this item belongs to the current user
            if ($userCartItems[$request->item_id]['user_id'] != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }
            
            // Get product size to check stock
            $productSize = ProductSize::find($userCartItems[$request->item_id]['size_id']);
            
            if ($productSize && $request->quantity > $productSize->stock) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Not enough stock available',
                    'available' => $productSize->stock
                ]);
            }
            
            // Update quantity and subtotal
            $userCartItems[$request->item_id]['quantity'] = $request->quantity;
            $userCartItems[$request->item_id]['subtotal'] = $userCartItems[$request->item_id]['price'] * $request->quantity;
            
            // Save updated cart
            $this->saveCartToCookie($userCartItems);
            $totalPrice = $this->calculateTotal($userCartItems);
            
            return response()->json([
                'success' => true,
                'subtotal' => number_format($userCartItems[$request->item_id]['subtotal'], 2),
                'total' => number_format($totalPrice, 2)
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Item not found']);
    }

    /**
     * Remove an item from the cart
     */
    public function removeItem($itemId)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to manage your cart');
        }
        
        $userCartItems = $this->getUserCartItems();
        
        if (isset($userCartItems[$itemId])) {
            // Verify this item belongs to the current user
            if ($userCartItems[$itemId]['user_id'] != Auth::id()) {
                return redirect()->route('cart.index')->with('error', 'Unauthorized action');
            }
            
            unset($userCartItems[$itemId]);
            $this->saveCartToCookie($userCartItems);
            
            return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully!');
        }
        
        return redirect()->route('cart.index')->with('error', 'Item not found in cart');
    }
    
    /**
     * Clear the entire cart for current user
     */
    public function clearCart()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to manage your cart');
        }
        
        // Clear only current user's cart items
        $this->saveCartToCookie([]);
        
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
    
    /**
     * Calculate total price of items in cart
     */
    private function calculateTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
}