<?php

namespace App\Http\Controllers;

use App\Models\Book; // Nhớ dòng này để gọi Model Book
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Thay vì viết SQL dài dòng, ta dùng Eloquent:
        $books = Book::orderBy('id', 'desc')->get();

        // Gửi biến $books sang giao diện (View)
        return view('home', ['books' => $books]);
    }
    // --- THÊM ĐOẠN NÀY VÀO ---
    public function show($id)
    {
        // 1. Lấy sách từ Database theo ID
        $book = Book::find($id);

        // 2. Nếu không tìm thấy sách (ví dụ gõ ID linh tinh) -> Quay về trang chủ
        if (!$book) {
            return redirect('/')->with('error', 'Không tìm thấy cuốn sách này!');
        }

        // 3. Trả về giao diện chi tiết
        return view('book-detail', ['book' => $book]);
    }
    public function search(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ ô input
        $keyword = $request->input('keyword');

        // Nếu có từ khóa thì tìm theo tên, không thì lấy tất cả
        if ($keyword) {
            $books = Book::where('title', 'LIKE', "%{$keyword}%")->get();
        } else {
            // Mặc định lấy 12 cuốn mới nhất
            $books = Book::orderBy('id', 'desc')->limit(12)->get();
        }

        return view('search-book', ['books' => $books]);
    }
}