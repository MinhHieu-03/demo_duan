<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomerMessageNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Lưu vào DB và gửi realtime (nếu có)
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Khách hàng đã gửi tin nhắn: "' . $this->message . '".',
            'url' => route('admin.messages.index', ['sender_id' => auth()->id()]),

        ];
    }
}