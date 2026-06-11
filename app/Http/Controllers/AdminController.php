<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusUpdate;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\State;
use App\Models\Tribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalUsers' => User::count(),
            'totalRevenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'lowStockProducts' => Product::where('stock', '<', 5)->count(),
        ];

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $topProducts = Product::with(['images'])
            ->has('orderItems')
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        $ordersByStatus = Order::select('status')
            ->selectRaw('count(*) as count')
            ->groupBy('status')
            ->get();

        return inertia('Admin/Dashboard/Index', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'ordersByStatus' => $ordersByStatus,
        ]);
    }

    public function products(Request $request)
    {
        $query = Product::with(['category', 'tribe', 'images']);

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::all();

        return inertia('Admin/Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'status', 'category']),
        ]);
    }

    public function createProduct()
    {
        $categories = Category::all();
        $tribes = Tribe::all();
        $states = State::all();

        return inertia('Admin/Products/Create', [
            'categories' => $categories,
            'tribes' => $tribes,
            'states' => $states,
        ]);
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'fabric' => 'required|string',
            'occasion' => 'required|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'tribe_id' => 'nullable|exists:tribes,id',
            'primary_image' => 'required|image|max:5120',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|max:5120',
            'variants' => 'nullable|array',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => $this->uniqueProductSlug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'fabric' => $request->fabric,
            'occasion' => $request->occasion,
            'status' => $request->status,
            'is_approved' => true,
            'category_id' => $request->category_id,
            'tribe_id' => $request->tribe_id,
        ]);

        $this->storeProductImage($product, $request->file('primary_image'), true);

        foreach ($request->file('additional_images', []) as $image) {
            $this->storeProductImage($product, $image);
        }

        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variant) {
                if (! empty($variant['size']) || ! empty($variant['color'])) {
                    $product->variants()->create([
                        'size' => $variant['size'] ?? null,
                        'color' => $variant['color'] ?? null,
                        'price' => $variant['price'] ?? $request->price,
                        'stock' => $variant['stock'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function editProduct(Product $product)
    {
        $product->load(['images', 'variants']);
        $categories = Category::all();
        $tribes = Tribe::all();
        $states = State::all();

        return inertia('Admin/Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'tribes' => $tribes,
            'states' => $states,
        ]);
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'fabric' => 'required|string',
            'occasion' => 'required|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'tribe_id' => 'nullable|exists:tribes,id',
            'primary_image' => 'nullable|image|max:5120',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|max:5120',
            'variants' => 'nullable|array',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => $this->uniqueProductSlug($request->name, $product->id),
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'fabric' => $request->fabric,
            'occasion' => $request->occasion,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'tribe_id' => $request->tribe_id,
        ]);

        if ($request->hasFile('primary_image')) {
            $primaryImage = $product->images()->where('is_primary', true)->first();
            $this->deleteStoredProductImage($primaryImage?->image_path);
            $primaryImage?->delete();

            $product->images()->update(['is_primary' => false]);
            $this->storeProductImage($product, $request->file('primary_image'), true);
        }

        foreach ($request->file('additional_images', []) as $image) {
            $this->storeProductImage($product, $image);
        }

        if ($request->has('variants') && is_array($request->variants)) {
            $existingIds = collect($request->variants)->pluck('id')->filter()->toArray();
            $product->variants()->whereNotIn('id', $existingIds)->delete();

            foreach ($request->variants as $variant) {
                if (! empty($variant['size']) || ! empty($variant['color'])) {
                    if (! empty($variant['id'])) {
                        $product->variants()->where('id', $variant['id'])->update([
                            'size' => $variant['size'] ?? null,
                            'color' => $variant['color'] ?? null,
                            'price' => $variant['price'] ?? $request->price,
                            'stock' => $variant['stock'] ?? 0,
                        ]);
                    } else {
                        $product->variants()->create([
                            'size' => $variant['size'] ?? null,
                            'color' => $variant['color'] ?? null,
                            'price' => $variant['price'] ?? $request->price,
                            'stock' => $variant['stock'] ?? 0,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroyProduct(Product $product)
    {
        $product->images->each(function (ProductImage $image) {
            $this->deleteStoredProductImage($image->image_path);
        });

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function destroyProductImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);
        abort_if($image->is_primary, 422, 'Primary image cannot be deleted here. Replace it by uploading a new primary image.');

        $this->deleteStoredProductImage($image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Product image deleted successfully');
    }

    private function uniqueProductSlug(string $name, ?int $ignoreProductId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 2;

        while (Product::where('slug', $slug)
            ->when($ignoreProductId, fn ($query) => $query->where('id', '!=', $ignoreProductId))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    private function storeProductImage(Product $product, $image, bool $isPrimary = false): void
    {
        $path = $image->store('products', 'public');

        $product->images()->create([
            'image_path' => $path,
            'is_primary' => $isPrimary,
        ]);
    }

    private function deleteStoredProductImage(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    public function orders(Request $request)
    {
        $query = Order::with('user', 'items.product.images');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($searchQuery) use ($request) {
                $searchQuery->where('order_number', 'like', '%'.$request->search.'%')
                    ->orWhere('id', 'like', '%'.$request->search.'%');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return inertia('Admin/Orders/Index', [
            'orders' => $orders,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function showOrder(Order $order)
    {
        $order->load('user', 'items.product.images');

        return inertia('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,returned',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($oldStatus !== $request->status) {
            $order->load('user');
            Mail::to($order->user->email)->send(new OrderStatusUpdate($order, $request->status));
        }

        return redirect()->back()->with('success', 'Order status updated');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Payment status updated');
    }

    public function users(Request $request)
    {
        $query = User::with('roles');

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%');
        }

        if ($request->has('role')) {
            $query->role($request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return inertia('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role']),
        ]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,customer',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'User role updated');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();

        return inertia('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with products');
        }
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function tribes()
    {
        $tribes = Tribe::with('state')->withCount('products')->get();
        $states = State::orderBy('name')->get();

        return inertia('Admin/Tribes/Index', [
            'tribes' => $tribes,
            'states' => $states,
        ]);
    }

    public function storeTribe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tribes,name',
            'state_id' => 'required|exists:states,id',
            'description' => 'nullable|string',
        ]);

        Tribe::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'state_id' => $request->state_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Tribe created successfully');
    }

    public function updateTribe(Request $request, Tribe $tribe)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tribes,name,'.$tribe->id,
            'state_id' => 'required|exists:states,id',
            'description' => 'nullable|string',
        ]);

        $tribe->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'state_id' => $request->state_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Tribe updated successfully');
    }

    public function destroyTribe(Tribe $tribe)
    {
        if ($tribe->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete tribe with products');
        }

        $tribe->delete();

        return redirect()->back()->with('success', 'Tribe deleted successfully');
    }

    public function reports()
    {
        $totalRevenue = Order::where('payment_status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $monthExpression = DB::connection()->getDriverName() === 'sqlite'
            ? "strftime('%m', created_at)"
            : 'MONTH(created_at)';

        $ordersByMonth = Order::selectRaw($monthExpression.' as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $topProducts = Product::with(['images'])
            ->has('orderItems')
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        $ordersByStatus = Order::select('status')
            ->selectRaw('count(*) as count')
            ->groupBy('status')
            ->get();

        return inertia('Admin/Reports/Index', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'averageOrderValue' => $averageOrderValue,
            'ordersByMonth' => $ordersByMonth,
            'topProducts' => $topProducts,
            'ordersByStatus' => $ordersByStatus,
        ]);
    }
}
