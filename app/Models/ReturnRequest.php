<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ReturnRequest extends Model
{
    protected $fillable = [
        'order_id',
        'return_number',
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

    protected static function booted(): void
    {
        static::creating(function (ReturnRequest $returnRequest) {
            if ($returnRequest->return_number) {
                return;
            }

            do {
                $returnNumber = 'RET-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
            } while (static::where('return_number', $returnNumber)->exists());

            $returnRequest->return_number = $returnNumber;
        });
    }

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
