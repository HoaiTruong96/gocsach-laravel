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

    // --- [MỚI] 2. TRANG DANH SÁCH SÁCH & TÌM KIẾM ---
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $books = Book::with('categories');

        if ($keyword) {
            $books->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('author_name', 'LIKE', "%{$keyword}%");
            });
        }

        $books = $books->latest()->paginate(12)->appends($request->all());

        return view('list', compact('books', 'keyword'));
    }

    // --- [MỚI] 3. API GỢI Ý TÌM KIẾM (AJAX) ---
    public function ajaxSearch(Request $request)
    {
        $query = $request->get('keyword');
        
        if (!$query) {
            return response()->json([]);
        }

        $books = Book::with('categories')
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->take(5) // Chỉ lấy 5 kết quả
            ->get();

        return response()->json($books);
    }

    // 4. TRANG CHI TIẾT SÁCH
    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        $book->load(['posts' => function ($query) {
            $query->where('status', 'published')->latest(); 
        }, 'posts.user']);

        return view('book-detail', compact('book'));
    }

    // 5. TRANG TÌM KIẾM ĐỂ VIẾT REVIEW (Giữ nguyên cho luồng Review)
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

    // 6. TRANG DANH SÁCH REVIEW CHI TIẾT
    public function showReviews($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        $reviews = Post::where('book_id', $book->id)
            ->where('status', 'published')
            ->with('user')                 
            ->latest()                     
            ->paginate(3);                 

        return view('review-detail', compact('book', 'reviews'));
    }
    
    // 7. SÁCH MỚI (Có thể bỏ hoặc giữ tùy nhu cầu, vì hàm index đã bao gồm logic này)
    public function newBooks()
    {
        $books = Book::with('categories')->orderBy('created_at', 'desc')->paginate(12);
        return view('list', ['books' => $books, 'title' => 'Sách Mới Cập Nhật']);
    }
}