<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get cart count for the current authenticated user
     */
    protected function getUserCartCount()
    {
        if (!Auth::check()) {
            return 0;
        }

        $cartJson = Cookie::get('cart', json_encode([]));
        $allCartItems = json_decode($cartJson, true);

        $userCartCount = 0;
        $currentUserId = Auth::id();

        foreach ($allCartItems as $item) {
            if (isset($item['user_id']) && $item['user_id'] == $currentUserId) {
                $userCartCount++;
            }
        }

        return $userCartCount;
    }
}
