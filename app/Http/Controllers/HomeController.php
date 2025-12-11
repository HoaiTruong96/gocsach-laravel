<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Article;
use App\Models\Banner; // <--- [QUAN TRỌNG] Import Model Banner

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. [MỚI] Lấy Banner Slider từ Database
        // Lấy các banner đang active, sắp xếp theo thứ tự ưu tiên (order)
        $heroSlides = Banner::where('is_active', true)
                            ->orderBy('order', 'asc')
                            ->latest()
                            ->get();

        // Fallback: Nếu trong Database chưa có banner nào (lần đầu chạy),
        // tạo một collection giả lập để giao diện không bị trống.
        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([
                (object)[
                    'id' => null, // Không có ID để không hiện nút sửa
                    'title' => 'Cây Cam Ngọt Của Tôi',
                    'tag' => 'Sách Kinh Điển',
                    'description' => '"Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào của trí tưởng tượng..."',
                    'image' => 'https://library.hust.edu.vn/sites/default/files/C%C3%A2y%20cam%20ng%E1%BB%8Dt%20c%E1%BB%A7a%20t%C3%B4i%20-%20%E1%BA%A2nh%20b%C3%ACa.jpg',
                    'rating' => '4.9/5.0',
                    'link' => '#'
                ]
            ]);
        }

        // 2. Sách mới cập nhật (Lấy 10 cuốn cho slider)
        $books = Book::where('is_approved', true)
                    ->with('categories')
                    ->latest()
                    ->take(10)
                    ->get();

        // 3. Phần Tạp Chí Đọc (Lấy từ bảng articles)
        // a. Bài tiêu điểm (To nhất)
        $featuredArticle = Article::with('user')
                            ->where('is_featured', true)
                            ->latest()
                            ->first();

        // b. Các bài nhỏ bên cạnh (Không lấy bài featured để tránh trùng)
        $sidebarArticles = Article::with('user')
                            ->where('is_featured', false) // Lấy bài thường
                            ->latest()
                            ->take(2)
                            ->get();

        // 4. Review Cộng Đồng (Logic phân trang + lọc tim)
        $sortReview = $request->get('sort_review', 'latest');
        $commentQuery = Comment::with(['user', 'book']);

        if ($sortReview == 'popular') {
            // Sắp xếp theo số lượng like giảm dần (chỉ đếm is_like = 1)
            $commentQuery->withCount(['likes' => function ($q) {
                $q->where('is_like', 1);
            }])->orderByDesc('likes_count');
        } else {
            // Mặc định: Mới nhất
            $commentQuery->withCount(['likes' => function ($q) {
                $q->where('is_like', 1);
            }])->latest();
        }

        // Phân trang 5 item, giữ tham số URL, tự scroll xuống phần review
        $latestComments = $commentQuery->paginate(5)
                                       ->withQueryString()
                                       ->fragment('community-posts');

        // 5. Danh mục thể loại (Sidebar phải)
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();

        // Trả về View với đầy đủ dữ liệu
        return view('home', compact(
            'heroSlides',      // <--- Biến mới cho Slider
            'books', 
            'latestComments', 
            'categories', 
            'featuredArticle', 
            'sidebarArticles'
        ));
    }
}