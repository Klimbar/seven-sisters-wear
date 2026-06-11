<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Tribe;
use App\Models\Wishlist;
use App\Services\Pay0ShopService;
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
        $userId = Auth::id();

        $query = Product::with(['category', 'tribe', 'images'])
            ->where('status', 'active')
            ->where('is_approved', true)
            ->withAvg(['reviews as approved_reviews_avg_rating' => function ($q) {
                $q->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews as approved_reviews_count' => function ($q) {
                $q->where('is_approved', true);
            }])
            ->withCount(['wishlists' => function ($q) use ($userId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                }
            }]);

        // Filters
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('tribe')) {
            $query->whereHas('tribe', function ($q) use ($request) {
                $q->where('slug', $request->tribe);
            });
        }

        if ($request->filled('fabric')) {
            $query->where('fabric', $request->fabric);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
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
        $userId = Auth::id();
        $isWishlisted = false;
        $hasPurchasedProduct = false;
        $hasReviewedProduct = false;

        if ($userId) {
            $isWishlisted = Wishlist::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->exists();

            $hasPurchasedProduct = OrderItem::whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('payment_status', 'completed');
            })->where('product_id', $product->id)->exists();

            $hasReviewedProduct = $product->reviews()
                ->where('user_id', $userId)
                ->exists();
        }

        $product->load([
            'category',
            'tribe',
            'images',
            'variants',
            'reviews' => function ($query) {
                $query->where('is_approved', true)->latest();
            },
            'reviews.user',
            'reviews.images',
        ]);
        $product->is_wishlisted = $isWishlisted;

        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->limit(4)
            ->get();

        return inertia('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'canReview' => (bool) ($userId && $hasPurchasedProduct && ! $hasReviewedProduct),
            'hasPurchasedProduct' => $hasPurchasedProduct,
            'hasReviewedProduct' => $hasReviewedProduct,
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
        $variant = null;

        if ($product->hasVariants() && ! $variantId) {
            return redirect()->back()->with('error', 'Please select a variant');
        }

        if ($variantId) {
            $variant = ProductVariant::where('product_id', $product->id)->find($variantId);

            if (! $variant) {
                return redirect()->back()->with('error', 'Please select a valid variant');
            }

            if ($variant->stock < $quantity) {
                return redirect()->back()->with('error', 'Selected variant is out of stock');
            }
        } elseif ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Product is out of stock');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if (($variant?->stock ?? $product->stock) < $newQuantity) {
                return redirect()->back()->with('error', 'Not enough stock available');
            }

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

        $cartItem = Cart::with(['product', 'variant'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $availableStock = $cartItem->variant?->stock ?? $cartItem->product->stock;

        if ($availableStock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available');
        }

        $cartItem->update(['quantity' => $request->quantity]);

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
        $cartItems = Cart::with(['product.images', 'variant'])
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
        $orders = Order::with(['items.product.images', 'items.variant', 'returnRequest'])
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

        $userId = Auth::id();

        $order->load([
            'items.product.images',
            'items.variant',
            'returnRequest',
            'items.product.reviews' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->with('images');
            },
        ]);

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
        $cartItems = Cart::with(['product.images', 'variant'])
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variant?->price ?? $item->product->getEffectivePrice();

            return $price * $item->quantity;
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
            'shipping' => $this->shippingCharge(),
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
            'full_name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20'],
            'address_line1' => 'required|string|max:1000',
            'address_line2' => 'nullable|string|max:1000',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,upi,netbanking,wallet',
            'coupon_code' => 'nullable|string',
        ]);

        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        foreach ($cartItems as $item) {
            if ($item->variant_id && ! $item->variant) {
                return redirect()->back()->with('error', 'A selected variant is no longer available');
            }

            $availableStock = $item->variant?->stock ?? $item->product->stock;

            if ($availableStock < $item->quantity) {
                return redirect()->back()->with('error', 'Not enough stock available for '.$item->product->name);
            }
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variant?->price ?? $item->product->getEffectivePrice();

            return $price * $item->quantity;
        });

        $discount = 0;
        $coupon = null;

        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $shipping = $this->shippingCharge();
        $total = $subtotal + $shipping - $discount;

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'discount_amount' => $discount,
            'shipping_address' => $this->formatShippingAddress($request),
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_status' => 'pending',
            'coupon_id' => $coupon?->id,
        ]);

        foreach ($cartItems as $item) {
            $price = $item->variant?->price ?? $item->product->getEffectivePrice();

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);

            if ($item->variant_id) {
                $item->variant?->decrement('stock', $item->quantity);
            } else {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        if ($coupon) {
            $coupon->incrementUsage();
        }

        // For COD, complete order immediately
        if ($request->payment_method === 'cod') {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
            ]);

            Cart::where('user_id', Auth::id())->delete();

            $order->load('user', 'items.product', 'items.variant');
            Mail::to($order->user->email)->send(new OrderConfirmation($order));

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully');
        }

        // For online payments, initiate PayIN payment
        $user = Auth::user();
        $pay0ShopService = new Pay0ShopService();
        $callbackUrl = config('services.pay0shop.callback_url') . '/payment/callback';

        $response = $pay0ShopService->createOrder([
            'customer_mobile' => $user->phone ?? '9999999999',
            'customer_name' => $user->name ?? 'Customer',
            'amount' => (float) $total,
            'order_id' => $order->order_number,
            'redirect_url' => $callbackUrl,
            'remark1' => 'Order Payment',
            'remark2' => 'Seven Sisters Wear',
        ]);

        if ($response['status'] ?? false) {
            Cart::where('user_id', Auth::id())->delete();

            $order->update([
                'payment_transaction_id' => $response['result']['orderId'] ?? null,
            ]);

            return redirect($response['result']['payment_url'] ?? route('orders.show', $order))
                ->with('success', 'Redirecting to payment...');
        }

        // If payment initiation fails, order remains with pending payment
        return redirect()->route('orders.show', $order)
            ->with('warning', 'Order created but payment initiation failed. Please try again.');
    }

    private function formatShippingAddress(Request $request): string
    {
        $lines = [
            $request->full_name,
            $request->phone,
            $request->address_line1,
        ];

        if ($request->filled('address_line2')) {
            $lines[] = $request->address_line2;
        }

        $location = trim(implode(', ', array_filter([
            $request->city,
            $request->district,
        ])));

        if ($location !== '') {
            $lines[] = $location;
        }

        $lines[] = trim(sprintf('%s - %s', $request->state, $request->pincode));
        $lines[] = $request->country;

        return implode("\n", array_filter($lines));
    }

    private function shippingCharge(): int
    {
        return 100;
    }
}
