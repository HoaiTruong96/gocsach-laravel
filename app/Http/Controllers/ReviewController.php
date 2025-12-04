<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; 
use Illuminate\Support\Facades\Auth; 

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // 1. Kiểm tra dữ liệu
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|min:10',
            'book_id' => 'required|exists:books,id'
        ]);

        // 2. Lưu vào Database
        Post::create([
            'user_id' => Auth::id() ?? 52, // ID user giả lập của bạn
            'book_id' => $request->input('book_id'),
            'rating' => $request->input('rating'),
            'content_text' => $request->input('content'), // <--- Quan trọng: Đổi key bên trái thành 'content_text'
            // 'is_approved' => 1 // Nếu cột này bắt buộc, hãy bỏ comment dòng này
        ]);

        // 3. Thông báo xong quay lại trang cũ
        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}