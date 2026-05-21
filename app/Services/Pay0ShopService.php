<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Pay0ShopService
{
    protected string $baseUrl = 'https://pay0.shop/api';
    protected string $userToken;

    public function __construct()
    {
        $this->userToken = config('services.pay0shop.token');
    }

    /**
     * Create a pay0shop order
     */
    public function createOrder(array $data): array
    {
        $payload = [
            'customer_mobile' => $data['customer_mobile'],
            'customer_name' => $data['customer_name'],
            'user_token' => $this->userToken,
            'amount' => $data['amount'],
            'order_id' => $data['order_id'],
            'redirect_url' => $data['redirect_url'],
            'remark1' => $data['remark1'] ?? '',
            'remark2' => $data['remark2'] ?? '',
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post("{$this->baseUrl}/create-order", $payload);

            $result = $response->json();

            Log::info('Pay0Shop Create Order Response', $result);

            return $result;
        } catch (\Exception $e) {
            Log::error('Pay0Shop Create Order Error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check order payment status
     */
    public function checkOrderStatus(string $orderId): array
    {
        $payload = [
            'user_token' => $this->userToken,
            'order_id' => $orderId,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post("{$this->baseUrl}/check-order-status", $payload);

            $result = $response->json();

            Log::info('Pay0Shop Check Status Response', $result);

            return $result;
        } catch (\Exception $e) {
            Log::error('Pay0Shop Check Status Error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}