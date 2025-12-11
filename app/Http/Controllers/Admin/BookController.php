<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Hiển thị danh sách quản lý (Table)
    public function index()
    {
        $books = Book::with('categories')->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    // Form thêm mới
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    // Xử lý lưu
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author_name' => 'required|max:255',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('category_ids', 'cover_image');
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['created_by_user_id'] = Auth::id();
        $data['is_approved'] = true;

        // Xử lý upload ảnh
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        // 1. Tạo sách
        $book = Book::create($data);

        // 2. Gắn thể loại (Quan hệ nhiều-nhiều)
        $book->categories()->attach($request->category_ids);

        // Ghi log
        AdminActivityLog::log(
            'create',
            "Thêm sách mới: {$book->title}",
            Book::class,
            $book->id,
            null,
            $book->toArray()
        );

        return redirect()->route('admin.books.index')->with('success', 'Thêm sách thành công!');
    }

    // Form chỉnh sửa
    public function edit(Book $book)
    {
        $categories = Category::all();
        $currentCategoryIds = $book->categories->pluck('id')->toArray();
        return view('admin.books.edit', compact('book', 'categories', 'currentCategoryIds'));
    }

    // Form cập nhật
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author_name' => 'required|max:255',
            'category_ids' => 'required|array',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        // Lưu giá trị cũ để log
        $oldValues = $book->toArray();

        $data = $request->except('category_ids', 'cover_image');

        // Cập nhật slug nếu tiêu đề đổi
        if ($book->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        // Xử lý ảnh mới
        if ($request->hasFile('cover_image')) {
            // Xóa ảnh cũ nếu có
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        // Update thông tin cơ bản và đồng bộ
        $book->update($data);
        $book->categories()->sync($request->category_ids);

        // Ghi log
        AdminActivityLog::log(
            'update',
            "Cập nhật sách: {$book->title}",
            Book::class,
            $book->id,
            $oldValues,
            $book->fresh()->toArray()
        );

        return redirect()->route('admin.books.index')->with('success', 'Cập nhật sách thành công!');
    }

    // Xóa
    public function destroy(Book $book)
    {
        $bookData = $book->toArray();
        $bookTitle = $book->title;

        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        // Ghi log
        AdminActivityLog::log(
            'delete',
            "Xóa sách: {$bookTitle}",
            Book::class,
            $bookData['id'],
            $bookData,
            null
        );

        return redirect()->route('admin.books.index')->with('success', 'Đã xóa sách thành công!');
    }
}
