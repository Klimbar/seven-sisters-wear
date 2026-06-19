<?php

namespace App\Services;

class PaymentGatewayService
{
    public function __construct(
        private Pay0ShopService $pay0ShopService,
        private SerdihinPayService $serdihinPayService,
    ) {}

    public function createOrder(array $data): array
    {
        if ($this->gateway() === 'serdihin') {
            $response = $this->serdihinPayService->createOrder([
                'customer_mobile' => $data['customer_mobile'],
                'customer_name' => $data['customer_name'],
                'amount' => $data['amount'],
                'order_id' => $data['order_id'],
                'callback_url' => route('payment.callback'),
                'description' => $data['description'] ?? $data['remark1'] ?? 'Order Payment',
            ]);

            return [
                'success' => ($response['status'] ?? null) === 'success',
                'payment_url' => $response['data']['payment_url'] ?? null,
                'transaction_id' => $response['data']['token'] ?? null,
                'message' => $response['message'] ?? $response['error'] ?? 'Payment initiation failed',
            ];
        }

        $callbackBaseUrl = config('services.pay0shop.callback_url') ?: config('app.url');
        $response = $this->pay0ShopService->createOrder([
            'customer_mobile' => $data['customer_mobile'],
            'customer_name' => $data['customer_name'],
            'amount' => $data['amount'],
            'order_id' => $data['order_id'],
            'redirect_url' => rtrim($callbackBaseUrl, '/').'/payment/callback',
            'remark1' => $data['remark1'] ?? 'Order Payment',
            'remark2' => $data['remark2'] ?? 'Seven Sisters Wear',
        ]);

        return [
            'success' => (bool) ($response['status'] ?? false),
            'payment_url' => $response['result']['payment_url'] ?? null,
            'transaction_id' => $response['result']['orderId'] ?? null,
            'message' => $response['message'] ?? 'Payment initiation failed',
        ];
    }

    public function checkOrderStatus(string $orderId): array
    {
        if ($this->gateway() === 'serdihin') {
            $response = $this->serdihinPayService->checkOrderStatus($orderId);

            return [
                'success' => ($response['status'] ?? null) === 'success',
                'payment_status' => $response['data']['payment_status'] ?? null,
                'utr' => $response['data']['utr'] ?? null,
            ];
        }

        $response = $this->pay0ShopService->checkOrderStatus($orderId);

        return [
            'success' => (bool) ($response['status'] ?? false),
            'payment_status' => $response['result']['txnStatus'] ?? null,
            'utr' => $response['result']['utr'] ?? null,
        ];
    }

    public function hasValidWebhookSignature(string $payload, ?string $signature): bool
    {
        return $this->serdihinPayService->hasValidSignature($payload, $signature);
    }

    public function gateway(): string
    {
        return config('services.payment.default_gateway', 'pay0shop');
    }
}
