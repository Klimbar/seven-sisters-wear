<!DOCTYPE html>
<html>
<head>
    <title>Return Request Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #8B2323; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .status { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; }
        .status-pending { background: #FFF3CD; color: #856404; }
        .status-approved { background: #D4EDDA; color: #155724; }
        .status-rejected { background: #F8D7DA; color: #721C24; }
        .status-refunded { background: #D4EDDA; color: #155724; }
        .refund-amount { font-size: 24px; font-weight: bold; color: #8B2323; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Seven Sisters Wear</h1>
        <p>Return Request Update</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $returnRequest->user->name }},</p>
        
        <p>Your return request for Order #{{ $returnRequest->order_id }} has been updated.</p>
        
        <h3>Return Details</h3>
        <p><strong>Return Request ID:</strong> #{{ $returnRequest->id }}</p>
        <p><strong>Reason:</strong> {{ $returnRequest->reason }}</p>
        
        <p><strong>Status:</strong> 
            <span class="status status-{{ $returnRequest->status }}">
                {{ ucfirst($returnRequest->status) }}
            </span>
        </p>
        
        @if($returnRequest->refund_amount)
        <div class="refund-amount">
            Refund Amount: ₹{{ number_format($returnRequest->refund_amount, 2) }}
        </div>
        @endif
        
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