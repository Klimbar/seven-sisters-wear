<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'description',
        'status',
        'refund_amount',
        'admin_notes',
        'pickup_address',
        'tracking_number',
        'pickup_date',
        'refund_date',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'pickup_date' => 'datetime',
        'refund_date' => 'datetime',
    ];

    public static function statuses(): array
    {
        return ['pending', 'approved', 'picked_up', 'in_transit', 'received', 'refunded', 'rejected'];
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'approved']);
    }

    public function canRequestRefund(): bool
    {
        return in_array($this->status, ['received', 'approved']);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
