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
