<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
{
    // Kiểm tra nếu người nhận là admin
    if ($notifiable->isAdmin()) {
        return ['database']; // Chỉ lưu thông báo trong database
    }

    return ['mail', 'database']; // Gửi email và lưu thông báo trong database cho khách hàng
}

public function toMail($notifiable)
{
    if (!$notifiable->isAdmin()) {
        return (new MailMessage)
                    ->line('Bạn có bình luận mới từ ' . $this->comment->name)
                    ->action('Xem bình luận', url('/categories/' . $this->comment->category_slug))
                    ->line('Nội dung: ' . $this->comment->comment);
    }

    return null;
}

public function toArray($notifiable)
{
    return [
        'comment_id'   => $this->comment->id,
        'comment'      => $this->comment->comment,
        'user_name'    => $this->comment->name,
        'category_id'  => $this->comment->category_id,
        'message'      => $this->comment->name . ' đã bình luận về sản phẩm.',
        'url'          => route('admin.comments.index')
    ];
}

}
