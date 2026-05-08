<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
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
    return Inertia::render('Home');
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
});

// Checkout routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
    
    Route::post('/orders', [ProductController::class, 'placeOrder'])->name('orders.store');
});

// Admin routes (requires auth + admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');
    
    // User management
    Route::get('/users', function () {
        return Inertia::render('Admin/Users/Index');
    })->name('admin.users.index');
    
    // Product moderation
    Route::get('/products', function () {
        return Inertia::render('Admin/Products/Index');
    })->name('admin.products.index');
    Route::patch('/products/{product}/approve', function () {
        // Approve product logic
    })->name('admin.products.approve');
    
    // Orders overview
    Route::get('/orders', function () {
        return Inertia::render('Admin/Orders/Index');
    })->name('admin.orders.index');
    
    // Category management
    Route::get('/categories', function () {
        return Inertia::render('Admin/Categories/Index');
    })->name('admin.categories.index');
    
    // Reports
    Route::get('/reports', function () {
        return Inertia::render('Admin/Reports/Index');
    })->name('admin.reports');
});

// Contact page
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

// Dashboard (existing route)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (existing)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
