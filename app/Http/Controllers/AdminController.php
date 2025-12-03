<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Gọi Model Book
use App\Models\User; // Gọi thêm Model User để đếm thành viên

class AdminController extends Controller
{
    /**
     * Hiển thị trang Dashboard quản trị
     */
    public function index()
    {
        // 1. Lấy tổng số sách (Kiểm tra xem class Book có tồn tại không để tránh lỗi)
        $bookCount = class_exists(Book::class) ? Book::count() : 0;
        
        // 2. Lấy tổng số thành viên (Trừ admin ra nếu muốn, ở đây mình đếm hết)
        $userCount = User::count();

        // 3. Trả về view và truyền cả 2 biến sang
        return view('admin.dashboard', compact('bookCount', 'userCount'));
    }
}