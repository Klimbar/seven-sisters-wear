<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px; color: #333; }
        .invoice-box { max-width: 800px; margin: 0 auto; border: 1px solid #eee; padding: 30px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .company-info h1 { font-size: 24px; color: #2c3e50; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { font-size: 28px; color: #2c3e50; }
        .invoice-number { font-size: 14px; color: #666; margin-top: 5px; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 14px; font-weight: bold; color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 5px; margin-bottom: 15px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .info-item { margin-bottom: 10px; }
        .info-label { font-size: 12px; color: #666; }
        .info-value { font-size: 14px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f8f9fa; padding: 12px; text-align: left; font-size: 12px; font-weight: bold; color: #2c3e50; border-bottom: 2px solid #dee2e6; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; }
        .totals table { width: 300px; margin-left: auto; }
        .totals .label { color: #666; }
        .totals .value { text-align: right; font-weight: bold; }
        .grand-total { font-size: 18px; color: #2c3e50; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; }
        @media print { body { padding: 0; } .invoice-box { border: none; } }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                <h1>Traditional Ecommerce</h1>
                <p style="color: #666; font-size: 14px; margin-top: 5px;">Handloom & Handcrafted Products</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p class="invoice-number">{{ $order->order_number }}</p>
                <p style="font-size: 14px; color: #666; margin-top: 5px;">Date: {{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="section">
            <div class="info-grid">
                <div>
                    <div class="section-title">Bill To</div>
                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value">{{ $order->user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $order->user->email }}</div>
                    </div>
                </div>
                <div>
                    <div class="section-title">Ship To</div>
                    <div class="info-value">{!! nl2br(e($order->shipping_address)) !!}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Order Details</div>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Variant</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->product->name }}
                            @if($item->product->category)
                            <br><small style="color: #666;">{{ $item->product->category->name }}</small>
                            @endif
                        </td>
                        <td>
                            @if($item->variant)
                                {{ $item->variant->size ?? '' }} {{ $item->variant->color ?? '' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <table>
                <tr>
                    <td class="label">Subtotal</td>
                    <td class="value">₹{{ number_format($order->total_amount - 100 + $order->discount_amount, 2) }}</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr>
                    <td class="label">Discount</td>
                    <td class="value" style="color: #27ae60;">-₹{{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Shipping</td>
                    <td class="value">₹100.00</td>
                </tr>
                <tr>
                    <td class="label">Total</td>
                    <td class="value grand-total">₹{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="section" style="margin-top: 30px;">
            <div class="info-grid">
                <div>
                    <div class="section-title">Payment Details</div>
                    <div class="info-item">
                        <div class="info-label">Payment Method</div>
                        <div class="info-value">{{ ucfirst($order->payment_method) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Payment Status</div>
                        <div class="info-value">{{ ucfirst($order->payment_status) }}</div>
                    </div>
                </div>
                <div>
                    <div class="section-title">Order Status</div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">{{ ucfirst($order->status) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>For queries, contact us at support@traditionalecommerce.com</p>
        </div>
    </div>
</body>
</html>