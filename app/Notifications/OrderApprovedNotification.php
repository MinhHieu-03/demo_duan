<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order;

class OrderApprovedNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; 
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Đơn hàng của bạn đã được duyệt.',
            'order_id' => $this->order->id,
            'url' => route('my.orders'), // Chuyển hướng đến danh sách đơn hàng của người dùng
        ];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Đơn hàng đã được duyệt')
            ->line('Đơn hàng của bạn đã được duyệt.')
            ->action('Xem đơn hàng', route('my.orders')) // Điều hướng đến danh sách đơn hàng của người dùng
            ->line('Cảm ơn bạn đã mua hàng!');
    }
}
