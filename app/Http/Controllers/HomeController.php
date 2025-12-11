<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Post; // <--- SỬA: Dùng Post thay vì Review
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Sách mới lên kệ
        // Lưu ý: Đã sửa thành 'categories' (số nhiều) để khớp với Model Book của bạn
        $books = Book::with('categories')->latest()->take(6)->get();

        // 2. Review cộng đồng (Thực chất là Post)
        $filter = $request->get('filter', 'latest');
        
        // <--- SỬA: Gọi từ model Post
        $reviewQuery = Post::with(['user', 'book']); 

        switch ($filter) {
            case 'liked':
                // Giả sử bảng posts có quan hệ likes hoặc cột likes_count
                // Nếu chưa có quan hệ likes, có thể nó sẽ báo lỗi tiếp ở đây. 
                // Tạm thời mình để orderBy theo rating hoặc created_at nếu chưa có like
                $reviewQuery->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'viewed':
                $reviewQuery->orderByDesc('created_at'); 
                break;
            default: // latest
                $reviewQuery->latest();
                break;
        }
        $latestReviews = $reviewQuery->where('status', 'published')->take(5)->get();

        // 3. Danh mục thể loại
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();

        // 4. Top Thịnh Hành
        $trendingBooks = Book::inRandomOrder()->take(5)->get();

        // Trả về View
        return view('home', compact('books', 'latestReviews', 'categories', 'trendingBooks', 'filter'));
    }
}