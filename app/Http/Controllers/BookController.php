<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; 
use App\Models\Post; 

class BookController extends Controller
{
    // 1. TRANG CHỦ
    public function home(Request $request)
    {
        $books = Book::orderBy('id', 'desc')->take(5)->get();
        return view('home', compact('books'));
    }

    // 2. TRANG CHI TIẾT SÁCH (SỬA CHỖ NÀY)
    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // [MỚI] Load quan hệ 'posts' (Review) nhưng LỌC chỉ lấy bài 'published'
        // Cách này giúp $book->posts trong view chỉ hiện bài đã duyệt
        $book->load(['posts' => function ($query) {
            $query->where('status', 'published')->latest(); 
        }, 'posts.user']); // Load kèm user để hiện avatar người review

        // (Tùy chọn) Tính điểm trung bình chỉ dựa trên các bài đã duyệt
        // $avgRating = $book->posts->where('status', 'published')->avg('rating');

        return view('book-detail', compact('book'));
    }

    // 3. TRANG TÌM KIẾM
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

    // 4. TRANG DANH SÁCH REVIEW (ĐÃ ỔN - GIỮ NGUYÊN)
    public function showReviews($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        $reviews = Post::where('book_id', $book->id)
            ->where('status', 'published') // Dòng này quan trọng, giữ nguyên
            ->with('user')                 
            ->latest()                     
            ->paginate(3);                 
        $query = Post::with(['user', 'book'])
            ->withCount(['likes', 'comments']); 
        return view('review-detail', compact('book', 'reviews'));
    }
    public function newBooks()
    {
        // Lấy sách sắp xếp theo ngày tạo mới nhất, phân trang 12 cuốn
        $books = Book::with('categories')
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

        // Tận dụng lại view 'list' (Danh sách) nhưng truyền biến $title khác đi
        return view('list', [
            'books' => $books,
            'pageTitle' => 'Sách Mới Cập Nhật' // Tiêu đề tùy chỉnh
        ]);
    }
}