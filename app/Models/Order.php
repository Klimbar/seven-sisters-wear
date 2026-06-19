<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'total_amount', 'discount_amount',
        'shipping_address', 'payment_method', 'payment_status', 'status',
        'payment_transaction_id', 'payment_utr', 'payment_UTR', 'coupon_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'payment_status' => 'string',
        'status' => 'string',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if ($order->order_number) {
                return;
            }

            do {
                $orderNumber = 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
            } while (static::where('order_number', $orderNumber)->exists());

            $order->order_number = $orderNumber;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returnRequest(): HasOne
    {
        return $this->hasOne(ReturnRequest::class);
    }
}
