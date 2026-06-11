<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #8B2323; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .order-details { margin: 20px 0; }
        .order-item { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .total { font-size: 18px; font-weight: bold; color: #8B2323; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Seven Sisters Wear</h1>
        <p>Order Confirmation</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $order->user->name }},</p>
        
        <p>Thank you for your order! We have received your order and it's being processed.</p>
        
        <div class="order-details">
            <h3>Order Details</h3>
            <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>
        
        <h3>Items Ordered</h3>
        @foreach($order->items as $item)
        <div class="order-item">
            <p><strong>{{ $item->product->name }}</strong></p>
            @if($item->variant)
                <p>Variant: {{ collect([$item->variant->size, $item->variant->color])->filter()->implode(' / ') }}</p>
            @endif
            <p>Quantity: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
            <p>Subtotal: ₹{{ number_format($item->quantity * $item->price, 2) }}</p>
        </div>
        @endforeach
        
        <p class="total">Total: ₹{{ number_format($order->total_amount, 2) }}</p>
        
        <h3>Shipping Address</h3>
        <p>{!! nl2br(e($order->shipping_address)) !!}</p>
        
        <p>We'll notify you when your order is processing, shipped, and delivered.</p>
        
        <p>Thank you for shopping with <strong>Seven Sisters Wear</strong>!</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Seven Sisters Wear. All rights reserved.</p>
        <p>This is an automated email. Please do not reply.</p>
    </div>
</body>
</html>
