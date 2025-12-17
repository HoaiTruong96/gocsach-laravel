<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; 
use App\Models\Post; 
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;

class BookController extends Controller
{
    // --- HÀM HỖ TRỢ: Lấy sách kèm tính toán điểm trung bình ---
    private function getBookQuery()
    {
        return Book::where('is_approved', true)
                   ->withAvg(['posts' => function($q) {
                       $q->where('status', 'published');
                   }], 'rating'); 
    }

    // 1. TRANG CHỦ 
    public function index(Request $request)
    {   
        $books = $this->getBookQuery()
                    ->orderBy('id', 'desc')
                    ->take(5)
                    ->get();

        $filter = $request->get('filter', 'latest');
        $query = Post::with(['user', 'book'])
            ->where('status', 'published') 
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

    // 2. TRANG CHI TIẾT SÁCH (ĐÃ SỬA LỖI)
    public function show($id)
    {
        $query = $this->getBookQuery();

        if (is_numeric($id)) {
            $query->where('id', $id);
        } else {
            $query->where('slug', $id);
        }

        // 1. Lấy thông tin sách
        $book = $query->with('categories')->firstOrFail();
        $book->avg_rating = round($book->posts_avg_rating ?? 0, 1);

        // 2. Tăng lượt xem (Session check)
        $sessionKey = 'book_viewed_' . $book->id;
        if (!Session::has($sessionKey)) {
            $book->increment('view_count');
            Session::put($sessionKey, true);
        }

        // 3. [FIXED] Lấy danh sách Review (có phân trang) để biến $reviews tồn tại
        $reviews = $book->posts()
                        ->with(['user', 'likes', 'comments.user']) // Eager load để tối ưu
                        ->where('status', 'published')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5); // 5 review mỗi trang

        // 4. [FIXED] Lấy sách liên quan (cùng danh mục) để biến $relatedBooks tồn tại
        $relatedBooks = Book::where('is_approved', true)
                            ->whereHas('categories', function($q) use ($book) {
                                $q->whereIn('categories.id', $book->categories->pluck('id'));
                            })
                            ->where('id', '!=', $book->id) // Trừ cuốn hiện tại ra
                            ->take(4)
                            ->get();

        // Truyền đủ 3 biến: book, reviews, relatedBooks sang View
        return view('book-detail', compact('book', 'reviews', 'relatedBooks'));
    }

    // 3. TÌM KIẾM
    public function search(Request $request)
    {
        // 1. Lấy tham số
        $keyword = $request->input('keyword');
        $filterType = $request->input('filter_type', 'title');

        // Validation & Warning Logic
        if ($keyword !== null && $keyword !== '' && in_array($filterType, ['view_count', 'avg_rating', 'total_reviews']) && is_numeric($keyword)) {
            if ($keyword < 0) {
                return redirect()->route('books.search', ['filter_type' => $filterType])
                    ->with('error', 'Giá trị tìm kiếm không được là số âm!');
            }
            $specialNumbers = [13, 666, 0]; 
            if (in_array(intval($keyword), $specialNumbers)) {
                session()->flash('warning', "Bạn đang tìm kiếm con số đặc biệt ($keyword). Kết quả có thể rất ít hoặc không có!");
            }
        }

        // 2. Query
        $query = Book::query();

        // 3. Xử lý Lọc
        if ($keyword !== null && $keyword !== '') {
            switch ($filterType) {
                case 'view_count':
                    $query->where('view_count', '>=', intval($keyword))->orderBy('view_count', 'desc');
                    break;
                case 'avg_rating':
                    $query->where('avg_rating', '>=', floatval($keyword))->orderBy('avg_rating', 'desc');
                    break;
                case 'total_reviews':
                    $query->where('total_reviews', '>=', intval($keyword))->orderBy('total_reviews', 'desc');
                    break;
                case 'title':
                default:
                    $query->where(function($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%")
                          ->orWhere('author_name', 'like', "%{$keyword}%");
                    })->orderBy('view_count', 'desc');
                    break;
            }
        } else {
            $query->orderBy('view_count', 'desc');
        }

        // 4. Phân trang
        $books = $query->paginate(12)->withQueryString();

        return view('search-book', ['books' => $books]);
    }

    // 4. SÁCH MỚI CẬP NHẬT (LIST)
    public function list(Request $request)
    {
        $query = $this->getBookQuery();

        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }

        if ($request->has('rating')) {
            $rating = (int) $request->rating;
            $query->having('posts_avg_rating', '>=', $rating);
        }

        $sort = $request->get('sort', 'newest'); 

        switch ($sort) {
            case 'view_desc':
                $query->orderBy('view_count', 'desc');
                break;
            case 'rating_desc':
                $query->orderBy('posts_avg_rating', 'desc'); 
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc'); 
                break;
        }

        $books = $query->paginate(12)->withQueryString();

        $books->getCollection()->transform(function ($book) {
            $book->avg_rating = round($book->posts_avg_rating ?? 0, 1);
            return $book;
        });

        $categories = Category::all(); 

        return view('list', [
            'books' => $books,
            'categories' => $categories, 
            'pageTitle' => 'Tất Cả Sách'
        ]);
    }

    // 5. TRANG HIỂN THỊ ĐÁNH GIÁ SÁCH
    public function showReviews($slug)
{
    $book = $this->getBookQuery()
                ->where('slug', $slug)
                ->firstOrFail();
    
    $book->avg_rating = round($book->posts_avg_rating ?? 0, 1);

    // Lấy danh sách review có phân trang
    $reviews = $book->posts()
                    ->with(['user', 'likes', 'comments.user'])
                    ->where('status', 'published')
                    ->latest()
                    ->paginate(10);

    // Trả về view đúng tên (kiểm tra lại tên file trong resources/views của bạn)
    return view('review-detail', [ // <-- Đảm bảo tên này khớp với tên file .blade.php
        'book' => $book,
        'reviews' => $reviews,
        'pageTitle' => 'Đánh giá sách: ' . $book->title
    ]);
}
}