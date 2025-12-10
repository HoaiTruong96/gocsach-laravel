<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Gọi Model Book
use App\Models\Post; // Gọi Model Post (Review)

class BookController extends Controller
{
    // 1. TRANG CHỦ (Nếu bạn dùng HomeController thì hàm này có thể không cần thiết ở đây, nhưng cứ để nếu bạn muốn giữ)
    public function home(Request $request)
    {
        // A. Lấy sách cho Slider (5 cuốn mới nhất)
        $books = Book::orderBy('id', 'desc')->take(5)->get();

        return view('home', compact('books'));
    }

    // 2. TRANG CHI TIẾT SÁCH (Đã sửa lỗi thiếu code)
    public function show($slug)
    {
        // Tìm sách theo slug, nếu không thấy thì báo lỗi 404
        $book = Book::where('slug', $slug)->firstOrFail();

        // (Tùy chọn) Tăng lượt xem
        // $book->increment('view_count');

        // Trả về view chi tiết sách
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

    // 4. TRANG DANH SÁCH REVIEW (MỚI THÊM)
    public function showReviews($slug)
    {
        // Lấy thông tin sách
        $book = Book::where('slug', $slug)->firstOrFail();

        // Lấy danh sách review của sách đó, phân trang 3 bài
        $reviews = Post::where('book_id', $book->id)
            ->where('status', 'published') // Chỉ lấy bài đã duyệt (nếu có cột status)
            ->with('user')                 // Lấy kèm thông tin người viết
            ->latest()                     // Mới nhất lên đầu
            ->paginate(3);                 // 3 bài mỗi trang

        return view('review-detail', compact('book', 'reviews'));
    }
}