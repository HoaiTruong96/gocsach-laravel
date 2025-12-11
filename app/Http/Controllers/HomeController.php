<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment; // <--- [QUAN TRỌNG] Phải import Model Comment

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ... (Code lấy $books giữ nguyên) ...
        $books = Book::where('is_approved', true)->with('categories')->latest()->take(10)->get();

        // --- [SỬA ĐOẠN NÀY] LOGIC REVIEW CỘNG ĐỒNG ---
        
        // 1. Lấy tham số filter từ URL (mặc định là 'latest')
        $sortReview = $request->get('sort_review', 'latest');

        // 2. Khởi tạo query cho Comment
        $commentQuery = Comment::with(['user', 'book']);

        // 3. Xử lý sắp xếp
        if ($sortReview == 'popular') {
            // Sắp xếp theo số lượng like giảm dần
            // Chỉ đếm các row có is_like = 1
            $commentQuery->withCount(['likes' => function ($q) {
                $q->where('is_like', 1);
            }])->orderByDesc('likes_count');
        } else {
            // Mặc định: Mới nhất
            $commentQuery->withCount(['likes' => function ($q) {
                $q->where('is_like', 1);
            }])->latest();
        }

        // 4. Phân trang (5 comment mỗi trang)
        // ->withQueryString(): Giữ lại các tham số URL khi chuyển trang
        // ->fragment('community-posts'): Tự động cuộn xuống phần này khi bấm trang
        $latestComments = $commentQuery->paginate(5)->withQueryString()->fragment('community-posts');

        // ... (Code danh mục category giữ nguyên) ...
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();

    return view('home', compact('books', 'latestComments', 'categories'));
    }
}