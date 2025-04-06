<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order;

class OrderPaidNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Lưu vào DB và gửi realtime (nếu có)
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Đơn hàng #' . $this->order->id . ' đã được thanh toán qua vnpay thành công.',
            'order_id' => $this->order->id,
            'total_price' => $this->order->total_price,
        ];
    }
}
