<?php

namespace App\Http\Controllers;

use App\Models\Book;                    // Nhớ dòng này để gọi Model Book
use App\Models\Category;
use Illuminate\Support\Facades\Storage; // Sử dụng để xóa ảnh
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('index', compact('books'));
    }

    public function show($slug)
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
