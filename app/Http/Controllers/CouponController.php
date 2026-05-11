<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (! $coupon) {
            return response()->json(['error' => 'Invalid coupon code'], 422);
        }

        if (! $coupon->isValid()) {
            return response()->json(['error' => 'Coupon is expired or invalid'], 422);
        }

        return response()->json([
            'coupon' => $coupon,
            'message' => 'Coupon applied successfully',
        ]);
    }

    public function remove(Request $request)
    {
        return response()->json(['message' => 'Coupon removed']);
    }

    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(20);

        return inertia('Admin/Coupons/Index', [
            'coupons' => $coupons,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'expiry_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->back()->with('success', 'Coupon created successfully');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,'.$coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'expiry_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->back()->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon deleted successfully');
    }
}
