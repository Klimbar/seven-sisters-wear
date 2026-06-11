<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProductVariantSelectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_details_include_available_variants(): void
    {
        $product = $this->createProduct();
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'size' => 'M',
            'color' => 'Red',
            'price' => 1599,
            'stock' => 4,
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('product.variants.0.id', $variant->id)
                ->where('product.variants.0.size', 'M')
            );
    }

    public function test_selected_variant_is_saved_to_cart(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'size' => 'L',
            'color' => 'Blue',
            'price' => 1799,
            'stock' => 3,
        ]);

        $this->actingAs($user)
            ->post(route('cart.add', $product), [
                'quantity' => 2,
                'variant_id' => $variant->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'quantity' => 2,
        ]);
    }

    public function test_variant_must_belong_to_the_selected_product(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct('Naga Shawl', 'naga-shawl');
        $otherProduct = $this->createProduct('Mizo Wrap', 'mizo-wrap');
        $otherVariant = ProductVariant::create([
            'product_id' => $otherProduct->id,
            'size' => 'S',
            'color' => 'Green',
            'price' => 1299,
            'stock' => 5,
        ]);

        $this->actingAs($user)
            ->from(route('products.show', $product))
            ->post(route('cart.add', $product), [
                'quantity' => 1,
                'variant_id' => $otherVariant->id,
            ])
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHas('error', 'Please select a valid variant');

        $this->assertDatabaseCount('carts', 0);
    }

    public function test_checkout_subtotal_uses_variant_price(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'size' => 'XL',
            'color' => 'Gold',
            'price' => 2500,
            'stock' => 2,
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user)
            ->get(route('checkout'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('subtotal', 5000)
                ->where('cartItems.0.variant.size', 'XL')
            );
    }

    private function createProduct(string $name = 'Assam Silk Dress', string $slug = 'assam-silk-dress'): Product
    {
        $category = Category::create([
            'name' => $name.' Category',
            'slug' => $slug.'-category',
            'description' => 'Traditional clothing',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'description' => 'Handwoven traditional dress',
            'price' => 999,
            'stock' => 10,
            'fabric' => 'Silk',
            'occasion' => 'Festival',
            'status' => 'active',
            'is_approved' => true,
        ]);
    }
}
