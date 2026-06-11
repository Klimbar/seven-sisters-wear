<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Pay0ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected Pay0ShopService $pay0ShopService;

    public function __construct(Pay0ShopService $pay0ShopService)
    {
        $this->pay0ShopService = $pay0ShopService;
    }

    /**
     * Initiate payment for an order
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->payment_status !== 'pending') {
            return response()->json(['error' => 'Payment already processed'], 400);
        }

        $user = Auth::user();
        $callbackUrl = config('services.pay0shop.callback_url') . '/payment/callback';

        $response = $this->pay0ShopService->createOrder([
            'customer_mobile' => $user->phone ?? '9999999999',
            'customer_name' => $user->name ?? 'Customer',
            'amount' => (float) $order->total_amount,
            'order_id' => $order->order_number,
            'redirect_url' => $callbackUrl,
            'remark1' => 'Order Payment',
            'remark2' => 'Seven Sisters Wear',
        ]);

        if ($response['status'] ?? false) {
            $order->update([
                'payment_transaction_id' => $response['result']['orderId'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $response['result']['payment_url'] ?? null,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'] ?? 'Payment initiation failed',
        ], 400);
    }

    /**
     * Handle payment callback/redirect
     */
    public function callback(Request $request)
    {
        $orderId = $request->query('order_id') ?? $request->order_id;

        if (!$orderId) {
            return redirect()->route('checkout')->with('error', 'Invalid payment response');
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        $response = $this->pay0ShopService->checkOrderStatus($orderId);

        if ($response['status'] ?? false) {
            $txnStatus = $response['result']['txnStatus'] ?? 'PENDING';

            if ($txnStatus === 'SUCCESS') {
                $order->update([
                    'payment_status' => 'completed',
                    'status' => 'processing',
                    'payment_utr' => $response['result']['utr'] ?? null,
                ]);

                return redirect()->route('orders.show', $order)
                    ->with('success', 'Payment successful! Order is processing.');
            } elseif ($txnStatus === 'PENDING') {
                $order->update(['payment_status' => 'pending']);

                return redirect()->route('orders.show', $order)
                    ->with('info', 'Payment is pending. We will update you when it is completed.');
            }
        }

        $order->update(['payment_status' => 'failed']);

        return redirect()->route('checkout')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Handle Pay0Shop webhook for payment updates
     */
    public function webhook(Request $request)
    {
        // Verify secret key for security
        $secretKey = config('services.pay0shop.secret_key');
        $requestSecret = $request->header('X-Secret-Key') ?? $request->secret_key;

        if ($secretKey && $requestSecret !== $secretKey) {
            Log::warning('Pay0Shop Webhook: Invalid secret key');
            return response()->json(['error' => 'Invalid secret key'], 401);
        }

        Log::info('Pay0Shop Webhook Received', $request->all());

        $status = $request->status;
        $orderId = $request->order_id;
        $amount = $request->amount;

        if (!$orderId) {
            return response()->json(['error' => 'Missing order_id'], 400);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning("Pay0Shop Webhook: Order not found - {$orderId}");
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($status === 'SUCCESS') {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
                'payment_utr' => $request->utr ?? null,
            ]);

            Log::info("Pay0Shop Webhook: Payment successful for order {$orderId}");
        } elseif ($status === 'FAILED') {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);

            Log::info("PayIN Webhook: Payment failed for order {$orderId}");
        }

        return response()->json(['success' => true]);
    }
}
