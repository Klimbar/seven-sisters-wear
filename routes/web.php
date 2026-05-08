<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
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
    Route::get('/cart', function () {
        return Inertia::render('Cart');
    })->name('cart');
    
    Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');
});

// Wishlist routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', function () {
        return Inertia::render('Wishlist');
    })->name('wishlist');
    
    Route::post('/wishlist/toggle/{product}', [ProductController::class, 'toggleWishlist'])->name('wishlist.toggle');
});

// Order routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/orders', function () {
        return Inertia::render('Orders/Index');
    })->name('orders.index');
    
    Route::get('/orders/{order}', function () {
        return Inertia::render('Orders/Show');
    })->name('orders.show');
});

// Checkout routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', function () {
        return Inertia::render('Checkout');
    })->name('checkout');
    
    Route::post('/orders', [ProductController::class, 'placeOrder'])->name('orders.store');
});

// Seller registration and login
Route::get('/seller/register', [SellerController::class, 'showRegistrationForm'])->name('seller.register');
Route::post('/seller/register', [SellerController::class, 'register'])->name('seller.store');
Route::get('/seller/login', function () {
    return Inertia::render('Seller/Login');
})->name('seller.login');

// Seller dashboard (requires auth + seller role)
Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    
    // Product management for sellers
    Route::get('/seller/products', [SellerController::class, 'products'])->name('seller.products');
    Route::get('/seller/products/create', [SellerController::class, 'createProduct'])->name('seller.products.create');
    Route::post('/seller/products', [SellerController::class, 'storeProduct'])->name('seller.products.store');
    Route::get('/seller/products/{product}/edit', [SellerController::class, 'editProduct'])->name('seller.products.edit');
    Route::patch('/seller/products/{product}', [SellerController::class, 'updateProduct'])->name('seller.products.update');
    Route::delete('/seller/products/{product}', [SellerController::class, 'deleteProduct'])->name('seller.products.destroy');
    
    // Order management for sellers
    Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
    Route::patch('/seller/orders/{order}/status', [SellerController::class, 'updateOrderStatus'])->name('seller.orders.update-status');
    
    // Earnings
    Route::get('/seller/earnings', [SellerController::class, 'earnings'])->name('seller.earnings');
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
    
    // Seller management
    Route::get('/sellers', function () {
        return Inertia::render('Admin/Sellers/Index');
    })->name('admin.sellers.index');
    Route::patch('/sellers/{user}/approve', function () {
        // Approve seller logic
    })->name('admin.sellers.approve');
    
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
