<?php

namespace App\Http\Controllers;

use App\Mail\ReturnStatusUpdate;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReturnController extends Controller
{
    // Customer: List their return requests
    public function index()
    {
        $returns = ReturnRequest::with('order')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return inertia('Returns/Index', [
            'returns' => $returns,
        ]);
    }

    // Customer: Show return request details
    public function show(ReturnRequest $returnRequest)
    {
        if ($returnRequest->user_id !== Auth::id()) {
            abort(403);
        }

        $returnRequest->load('order.items.product.images');

        return inertia('Returns/Show', [
            'returnRequest' => $returnRequest,
        ]);
    }

    // Customer: Create return request page
    public function create(Request $request)
    {
        $orderId = $request->query('order_id');

        if (! $orderId) {
            return redirect('/orders')->with('error', 'No order specified');
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status !== 'delivered') {
            return redirect('/orders')->with('error', 'Only delivered orders can be returned');
        }

        return inertia('Returns/Create', [
            'order' => $order,
        ]);
    }

    // Customer: Create return request for an order
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reason' => 'required|string',
            'description' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Verify the order belongs to this user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if order can be returned (only delivered orders)
        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Only delivered orders can be returned');
        }

        // Check if there's already a return request
        $existing = ReturnRequest::where('order_id', $order->id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'A return request already exists for this order');
        }

        ReturnRequest::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('returns.index')->with('success', 'Return request submitted successfully');
    }

    // Admin: List all return requests
    public function adminIndex(Request $request)
    {
        $query = ReturnRequest::with(['order', 'user']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $returns = $query->orderBy('created_at', 'desc')->paginate(20);

        return inertia('Admin/Returns/Index', [
            'returns' => $returns,
            'filters' => $request->only(['status']),
        ]);
    }

    // Admin: Show return request details
    public function adminShow(ReturnRequest $returnRequest)
    {
        $returnRequest->load('order.items.product.images', 'user');

        return inertia('Admin/Returns/Show', [
            'returnRequest' => $returnRequest,
        ]);
    }

    // Admin: Approve or reject return request
    public function updateStatus(Request $request, ReturnRequest $returnRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,refunded',
            'refund_amount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $returnRequest->update([
            'status' => $request->status,
            'refund_amount' => $request->refund_amount,
            'admin_notes' => $request->admin_notes,
        ]);

        // If approved or refunded, update the order status
        if (in_array($request->status, ['approved', 'refunded'])) {
            $returnRequest->order->update(['status' => 'returned']);
        }

        // Send email notification to customer
        $returnRequest->load('user');
        Mail::to($returnRequest->user->email)->send(new ReturnStatusUpdate($returnRequest));

        return redirect()->back()->with('success', 'Return request updated successfully');
    }
}
