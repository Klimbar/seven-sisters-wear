<!DOCTYPE html>
<html>
<head>
    <title>Return Request Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #8B2323; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .details { background: #fff; padding: 15px; border-radius: 6px; margin: 15px 0; }
        .status { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; }
        .status-pending { background: #FFF3CD; color: #856404; }
        .status-approved { background: #D4EDDA; color: #155724; }
        .status-picked_up { background: #DDE7FF; color: #243B7A; }
        .status-in_transit { background: #E8DDFF; color: #4B2E83; }
        .status-received { background: #D1F3ED; color: #0F5B4F; }
        .status-rejected { background: #F8D7DA; color: #721C24; }
        .status-refunded { background: #D4EDDA; color: #155724; }
        .refund-amount { font-size: 24px; font-weight: bold; color: #8B2323; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    @php
        $order = $returnRequest->order;
        $orderReference = $order?->order_number ?: '#'.$returnRequest->order_id;
        $returnReference = $returnRequest->return_number ?: 'RET-'.str_pad((string) $returnRequest->id, 6, '0', STR_PAD_LEFT);
        $statusLabel = ucwords(str_replace('_', ' ', $returnRequest->status));
        $paymentMethod = strtoupper((string) ($order?->payment_method ?? ''));
        $refundDestination = match ($order?->payment_method) {
            'upi', 'netbanking', 'wallet' => 'the original payment method used for this order',
            'cod' => 'your bank account or UPI ID after our support team confirms the refund details',
            default => 'the eligible refund method linked to this order',
        };
    @endphp

    <div class="header">
        <h1>Seven Sisters Wear</h1>
        <p>Return Request Update</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $returnRequest->user->name }},</p>
        
        <p>Your return request <strong>{{ $returnReference }}</strong> for Order <strong>{{ $orderReference }}</strong> has been updated.</p>
        
        <div class="details">
            <h3>Return Details</h3>
            <p><strong>Return ID:</strong> {{ $returnReference }}</p>
            <p><strong>Order ID:</strong> {{ $orderReference }}</p>
            <p><strong>Reason:</strong> {{ $returnRequest->reason }}</p>
            <p><strong>Status:</strong>
                <span class="status status-{{ $returnRequest->status }}">
                    {{ $statusLabel }}
                </span>
            </p>
        </div>

        @if(in_array($returnRequest->status, ['approved', 'picked_up', 'in_transit', 'received', 'refunded']))
        <div class="details">
            <h3>Pickup Details</h3>
            <p><strong>Pickup Date:</strong> {{ optional($returnRequest->pickup_date)->format('d M Y') ?: 'To be confirmed' }}</p>
            <p><strong>Pickup Address:</strong><br>{!! nl2br(e($returnRequest->pickup_address ?: 'To be confirmed')) !!}</p>

            @if($returnRequest->tracking_number)
            <p><strong>Tracking Number:</strong> {{ $returnRequest->tracking_number }}</p>
            @endif
        </div>
        @endif

        @if($returnRequest->refund_amount)
        <div class="refund-amount">
            Refund Amount: ₹{{ number_format($returnRequest->refund_amount, 2) }}
        </div>
        @endif

        <div class="details">
            <h3>Refund Information</h3>
            <p><strong>Payment Method:</strong> {{ $paymentMethod ?: 'Not available' }}</p>
            <p>
                @if($returnRequest->status === 'refunded')
                    Your refund has been marked as processed to {{ $refundDestination }}.
                @elseif(in_array($returnRequest->status, ['approved', 'picked_up', 'in_transit', 'received']))
                    The refund will be issued to {{ $refundDestination }} after the returned item is received and verified.
                @elseif($returnRequest->status === 'rejected')
                    No refund will be issued for this rejected return request.
                @else
                    Refund details will be shared after the return request is reviewed.
                @endif
            </p>
        </div>
        
        @if($returnRequest->admin_notes)
        <h3>Admin Notes</h3>
        <p>{{ $returnRequest->admin_notes }}</p>
        @endif
        
        <p>If you have any questions, please contact our support team.</p>
        
        <p>Thank you for shopping with <strong>Seven Sisters Wear</strong>!</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Seven Sisters Wear. All rights reserved.</p>
        <p>This is an automated email. Please do not reply.</p>
    </div>
</body>
</html>
