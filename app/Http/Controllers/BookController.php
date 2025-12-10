<?php

namespace App\Http\Controllers;

use App\Models\Book; // Nhớ dòng này để gọi Model Book
use Illuminate\Http\Request;

class BookController extends Controller
{
    // =========================================================
    // 1. DÀNH CHO NGƯỜI DÙNG (FRONTEND)
    // =========================================================
    public function home()
    {
        $books = Book::with('categories')
            ->where('is_approved', true)
            ->latest()
            ->paginate(12);

<<<<<<< Updated upstream
        return view('home', compact('books'));
    }

    public function show($slug)
=======
        // B. Xử lý Lọc Review Cộng Đồng
        $filter = $request->get('filter', 'latest'); // Mặc định là mới nhất

        // Khởi tạo query: Lấy Post kèm User + Sách + Đếm Like/Comment
        $query = Post::with(['user', 'book'])
            ->withCount(['likes', 'comments']);

        // Logic sắp xếp
        switch ($filter) {
            case 'viewed':
                // Sắp xếp theo lượt xem
                // (Nếu bảng posts chưa có view_count thì tạm dùng comments_count)
                $query->orderBy('view_count', 'desc');
                break;
            case 'liked':
                // Sắp xếp theo lượng tim
                $query->orderBy('likes_count', 'desc');
                break;
            default: // 'latest'
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Lấy 6 bài review
        $latestReviews = $query->take(6)->get();

        // [QUAN TRỌNG] Đã xóa dòng dd($latestReviews); ở đây để web chạy bình thường

        return view('home', [
            'books' => $books,
            'latestReviews' => $latestReviews,
            'currentFilter' => $filter
        ]);
    }

    public function show($slug)
    {
        // Lấy sách theo slug + load quan hệ
        $book = Book::where('slug', $slug)
            ->with(['posts.user', 'posts.likes', 'posts.comments.user'])
            ->first();

        // Nếu không tìm thấy sách
        if (!$book) {
            return redirect('/')->with('error', 'Không tìm thấy sách!');
        }

        // Tăng lượt xem cho tất cả bài review của sách
        Post::where('book_id', $book->id)->increment('view_count');

        return view('book-detail', ['book' => $book]);
    }


    // 3. TRANG TÌM KIẾM
    public function search(Request $request)
>>>>>>> Stashed changes
    {
        $book = Book::where('slug', $slug)
            ->where('is_approved', true)
            ->with(['categories', 'posts.user']) // Eager load để tối ưu
            ->firstOrFail();

        // Tăng view (có thể thêm logic check session để tránh spam F5)
        $book->increment('view_count');

        return view('detail', compact('book'));
    }
}
