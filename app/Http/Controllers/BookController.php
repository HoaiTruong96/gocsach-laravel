<?php

namespace App\Http\Controllers;

use App\Models\Book; // Nhớ dòng này để gọi Model Book
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Thêm thư viện xử lý ảnh
use Illuminate\Support\Str;

class BookController extends Controller
{
    // --- 1. DANH SÁCH & TÌM KIẾM (Đã nâng cấp từ hàm index cũ) ---
    public function index(Request $request)
    {
        // Khởi tạo query từ Model Book
        $query = Book::with(['category', 'author']);

        // Logic Tìm kiếm: Nếu có từ khóa 'keyword' gửi lên
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        // Logic Lọc: Nếu có chọn danh mục
        if ($request->filled('category_id') && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Lấy dữ liệu và phân trang (thay vì get() lấy hết)
        $books = $query->latest()->paginate(10)->appends($request->all());
        
        // Lấy thêm danh mục và tác giả để hiển thị vào ô lọc (Filter)
        $categories = Category::all();
        $authors = Author::all();

        // Trả về View Admin (Lưu ý: Bạn cần tạo file view này theo giao diện Admin)
        return view('admin.books.index', compact('books', 'categories', 'authors'));
    }

    // --- 2. XEM CHI TIẾT (Cho người dùng xem) ---
    public function show($slug)
    {
        // Tìm sách theo slug, nếu không thấy thì báo lỗi 404
        $book = Book::with(['category', 'author'])->where('slug', $slug)->firstOrFail();
        
        // Tăng lượt xem
        $book->increment('view_count');

        // Lấy sách liên quan (cùng danh mục)
        $relatedBooks = Book::where('category_id', $book->category_id)
                            ->where('id', '!=', $book->id)
                            ->take(4)->get();

        return view('detail', compact('book', 'relatedBooks'));
    }

    // --- 3. CÁC HÀM QUẢN TRỊ (ADMIN CRUD) ---

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.books.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'author_id' => 'required',
            'cover_image' => 'required|image|max:2048', // Bắt buộc ảnh, max 2MB
        ]);

        // Xử lý upload ảnh
        $path = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
        }

        // Lưu vào DB
        Book::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'author_id' => $request->author_id,
            'publisher' => $request->publisher,
            'published_year' => $request->published_year,
            'description' => $request->description,
            'cover_image' => $path,
            'view_count' => 0,
        ]);

        return redirect()->route('books.index')->with('success', 'Thêm sách thành công!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.books.edit', compact('book', 'categories', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        // Validate (Ảnh không bắt buộc khi sửa)
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'author_id' => 'required',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'category_id', 'author_id', 'publisher', 'published_year', 'description']);

        // Xử lý ảnh mới nếu có
        if ($request->hasFile('cover_image')) {
            // Xóa ảnh cũ
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        // Cập nhật slug nếu đổi tên
        if ($book->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        $book->update($data);
        return redirect()->route('books.index')->with('success', 'Cập nhật thành công!');
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