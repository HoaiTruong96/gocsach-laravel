<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Gọi Model Book
use App\Models\Post; // Gọi Model Post (Review)

class BookController extends Controller
{
    // 1. TRANG CHỦ
    public function home(Request $request)
    {
        // A. Lấy sách cho Slider (5 cuốn mới nhất)
        $books = Book::orderBy('id', 'desc')->take(5)->get();

        return view('home', compact('books'));
    }

    public function show($slug)


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
    // ... các hàm cũ ...

    // 4. TRANG DANH SÁCH REVIEW (MỚI THÊM)
    public function showReviews($slug)
    {
        // Lấy thông tin sách
        $book = Book::where('slug', $slug)->firstOrFail();

        // Lấy danh sách review của sách đó, phân trang 5 bài
        $reviews = Post::where('book_id', $book->id)
            ->where('status', 'published') // Chỉ lấy bài đã duyệt
            ->with('user')                 // Lấy kèm thông tin người viết
            ->latest()                     // Mới nhất lên đầu
            ->paginate(3);                 // 3 bài mỗi trang

        return view('review-detail', compact('book', 'reviews'));
    }
}
    

