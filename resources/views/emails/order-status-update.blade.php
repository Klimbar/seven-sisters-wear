<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #8B2323; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #27ae60; color: white; border-radius: 5px; font-weight: bold; }
        .order-details { margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Seven Sisters Wear</h1>
        <p>Order Status Update</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $order->user->name }},</p>
        
        <p>Your order status has been updated:</p>
        
        <div class="order-details">
            <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
            <p><strong>Current Status:</strong> <span class="status-badge">{{ ucfirst($status) }}</span></p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>
        
        @if($status === 'shipped')
        <p>Your order has been shipped and is on its way to you. You will receive your package soon.</p>
        @elseif($status === 'delivered')
        <p>Your order has been delivered! Thank you for shopping with us. We hope you enjoy your purchase.</p>
        <p>Please take a moment to leave a review for your purchased items.</p>
        @elseif($status === 'cancelled')
        <p>Your order has been cancelled. If you made a payment, the refund will be processed within 5-7 business days.</p>
        @else
        <p>We'll continue to keep you updated on your order progress.</p>
        @endif
        
        <p>Thank you for shopping with <strong>Seven Sisters Wear</strong>!</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Seven Sisters Wear. All rights reserved.</p>
        <p>Track your order at: {{ url('/orders/' . $order->id) }}</p>
    </div>
</body>
</html>