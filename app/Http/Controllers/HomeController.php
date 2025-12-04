<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Đừng quên import Model Book

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với danh sách Review mới nhất
     */
    public function index()
    {
        // Lấy sách mới nhất (theo thời gian tạo), phân trang 10 cuốn mỗi trang
        // paginate(10) là hàm chìa khóa để hiển thị phân trang bên View
        $books = Book::latest()->paginate(10);

        // Trả về view 'home' và truyền biến $books sang
        return view('home', compact('books'));
    }
}