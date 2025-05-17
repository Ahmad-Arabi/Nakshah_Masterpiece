<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Get user's orders for the order history tab
        $orders = $user->orders()->latest()->get();
        
        return view('profile.edit', [
            'user' => $user,
            'orders' => $orders, // Pass orders directly to the view
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Validate form data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:100'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }
        
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete the user's profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return Redirect::route('profile.edit')->with('success', 'Password updated successfully');
    }

    /**
     * Get order details for display in the user profile.
     */
    public function getOrderDetails(Request $request, $id)
    {
        $user = $request->user();
        
        // Ensure the order belongs to the authenticated user
        $order = $user->orders()->orderBy('created_at', 'asc')->findOrFail($id);
        $orderItems = $order->orderItems()->with('product')->get();
        
        // Format the data for the frontend
        $formattedItems = $orderItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->quantity * $item->price,
                // Make sure thumbnail has the full path
                'thumbnail' => $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : asset('images/fallback.jpg'),
                'options' => [
                    'size' => $item->selected_size,
                    'color' => $item->selected_color,
                    'custom_text' => $item->custom_text,
                    'custom_text_color' => $item->custom_text_color,
                    'custom_image' => $item->custom_image ? asset('storage/' . $item->custom_image) : null,
                ],
            ];
        });

        // Format the order data

        if ($order->shipping_fees == 5.00) {
            $subTotal = $order->total_price - $order->shipping_fees;
            $shippingFees = "5.00 JOD";
        } else {
            $subTotal = $order->total_price;
            $shippingFees = "Free";
        }

        $orderData = [
            'id' => $order->id,
            'status' => ucfirst($order->status),
            'date' => $order->created_at->format('M d, Y'),
            'subtotal' => $subTotal,
            'total_price' => $order->total_price,
            'discount' => $order->discount,
            'delivery_address' => $order->delivery_address,
            'shipping_fees' => $shippingFees,
            'payment_method' => $order->payment_method ?? 'Cash on Delivery',
            'payment_status' => $order->payment_status ?? 'Pending',
        ];

        return response()->json([
            'order' => $orderData,
            'items' => $formattedItems,
        ]);
    }
}
