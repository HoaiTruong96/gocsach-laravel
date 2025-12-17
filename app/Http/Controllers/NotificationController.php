<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead(); // Đánh dấu đã đọc
            
            // Chuyển hướng đến link bài viết (nếu có)
            if (isset($notification->data['link'])) {
                return redirect($notification->data['link']);
            }
        }

        return redirect()->back();
    }

    public function readAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}