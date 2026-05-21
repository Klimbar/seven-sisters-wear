<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'total_amount', 'discount_amount',
        'shipping_address', 'payment_method', 'payment_status', 'status',
        'payment_transaction_id', 'payment_utr', 'coupon_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'payment_status' => 'string',
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
