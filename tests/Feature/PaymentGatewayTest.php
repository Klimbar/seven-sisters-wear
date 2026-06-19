<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    use RefreshDatabase;

    public function test_online_checkout_uses_serdihin_when_selected_as_default_gateway(): void
    {
        config([
            'services.payment.default_gateway' => 'serdihin',
            'services.serdihin.api_key' => 'test-public-key',
            'services.serdihin.api_secret' => 'test-secret-key',
        ]);

        Http::fake([
            'pay.serdihin.in/api/create-order' => Http::response([
                'status' => 'success',
                'data' => [
                    'payment_url' => 'https://pay.serdihin.in/pay/test-token',
                    'order_id' => 'ORD-TEST-001',
                    'token' => 'test-token',
                ],
            ], 201),
        ]);

        $user = User::factory()->create();
        $product = $this->createProduct();

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('orders.store'), $this->checkoutPayload())
            ->assertRedirect('https://pay.serdihin.in/pay/test-token');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://pay.serdihin.in/api/create-order'
                && $request->hasHeader('X-API-Key', 'test-public-key')
                && $request->hasHeader('X-API-Secret', 'test-secret-key')
                && $request['order_id'] !== null
                && $request['callback_url'] === route('payment.callback');
        });

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'upi',
            'payment_status' => 'pending',
            'payment_transaction_id' => 'test-token',
        ]);
    }

    public function test_inertia_online_checkout_returns_external_payment_location(): void
    {
        config([
            'services.payment.default_gateway' => 'serdihin',
            'services.serdihin.api_key' => 'test-public-key',
            'services.serdihin.api_secret' => 'test-secret-key',
        ]);

        Http::fake([
            'pay.serdihin.in/api/create-order' => Http::response([
                'status' => 'success',
                'data' => [
                    'payment_url' => 'https://pay.serdihin.in/pay/test-token',
                    'order_id' => 'ORD-TEST-001',
                    'token' => 'test-token',
                ],
            ], 201),
        ]);

        $user = User::factory()->create();
        $product = $this->createProduct('assam-silk-dress-inertia-payment-test');

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->withHeaders(['X-Inertia' => 'true'])
            ->post(route('orders.store'), $this->checkoutPayload())
            ->assertStatus(409)
            ->assertHeader('X-Inertia-Location', 'https://pay.serdihin.in/pay/test-token');
    }

    public function test_serdihin_callback_verifies_status_before_completing_order(): void
    {
        config([
            'services.payment.default_gateway' => 'serdihin',
            'services.serdihin.api_key' => 'test-public-key',
            'services.serdihin.api_secret' => 'test-secret-key',
        ]);

        Http::fake([
            'pay.serdihin.in/api/check-status' => Http::response([
                'status' => 'success',
                'data' => [
                    'order_id' => 'ORD-TEST-002',
                    'payment_status' => 'success',
                    'utr' => '615372849102',
                ],
            ]),
        ]);

        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-TEST-002',
            'total_amount' => 1099,
            'discount_amount' => 0,
            'shipping_address' => 'Customer Address',
            'payment_method' => 'upi',
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('payment.callback', [
                'status' => 'success',
                'order_id' => $order->order_number,
                'amount' => '1099.00',
                'utr' => '615372849102',
            ]))
            ->assertRedirect(route('orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_status' => 'completed',
            'status' => 'processing',
            'payment_UTR' => '615372849102',
        ]);
    }

    public function test_serdihin_webhook_requires_valid_signature_and_marks_payment_completed(): void
    {
        config([
            'services.payment.default_gateway' => 'serdihin',
            'services.serdihin.webhook_secret' => 'webhook-secret',
        ]);

        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'order_number' => 'ORD-TEST-003',
            'total_amount' => 1099,
            'discount_amount' => 0,
            'shipping_address' => 'Customer Address',
            'payment_method' => 'upi',
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        $payload = json_encode([
            'event' => 'payment.success',
            'order_id' => $order->order_number,
            'amount' => 1099,
            'utr' => '615372849103',
            'status' => 'success',
        ]);

        $signature = hash_hmac('sha256', $payload, 'webhook-secret');

        $this->withHeaders([
            'X-SerdihinPay-Signature' => $signature,
            'Content-Type' => 'application/json',
        ])->postJson(route('payment.webhook'), json_decode($payload, true))
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_status' => 'completed',
            'status' => 'processing',
            'payment_UTR' => '615372849103',
        ]);
    }

    private function checkoutPayload(): array
    {
        return [
            'full_name' => 'Raushan Kumar',
            'phone' => '9999999999',
            'address_line1' => 'Line 1',
            'address_line2' => null,
            'city' => 'Guwahati',
            'district' => 'Kamrup',
            'state' => 'Assam',
            'pincode' => '781001',
            'country' => 'India',
            'payment_method' => 'upi',
        ];
    }

    private function createProduct(string $slug = 'assam-silk-dress-payment-test'): Product
    {
        $category = Category::create([
            'name' => 'Traditional Wear',
            'slug' => 'traditional-wear',
            'description' => 'Traditional clothing',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Assam Silk Dress',
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
