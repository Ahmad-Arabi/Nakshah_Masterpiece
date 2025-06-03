<?php

namespace App\Providers;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart count with all views
        View::composer('*', function ($view) {
            $userCartCount = 0;
            
            if (Auth::check()) {
                $cartJson = Cookie::get('cart', json_encode([]));
                $allCartItems = json_decode($cartJson, true);
                
                $currentUserId = Auth::id();
                
                foreach ($allCartItems as $item) {
                    if (isset($item['user_id']) && $item['user_id'] == $currentUserId) {
                        $userCartCount++;
                    }
                }
            }

            $featuredCoupons = Coupon::where('is_featured', 1)->get();

                foreach ($featuredCoupons as $coupon) {
                    if ($coupon->discount_type === 'percentage') {
                        $coupon->discount = $coupon->discount . '%';
                    } else {
                        $coupon->discount =  $coupon->discount . ' JOD';
                    }
                }
            
            $view->with('userCartCount', $userCartCount)
                 ->with('featuredCoupons', $featuredCoupons);
        });
    }
    
}
