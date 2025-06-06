<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ContactUsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminChartsController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminCouponsController;
use App\Http\Controllers\Admin\AdminReviewsController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminContactUsController;
use App\Http\Controllers\Admin\AdminCategoriesController;


Route::get('/',[HomeController::class, 'index'])->name('home');

// User Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Review Routes
Route::get('/products/{product}/review', [ReviewController::class, 'create'])->name('product.review.create')->middleware('auth');
Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('product.review.store')->middleware('auth');

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/checkout/coupon/remove', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
   
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.details');
    Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');
});

//Contact Us
Route::get('/contact', [ContactUsController::class, 'index'])->name('user.contactUs');
Route::post('/contact', [ContactUsController::class, 'store'])->name('user.contactUs.store');

//About Us
Route::get('/about', function() {
    return view('userside.about');
})->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders/{id}/details', [ProfileController::class, 'getOrderDetails'])->name('orders.details');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
        
    //users CRUD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('homepage.index');

    //users CRUD
    Route::get('/users', [AdminUsersController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [AdminUsersController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/create', [AdminUsersController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUsersController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminUsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUsersController::class, 'update'])->name('users.update');
    Route::get('/users/{id}', [AdminUsersController::class, 'show'])->name('users.show');

    // //categories CRUD
    Route::get('/categories', [AdminCategoriesController::class, 'index'])->name('categories.index');
    Route::delete('/categories/{id}', [AdminCategoriesController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/create', [AdminCategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoriesController::class, 'update'])->name('categories.update');
    
    // //Products CRUD
    Route::get('/products', [AdminProductsController::class, 'index'])->name('products.index');
    Route::delete('/products/{id}', [AdminProductsController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/create', [AdminProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductsController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductsController::class, 'update'])->name('products.update');
    Route::get('/products/{id}', [AdminProductsController::class, 'show'])->name('products.show');

    // //Orders CRUD
    Route::get('/orders', [AdminOrdersController::class, 'index'])->name('orders.index');
    Route::delete('/orders/{id}', [AdminOrdersController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/create', [AdminOrdersController::class, 'create'])->name('orders.create');
    Route::post('/orders', [AdminOrdersController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/edit', [AdminOrdersController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminOrdersController::class, 'update'])->name('orders.update');
    Route::get('/orders/{id}', [AdminOrdersController::class, 'show'])->name('orders.show');

    //Coupons CRUD
    Route::get('/coupons', [AdminCouponsController::class, 'index'])->name('coupons.index');
    Route::delete('/coupons/{id}', [AdminCouponsController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/coupons/create', [AdminCouponsController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [AdminCouponsController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{id}/edit', [AdminCouponsController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{id}', [AdminCouponsController::class, 'update'])->name('coupons.update');
   
    //Reviews CRUD
    Route::get('/reviews', [AdminReviewsController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [AdminReviewsController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{id}/{actionType}', [AdminReviewsController::class, 'update'])->name('reviews.approve');

    //Messages CRUD
    Route::get('/messages', [AdminContactUsController::class, 'index'])->name('contact-us.index');
    Route::get('/messages/{id}', [AdminContactUsController::class, 'show'])->name('contact-us.show');
    Route::delete('/messages/{id}', [AdminContactUsController::class, 'destroy'])->name('contact-us.destroy');
    Route::put('/messages/{id}', [AdminContactUsController::class, 'update'])->name('contact-us.update');
    
    // //Charts CRUD
    Route::get('/charts/products', [AdminChartsController::class, 'products'])->name('charts.products');
    Route::get('/charts', [AdminChartsController::class, 'index'])->name('charts.index');
});

require __DIR__.'/auth.php';
