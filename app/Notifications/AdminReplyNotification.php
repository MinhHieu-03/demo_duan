<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Comment;
use Illuminate\Notifications\Messages\MailMessage;

class AdminReplyNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'comment_id'   => $this->comment->id,
            'comment'      => $this->comment->comment, // Nội dung comment
            'user_name'    => $this->comment->name, // Tên người bình luận
            'admin_reply'  => $this->comment->admin_reply, // Nội dung phản hồi admin
            'category_id'  => $this->comment->category_id, // ID danh mục
            'message'      => 'Admin phản hồi!',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Admin đã phản hồi bình luận của bạn.')
                    ->action('Xem phản hồi', url('/categories/' . $this->comment->category->slug))
                    ->line('Nội dung bình luận: ' . $this->comment->comment)
                    ->line('Phản hồi từ Admin: ' . $this->comment->admin_reply);
    }
}
