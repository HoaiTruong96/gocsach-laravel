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
        // 1. Số liệu thống kê
        // [ĐÃ SỬA] Đổi tên biến $totalBooks -> $bookCount để khớp với View HTML
        $bookCount = Book::count();

        $totalUsers = User::where('role', 'user')->count();
        $totalViews = Book::sum('view_count');

        $pendingReviewCount = Post::where('status', 'pending')
            ->whereNotNull('book_id')
            ->count();

        // 2. Lấy 5 bài review mới nhất
        $recentReviews = Post::with(['user', 'book'])
            ->whereNotNull('book_id')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'bookCount',          // <--- Đã cập nhật tên biến tại đây
            'totalUsers',
            'pendingReviewCount',
            'totalViews',
            'recentReviews'
        ));
    }
}
