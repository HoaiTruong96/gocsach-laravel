<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostApprovedNotification extends Notification
{
    use Queueable;
    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database']; // Quan trọng: Lưu vào database
    }

    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'title'   => 'Bài viết đã được duyệt',
            'message' => 'Bài review "' . $this->post->title . '" của bạn đã được công khai.',
            'link'    => route('detail', $this->post->book->slug ?? '#'), // Link tới sách
            'icon'    => 'fas fa-check-circle',
            'color'   => 'text-green-500'
        ];
    }
}