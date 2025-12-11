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

    // 2. TRANG CHI TIẾT SÁCH
    public function show($id)
    {
        if (is_numeric($id)) {
            $book = Book::with(['posts.user', 'posts.likes', 'posts.comments.user'])
                ->withCount('posts')
                ->find($id);
        } else {
            $book = Book::with(['posts.user', 'posts.likes', 'posts.comments.user'])
                ->withCount('posts')
                ->where('slug', $id)
                ->firstOrFail();
        }

        if (!$book) {
            return redirect()->route('home')->with('error', 'Không tìm thấy sách!');
        }

        return view('book-detail', compact('book'));
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
        $books = Book::with('category')
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

        return view('list', [
            'books' => $books,
            'pageTitle' => 'Sách Mới Cập Nhật'
        ]);
    }

    // 5. TRANG HIỂN THỊ ĐÁNH GIÁ SÁCH
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
