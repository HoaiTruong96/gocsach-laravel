<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; 
use App\Models\Post; 

class BookController extends Controller
{
    // 1. TRANG CHỦ (ĐÃ SỬA ĐỂ HIỆN REVIEW + LIKE/COMMENT)
    public function index(Request $request)
    {
        // 1. Lấy sách cho Slider
        $books = Book::orderBy('id', 'desc')->take(5)->get();

        // 2. Lấy Review Cộng Đồng (Kèm số lượng Like & Comment)
        $filter = $request->get('filter', 'latest');
        
        // [QUAN TRỌNG] withCount giúp đếm số lượng like và comment cho từng bài post
        $query = Post::with(['user', 'book'])
            ->withCount(['likes', 'comments']); 

        // Xử lý bộ lọc
        if ($filter == 'viewed') {
            $query->orderBy('view_count', 'desc'); // Lọc theo lượt xem
        } elseif ($filter == 'liked') {
            $query->orderBy('likes_count', 'desc'); // Lọc theo số lượng like
        } else {
            $query->orderBy('created_at', 'desc'); // Mặc định: Mới nhất
        }

        // Lấy 6 bài review
        $latestReviews = $query->take(6)->get();

        return view('home', [
            'books' => $books,
            'latestReviews' => $latestReviews, // Gửi biến này sang View
            'currentFilter' => $filter
        ]);
    }
    
    // (Để tương thích nếu route gọi là 'home' thay vì 'index')
    public function home(Request $request) {
        return $this->index($request);
    }

    // 2. TRANG CHI TIẾT SÁCH
    public function show($id)
    {
        // Kiểm tra xem tham số truyền vào là ID hay Slug để tìm cho đúng
        if (is_numeric($id)) {
            $book = Book::with(['posts.user', 'posts.likes', 'posts.comments.user'])
                ->withCount('posts') // Đếm tổng số bài review của sách
                ->find($id);
        } else {
            $book = Book::with(['posts.user', 'posts.likes', 'posts.comments.user'])
                ->withCount('posts')
                ->where('slug', $id)
                ->firstOrFail();
        }

        if (!$book) return redirect()->route('home')->with('error', 'Không tìm thấy sách!');

        // Lọc bài đã duyệt (nếu có cột status)
        // $book->setRelation('posts', $book->posts->where('status', 'published'));

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

    // 4. TRANG SÁCH MỚI
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
    public function showReviews($slug)
{
    // Lấy sách theo slug
    $book = Book::where('slug', $slug)->with('reviews')->firstOrFail();

    return view('book-reviews', [
        'book' => $book,
        'pageTitle' => 'Đánh giá sách: ' . $book->title
    ]);
}

}