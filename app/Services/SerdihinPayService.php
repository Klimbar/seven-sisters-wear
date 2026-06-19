<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SerdihinPayService
{
    protected string $baseUrl = 'https://pay.serdihin.in/api';

    public function createOrder(array $data): array
    {
        $payload = [
            'amount' => number_format((float) $data['amount'], 2, '.', ''),
            'order_id' => $data['order_id'],
            'customer_name' => $data['customer_name'],
            'callback_url' => $data['callback_url'],
            'description' => $data['description'] ?? 'Seven Sisters Wear order payment',
            'customer_mobile' => $data['customer_mobile'] ?? null,
        ];

        try {
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/create-order", array_filter($payload, fn ($value) => $value !== null));

            $result = $response->json() ?? [];

            Log::info('Serdihin Pay Create Order Response', [
                'status' => $response->status(),
                'body' => $result,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Serdihin Pay Create Order Error: '.$e->getMessage());

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function checkOrderStatus(string $orderId): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/check-status", ['order_id' => $orderId]);

            $result = $response->json() ?? [];

            Log::info('Serdihin Pay Check Status Response', [
                'status' => $response->status(),
                'body' => $result,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Serdihin Pay Check Status Error: '.$e->getMessage());

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function hasValidSignature(string $payload, ?string $signature): bool
    {
        $secret = config('services.serdihin.webhook_secret');

        if (! $secret || ! $signature) {
            return false;
        }

        return hash_equals(hash_hmac('sha256', $payload, $secret), $signature);
    }

    private function headers(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-API-Key' => config('services.serdihin.api_key'),
            'X-API-Secret' => config('services.serdihin.api_secret'),
        ];
    }
}
