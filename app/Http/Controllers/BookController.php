<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; 
use App\Models\Post; 
use Illuminate\Support\Str; // Thư viện xử lý chuỗi

class BookController extends Controller
{
    // =========================================================================
    // 1. TRANG CHỦ 
    // =========================================================================
    public function index(Request $request)
    {
        $books = Book::orderBy('id', 'desc')->take(5)->get();

        $filter = $request->get('filter', 'latest');
        
        // Chỉ lấy những bài đã được duyệt (published) nếu có cột status
        // Nếu chưa có cột status thì bỏ dòng ->where('status', 'published')
        $query = Post::with(['user', 'book'])
            ->withCount(['likes', 'comments']);

        if ($filter == 'viewed') {
            $query->orderBy('view_count', 'desc');
        } elseif ($filter == 'liked') {
            $query->orderBy('likes_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $latestReviews = $query->take(6)->get();

        return view('home', [
            'books' => $books,
            'latestReviews' => $latestReviews,
            'currentFilter' => $filter
        ]);
    }

    public function home(Request $request)
    {
        return $this->index($request);
    }

    // =========================================================================
    // 2. TRANG CHI TIẾT SÁCH
    // =========================================================================
    public function show($id)
    {
        // 1. Tìm sách hiện tại
        $query = Book::with(['categories']) // Load thêm categories để tìm sách liên quan
            ->withCount(['posts' => function ($q) {
                $q->where('status', 'published');
            }]);

        if (is_numeric($id)) {
            $book = $query->find($id);
        } else {
            $book = $query->where('slug', $id)->firstOrFail();
        }

        if (!$book) {
            return redirect()->route('home')->with('error', 'Không tìm thấy sách!');
        }

        // Tăng view
        $book->increment('view_count');

        // 2. Lấy Review (Giữ nguyên code cũ)
        $reviews = $book->reviews()
            ->where('status', 'published')
            ->with(['user', 'likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 3. [MỚI] Lấy sách liên quan (Cùng danh mục)
        $relatedBooks = collect();
        
        if ($book->categories->isNotEmpty()) {
            // Lấy danh sách ID các danh mục của sách này
            $categoryIds = $book->categories->pluck('id');

            $relatedBooks = Book::whereHas('categories', function ($q) use ($categoryIds) {
                                    $q->whereIn('categories.id', $categoryIds);
                                })
                                ->where('id', '!=', $book->id) // Loại trừ sách đang xem
                                ->inRandomOrder() // Lấy ngẫu nhiên
                                ->take(5) // Lấy 5 cuốn
                                ->get();
        }

        // Nếu không có sách cùng danh mục, lấy sách ngẫu nhiên khác
        if ($relatedBooks->isEmpty()) {
            $relatedBooks = Book::where('id', '!=', $book->id)
                                ->inRandomOrder()
                                ->take(5)
                                ->get();
        }

        // Truyền biến $relatedBooks sang View
        return view('book-detail', compact('book', 'reviews', 'relatedBooks'));
    }

    // =========================================================================
    // 3. TÌM KIẾM (TRANG KẾT QUẢ RIÊNG)
    // =========================================================================
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $books = Book::where('title', 'LIKE', "%{$keyword}%")->get();
        } else {
            $books = Book::orderBy('id', 'desc')->limit(12)->get();
        }

        return view('search-book', ['books' => $books]);
    }

    // =========================================================================
    // 4. AJAX SEARCH (CHO THANH TÌM KIẾM HEADER - ĐÃ SỬA URL & ẢNH)
    // =========================================================================
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('keyword');
        
        if(empty($keyword)) {
            return response()->json([]);
        }

        $books = Book::where('title', 'like', '%' . $keyword . '%')
                    ->take(5)
                    ->get()
                    ->map(function($book) {
                        
                        // Xử lý ảnh: Check link online hoặc file upload
                        $cover = $book->cover_image;
                        $imageUrl = 'https://via.placeholder.com/50';

                        if (!empty($cover)) {
                            // Dùng Str::startsWith để kiểm tra http
                            if (Str::startsWith($cover, 'http')) {
                                $imageUrl = $cover;
                            } else {
                                $imageUrl = asset('storage/' . $cover);
                            }
                        }

                        return [
                            'title' => $book->title,
                            'author_name' => $book->author_name ?? 'Đang cập nhật',
                            'image_url' => $imageUrl, 
                            
                            // Link chi tiết chuẩn (Sử dụng route 'detail')
                            // Đảm bảo trong web.php có: Route::get('/chi-tiet/{slug}', ...)->name('detail');
                            'url' => route('detail', $book->slug), 
                        ];
                    });

        return response()->json($books);
    }

    // =========================================================================
    // 5. SÁCH MỚI CẬP NHẬT
    // =========================================================================
    public function newBooks()
    {
        $books = Book::with('category')
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

        return view('list', [
            'books' => $books,
            'pageTitle' => 'Sách Mới Cập Nhật'
        ]);
    }

    // =========================================================================
    // 6. TRANG HIỂN THỊ ĐÁNH GIÁ SÁCH
    // =========================================================================
    public function showReviews($slug)
    {
        $book = Book::where('slug', $slug)
                    ->with('reviews')
                    ->firstOrFail();

        return view('book-reviews', [
            'book' => $book,
            'pageTitle' => 'Đánh giá sách: ' . $book->title
        ]);
    }
}