<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order, public string $status) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->status) {
            'confirmed' => 'Order Confirmed - Your Order is Being Processed',
            'packed' => 'Order Packed - Ready for Shipping',
            'shipped' => 'Order Shipped - Track Your Package',
            'delivered' => 'Order Delivered - Thank You for Shopping!',
            'cancelled' => 'Order Cancelled - Refund Initiated',
            default => 'Order Status Update'
        };

        return new Envelope(
            subject: $subject.' - Order #'.$this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-update',
        );
    }
}
