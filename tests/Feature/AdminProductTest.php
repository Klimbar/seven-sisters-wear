<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_product_with_images_and_variants(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Mekhela Chador',
            'slug' => 'mekhela-chador',
            'description' => 'Traditional attire',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Silk Shawl',
            'description' => 'Handwoven silk shawl',
            'price' => 2499,
            'discount_price' => null,
            'stock' => 12,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'category_id' => $category->id,
            'tribe_id' => null,
            'primary_image' => UploadedFile::fake()->image('shawl-front.jpg'),
            'additional_images' => [
                UploadedFile::fake()->image('shawl-back.jpg'),
            ],
            'variants' => [
                [
                    'size' => 'M',
                    'color' => 'Red',
                    'price' => 2599,
                    'stock' => 5,
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Silk Shawl')->firstOrFail();

        $this->assertTrue($product->is_approved);
        $this->assertSame('silk-shawl', $product->slug);
        $this->assertCount(2, $product->images);
        $this->assertTrue($product->images->first()->is_primary);
        Storage::disk('public')->assertExists($product->images->first()->image_path);
        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'size' => 'M',
            'color' => 'Red',
            'stock' => 5,
        ]);
    }

    public function test_admin_can_create_products_with_duplicate_names(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Shawls',
            'slug' => 'shawls',
            'description' => 'Traditional shawls',
        ]);

        Product::create([
            'name' => 'Silk Shawl',
            'slug' => 'silk-shawl',
            'description' => 'Existing product',
            'price' => 1999,
            'stock' => 3,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'is_approved' => true,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Silk Shawl',
            'description' => 'Another handwoven silk shawl',
            'price' => 2499,
            'discount_price' => null,
            'stock' => 12,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'category_id' => $category->id,
            'tribe_id' => null,
            'primary_image' => UploadedFile::fake()->image('shawl-front.jpg'),
            'variants' => [],
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Silk Shawl',
            'slug' => 'silk-shawl-2',
        ]);
    }

    public function test_admin_can_delete_an_additional_product_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Shawls',
            'slug' => 'shawls',
            'description' => 'Traditional shawls',
        ]);

        $product = Product::create([
            'name' => 'Silk Shawl',
            'slug' => 'silk-shawl',
            'description' => 'Existing product',
            'price' => 1999,
            'stock' => 3,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'is_approved' => true,
            'category_id' => $category->id,
        ]);

        $primaryPath = UploadedFile::fake()->image('front.jpg')->store('products', 'public');
        $additionalPath = UploadedFile::fake()->image('back.jpg')->store('products', 'public');

        $primaryImage = $product->images()->create([
            'image_path' => $primaryPath,
            'is_primary' => true,
        ]);
        $additionalImage = $product->images()->create([
            'image_path' => $additionalPath,
            'is_primary' => false,
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.products.images.destroy', [$product, $additionalImage]));

        $response->assertRedirect();
        Storage::disk('public')->assertMissing($additionalPath);
        Storage::disk('public')->assertExists($primaryPath);
        $this->assertDatabaseMissing('product_images', ['id' => $additionalImage->id]);
        $this->assertDatabaseHas('product_images', ['id' => $primaryImage->id]);
    }

    public function test_admin_cannot_delete_the_primary_product_image_from_gallery_delete(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Shawls',
            'slug' => 'shawls',
            'description' => 'Traditional shawls',
        ]);

        $product = Product::create([
            'name' => 'Silk Shawl',
            'slug' => 'silk-shawl',
            'description' => 'Existing product',
            'price' => 1999,
            'stock' => 3,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'is_approved' => true,
            'category_id' => $category->id,
        ]);

        $primaryPath = UploadedFile::fake()->image('front.jpg')->store('products', 'public');
        $primaryImage = $product->images()->create([
            'image_path' => $primaryPath,
            'is_primary' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.products.images.destroy', [$product, $primaryImage]));

        $response->assertStatus(422);
        Storage::disk('public')->assertExists($primaryPath);
        $this->assertDatabaseHas('product_images', ['id' => $primaryImage->id]);
    }

    public function test_admin_reports_include_top_product_image_urls(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Shawls',
            'slug' => 'shawls',
            'description' => 'Traditional shawls',
        ]);

        $product = Product::create([
            'name' => 'Silk Shawl',
            'slug' => 'silk-shawl',
            'description' => 'Existing product',
            'price' => 1999,
            'stock' => 3,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'is_approved' => true,
            'category_id' => $category->id,
        ]);

        $imagePath = UploadedFile::fake()->image('front.jpg')->store('products', 'public');
        $product->images()->create([
            'image_path' => $imagePath,
            'is_primary' => true,
        ]);

        $order = Order::create([
            'user_id' => $admin->id,
            'total_amount' => 1999,
            'status' => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'completed',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 1999,
        ]);

        $inertiaVersion = app(HandleInertiaRequests::class)->version(request());

        $response = $this->actingAs($admin)
            ->withHeaders([
                'X-Inertia' => 'true',
                'X-Inertia-Version' => $inertiaVersion,
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->get(route('admin.reports'));

        $response->assertOk();
        $response->assertJsonPath('component', 'Admin/Reports/Index');
        $response->assertJsonPath('props.topProducts.0.images.0.url', Storage::disk('public')->url($imagePath));
    }
}
