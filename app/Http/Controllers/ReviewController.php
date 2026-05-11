<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product');
        }

        $hasOrdered = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('payment_status', 'completed');
        })->where('product_id', $product->id)->exists();

        if (! $hasOrdered) {
            return redirect()->back()->with('error', 'You can only review products you have purchased');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted');
    }

    public function adminIndex(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->has('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

        return inertia('Admin/Reviews/Index', [
            'reviews' => $reviews,
            'filters' => $request->only(['status']),
        ]);
    }

    public function updateStatus(Request $request, Review $review)
    {
        $request->validate([
            'is_approved' => 'required|boolean',
        ]);

        $review->update(['is_approved' => $request->is_approved]);

        return redirect()->back()->with('success', 'Review status updated');
    }

    public function destroyAdmin(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted');
    }
}
