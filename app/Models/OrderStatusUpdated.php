<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Order Status Has Been Updated')
            ->line('Dear ' . $this->order->user->name . ',')
            ->line('Your order #' . $this->order->id . ' has been updated to: **' . ucfirst($this->order->status) . '**.')
            ->action('View Order', route('user.orders.show', $this->order))
            ->line('Thank you for shopping with us!');
    }
}
