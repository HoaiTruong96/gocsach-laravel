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
        // Trang chủ chỉ hiện những bài ĐÃ DUYỆT (is_approved = true)
        // Lấy 10 bài mới nhất để hiện
        $books = Book::where('is_approved', true)->with('category')->latest()->take(10)->get();

        // Trả về view TRANG CHỦ: resources/views/index.blade.php
        return view('index', compact('books'));
    }

    public function show($slug)
    {
        // Hiển thị chi tiết sách theo slug, kèm category và các bài viết liên quan
        $book = Book::where('slug', $slug)->with(['category', 'posts.user'])->firstOrFail();
        // Tăng view count
        $book->increment('view_count');

        // Trả về view chi tiết sách: resources/views/detail.blade.php
        return view('detail', compact('book'));
    }

    // =========================================================
    // 2. DÀNH CHO ADMIN (BACKEND)
    // =========================================================
    public function index()
    {
        // Lấy tất cả sách, phân trang 10 sách/trang, sắp xếp mới nhất
        $books = Book::with('category')->latest()->paginate(10);

        // Trả về view danh sách sách trong Admin: resources/views/admin/books/index.blade.php
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        // Lấy danh mục để chọn khi tạo sách
        $categories = Category::all();

        // Trả về view tạo sách: resources/views/admin/books/create.blade.php
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate form
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['created_by_user_id'] = Auth::id(); // Lưu người tạo (Admin)
        $data['is_approved'] = true; // Admin đăng thì auto duyệt

        // Xử lý upload ảnh
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Thêm sách thành công!');
    }

    public function edit(Book $book)
    {
        // Lấy danh mục để chọn khi chỉnh sửa sách
        $categories = Category::all();

        // Trả về view chỉnh sửa sách: resources/views/admin/books/edit.blade.php
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        // Validate form cập nhật
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['cover_image']); // Loại bỏ ảnh khỏi mảng data để xử lý riêng

        // Cập nhật slug nếu tiêu đề thay đổi
        if ($book->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        // Xử lý upload ảnh mới
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Cập nhật sách thành công!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Đã xóa sách!');
    }
}
