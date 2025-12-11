<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewLikeNotification extends Notification
{
    use Queueable;

    protected $user;   // Người bấm like
    protected $post;   // Bài viết được like

    public function __construct($user, $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database']; // Lưu vào database
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'post_id' => $this->post->id,
            'post_title' => $this->post->book->title ?? 'bài viết',
            'message' => $this->user->name . ' đã thích bài review của bạn.',
            'link' => route('book.show', $this->post->book_id) // Link đến bài viết
        ];
    }
}