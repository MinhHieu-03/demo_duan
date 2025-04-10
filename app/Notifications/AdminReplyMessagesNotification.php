<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminReplyMessagesNotification extends Notification
{
    use Queueable;

    protected $reply;

    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Lưu vào DB và gửi realtime (nếu có)
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'LaptopStore đã trả lời tin nhắn của bạn: "' . $this->reply . '".',
            'url' => route('messages.index'), // hoặc route đến trang chat của user
        ];
    }
    
}