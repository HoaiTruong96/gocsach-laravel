<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Tính toán số liệu thống kê
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();

        // SỬA: Đếm bài viết có status là 'pending' (chờ duyệt)
        $pendingReviewCount = Post::where('status', 'pending')->count();

        $totalViews = Book::sum('view_count');

        // 2. Lấy 5 bài review mới nhất (Post có book_id)
        $recentReviews = Post::with(['user', 'book'])
            ->whereNotNull('book_id') // Chỉ lấy bài có review sách
            ->latest()
            ->take(5)
            ->get();

        // 3. Trả về view kèm các biến riêng lẻ
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'pendingReviewCount', // <--- Biến này dashboard đang thiếu
            'totalViews',
            'recentReviews'
        ));
    }
}
