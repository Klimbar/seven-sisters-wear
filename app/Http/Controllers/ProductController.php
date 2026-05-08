<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Tribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = Category::all();
        $tribes = Tribe::all();

        return inertia('Shop/Index', [
            'products' => $products,
            'filters' => $request->only(['category', 'tribe', 'fabric', 'min_price', 'max_price', 'search']),
            'categories' => $categories,
            'tribes' => $tribes
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
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10'
        ]);

        $quantity = $request->input('quantity', 1);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
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
            'quantity' => 'integer|min:1|max:10'
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
                'product_id' => $product->id
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
            'cartItems' => $cartItems
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
            'orders' => $orders
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
            'order' => $order
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
            'wishlistItems' => $wishlistItems
        ]);
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        $cartItems = Cart::with('product.images')
            ->where('user_id', Auth::id())
            ->get();

        return inertia('Checkout', [
            'cartItems' => $cartItems
        ]);
    }

    /**
     * Place order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,upi,card,netbanking,wallet'
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);

            // Reduce stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully');
    }
}
