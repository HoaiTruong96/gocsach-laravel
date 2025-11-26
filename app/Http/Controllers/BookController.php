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
}