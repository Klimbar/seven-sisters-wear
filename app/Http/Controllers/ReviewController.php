<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:5120',
        ]);

        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->withErrors([
                'review' => 'You have already reviewed this product',
            ]);
        }

        $hasOrdered = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('payment_status', 'completed');
        })->where('product_id', $product->id)->exists();

        if (! $hasOrdered) {
            return redirect()->back()->withErrors([
                'review' => 'You can only review products you have purchased',
            ]);
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        $this->storeImages($review, $request->file('images', []));

        return redirect()->back()->with('success', 'Review submitted successfully');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:5120',
            'remove_image_ids' => 'nullable|array',
            'remove_image_ids.*' => 'integer|exists:review_images,id',
        ]);

        $removeImageIds = $request->input('remove_image_ids', []);
        if ($removeImageIds) {
            $review->images()
                ->whereIn('id', $removeImageIds)
                ->get()
                ->each(function (ReviewImage $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                });
        }

        $existingImageCount = $review->images()->count();
        $newImages = $request->file('images', []);

        if ($existingImageCount + count($newImages) > 5) {
            return redirect()->back()->withErrors([
                'images' => 'A review can have up to 5 images.',
            ]);
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        $this->storeImages($review, $newImages);

        return redirect()->back()->with('success', 'Review updated successfully');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->images->each(function (ReviewImage $image) {
            Storage::disk('public')->delete($image->image_path);
        });

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted');
    }

    private function storeImages(Review $review, array $images): void
    {
        foreach ($images as $image) {
            $review->images()->create([
                'image_path' => $image->store('reviews', 'public'),
            ]);
        }
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
        $review->images->each(function (ReviewImage $image) {
            Storage::disk('public')->delete($image->image_path);
        });

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted');
    }
}
