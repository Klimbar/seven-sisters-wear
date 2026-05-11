<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['user', 'items.product.images', 'items.variant']);

        return inertia('Orders/Invoice', [
            'order' => $order,
        ]);
    }

    public function download(Order $order)
    {
        if ($order->user_id !== Auth::id() && ! Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $order->load(['user', 'items.product.images', 'items.variant']);

        return view('invoices.order-invoice', [
            'order' => $order,
        ])->header('Content-Type', 'application/pdf');
    }

    public function adminShow(Order $order)
    {
        $order->load(['user', 'items.product.images', 'items.variant']);

        return inertia('Admin/Orders/Invoice', [
            'order' => $order,
        ]);
    }
}
