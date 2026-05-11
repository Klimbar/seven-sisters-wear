<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tribe;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    /**
     * Display product listing for shop page
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'tribe', 'images'])
            ->where('status', 'active')
            ->where('is_approved', true);

        // Filters
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('tribe')) {
            $query->whereHas('tribe', function ($q) use ($request) {
                $q->where('slug', $request->tribe);
            });
        }

        if ($request->has('fabric')) {
            $query->where('fabric', $request->fabric);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = Category::all();
        $tribes = Tribe::all();

        return inertia('Shop/Index', [
            'products' => $products,
            'filters' => $request->only(['category', 'tribe', 'fabric', 'min_price', 'max_price', 'search']),
            'categories' => $categories,
            'tribes' => $tribes,
        ]);
    }

    /**
     * Display single product
     */
    public function show(Product $product)
    {
        $product->load(['category', 'tribe', 'images', 'reviews.user']);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        return inertia('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $quantity = $request->input('quantity', 1);
        $variantId = $request->input('variant_id');

        if ($product->hasVariants() && ! $variantId) {
            return redirect()->back()->with('error', 'Please select a variant');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10',
        ]);

        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated');
    }

    /**
     * Toggle wishlist
     */
    public function toggleWishlist(Product $product)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Removed from wishlist';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);
            $message = 'Added to wishlist';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Display cart page
     */
    public function cart()
    {
        $cartItems = Cart::with('product.images')
            ->where('user_id', Auth::id())
            ->get();

        return inertia('Cart', [
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Display user orders
     */
    public function orders()
    {
        $orders = Order::with('items.product.images')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return inertia('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display single order
     */
    public function orderShow(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product.images');

        return inertia('Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Display wishlist page
     */
    public function wishlist()
    {
        $wishlistItems = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->get();

        return inertia('Wishlist', [
            'wishlistItems' => $wishlistItems,
        ]);
    }

    /**
     * Display checkout page
     */
    public function checkout(Request $request)
    {
        $cartItems = Cart::with(['product.images', 'product.variants'])
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variant_id
                ? $item->product->variants()->find($item->variant_id)?->price
                : $item->product->price;

            return ($price ?? $item->product->price) * $item->quantity;
        });

        $coupon = null;
        $discount = 0;

        if ($request->has('coupon_code')) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        return inertia('Checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'coupon' => $coupon,
            'discount' => $discount,
            'couponCode' => $request->coupon_code,
        ]);
    }

    /**
     * Place order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,upi,card,netbanking,wallet',
            'coupon_code' => 'nullable|string',
        ]);

        $cartItems = Cart::with(['product', 'product.variants'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variant_id
                ? $item->product->variants()->find($item->variant_id)?->price
                : $item->product->price;

            return ($price ?? $item->product->price) * $item->quantity;
        });

        $discount = 0;
        $coupon = null;

        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $total = $subtotal - $discount;

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-'.time().rand(1000, 9999),
            'total_amount' => $total,
            'discount_amount' => $discount,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_status' => 'pending',
            'coupon_id' => $coupon?->id,
        ]);

        foreach ($cartItems as $item) {
            $price = $item->variant_id
                ? $item->product->variants()->find($item->variant_id)?->price
                : $item->product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'quantity' => $item->quantity,
                'price' => $price ?? $item->product->price,
            ]);

            if ($item->variant_id) {
                $item->product->variants()->find($item->variant_id)->decrement('stock', $item->quantity);
            } else {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        if ($coupon) {
            $coupon->incrementUsage();
        }

        Cart::where('user_id', Auth::id())->delete();

        $order->load('user', 'items.product');
        Mail::to($order->user->email)->send(new OrderConfirmation($order));

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully');
    }
}
