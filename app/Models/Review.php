<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'rating', 'comment', 'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReviewImage::class);
    }

    public static function averageRating($productId): float
    {
        return self::where('product_id', $productId)
            ->where('is_approved', true)
            ->avg('rating') ?? 0;
    }

    public static function reviewCount($productId): int
    {
        return self::where('product_id', $productId)
            ->where('is_approved', true)
            ->count();
    }
}
