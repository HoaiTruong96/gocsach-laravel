<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Post;

class BookController extends Controller
{
    // 1. TRANG CHỦ
    public function index(Request $request)
    {
        $books = Book::orderBy('id', 'desc')->take(5)->get();

        $filter = $request->get('filter', 'latest');
        
        // Chỉ lấy những bài đã được duyệt (published)
        $query = Post::with(['user', 'book'])
            ->where('status', 'published') // [QUAN TRỌNG]
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

    // 2. TRANG CHI TIẾT SÁCH
    public function show($id)
    {
        // Tìm sách theo ID hoặc Slug
        $query = Book::withCount(['posts' => function ($q) {
            $q->where('status', 'published'); // Chỉ đếm bài đã duyệt
        }]);

        if (is_numeric($id)) {
            $book = $query->find($id);
        } else {
            $book = $query->where('slug', $id)->firstOrFail();
        }

        if (!$book) {
            return redirect()->route('home')->with('error', 'Không tìm thấy sách!');
        }

        // Tăng lượt xem (nếu cần)
        $book->increment('view_count');

        // Lấy 3 review mới nhất để hiện ở trang chi tiết (Eager loading tối ưu)
        // Dùng quan hệ 'reviews' đã định nghĩa trong Model
        $reviews = $book->reviews()
            ->where('status', 'published')
            ->with(['user', 'likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('book-detail', compact('book', 'reviews'));
    }

    // 3. TÌM KIẾM
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

    // 4. SÁCH MỚI CẬP NHẬT
    public function newBooks()
    {
        // Kiểm tra xem có quan hệ category không để tránh lỗi
        $books = Book::orderBy('created_at', 'desc')->paginate(12);

        return view('list', [
            'books' => $books,
            'pageTitle' => 'Sách Mới Cập Nhật'
        ]);
    }

    // 5. TRANG HIỂN THỊ TẤT CẢ ĐÁNH GIÁ CỦA SÁCH
    public function showReviews($slug)
    {
        // 1. Tìm sách trước
        $book = Book::where('slug', $slug)->firstOrFail();

        // 2. Lấy danh sách review của sách đó (Phân trang)
        // [QUAN TRỌNG] Eager loading 'user' để hiển thị avatar, tên người viết
        // Eager loading 'activeBadges' để hiện huy hiệu (như bạn yêu cầu lúc nãy)
        $reviews = Post::where('book_id', $book->id)
            ->where('status', 'published')
            ->with(['user.activeBadges', 'comments.user', 'likes']) 
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Phân trang 10 bài/trang

        // 3. Trả về view 'review-detail' (Tên view bạn đã tạo)
        return view('review-detail', [
            'book' => $book,
            'reviews' => $reviews
        ]);
    }
}