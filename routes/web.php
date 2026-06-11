<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TribeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of
| them will be assigned to the "web" middleware group. Make
| something great!
|
*/

// Home page
Route::get('/', function () {
    $userId = \Illuminate\Support\Facades\Auth::id();

    $featuredProducts = \App\Models\Product::with(['category', 'images'])
        ->where('status', 'active')
        ->where('is_approved', true)
        ->withCount(['wishlists' => function ($q) use ($userId) {
            if ($userId) {
                $q->where('user_id', $userId);
            }
        }])
        ->latest()
        ->limit(8)
        ->get();

    return Inertia::render('Home', [
        'featuredProducts' => $featuredProducts,
    ]);
});

// About/Story page
Route::get('/story', function () {
    return Inertia::render('Story');
})->name('story');

// States routes
Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::get('/states/{state}', [StateController::class, 'show'])->name('states.show');

// Tribes routes
Route::get('/tribes', [TribeController::class, 'index'])->name('tribes.index');
Route::get('/tribes/{tribe}', [TribeController::class, 'show'])->name('tribes.show');

// Shop/Products routes
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('products.review')->middleware('auth');
Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update')->middleware('auth');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

// Cart routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart');

    Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');
});

// Wishlist routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [ProductController::class, 'wishlist'])->name('wishlist');

    Route::post('/wishlist/toggle/{product}', [ProductController::class, 'toggleWishlist'])->name('wishlist.toggle');
});

// Order routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/orders', [ProductController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [ProductController::class, 'orderShow'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'show'])->name('orders.invoice');
});

// Return routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/create', [ReturnController::class, 'create'])->name('returns.create');
    Route::get('/returns/{returnRequest}', [ReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns', [ReturnController::class, 'store'])->name('returns.store');
});

// Checkout routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::post('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
    Route::post('/orders', [ProductController::class, 'placeOrder'])->name('orders.store');

    // Payment routes
    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});

// PayIN webhook (no auth - called by payment gateway)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Admin routes (requires auth + admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.updateRole');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Product management
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::patch('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}/images/{image}', [AdminController::class, 'destroyProductImage'])->name('admin.products.images.destroy');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

    // Orders management
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'adminShow'])->name('admin.orders.invoice');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
    Route::patch('/orders/{order}/payment-status', [AdminController::class, 'updatePaymentStatus'])->name('admin.orders.updatePaymentStatus');

    // Returns management
    Route::get('/returns', [ReturnController::class, 'adminIndex'])->name('admin.returns.index');
    Route::get('/returns/{returnRequest}', [ReturnController::class, 'adminShow'])->name('admin.returns.show');
    Route::patch('/returns/{returnRequest}', [ReturnController::class, 'updateStatus'])->name('admin.returns.update');

    // Category management
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::patch('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Tribe management
    Route::get('/tribes', [AdminController::class, 'tribes'])->name('admin.tribes.index');
    Route::post('/tribes', [AdminController::class, 'storeTribe'])->name('admin.tribes.store');
    Route::patch('/tribes/{tribe}', [AdminController::class, 'updateTribe'])->name('admin.tribes.update');
    Route::delete('/tribes/{tribe}', [AdminController::class, 'destroyTribe'])->name('admin.tribes.destroy');

    // Coupon management
    Route::get('/coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::post('/coupons', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::patch('/coupons/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');

    // Review management
    Route::get('/reviews', [ReviewController::class, 'adminIndex'])->name('admin.reviews.index');
    Route::patch('/reviews/{review}', [ReviewController::class, 'updateStatus'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroyAdmin'])->name('admin.reviews.destroy');

    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

// Contact page
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');

// Dashboard - redirect to shop
Route::get('/dashboard', function () {
    return redirect()->route('shop');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (existing)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
