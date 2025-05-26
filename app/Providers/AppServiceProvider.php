<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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
            
            $view->with('userCartCount', $userCartCount);
        });
    }
}
