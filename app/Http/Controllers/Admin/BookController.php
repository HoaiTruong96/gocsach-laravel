<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Hiển thị danh sách quản lý (Có Tìm kiếm & Lọc)
    public function index(Request $request)
    {
        // Khởi tạo query từ Model Book
        $query = Book::with('categories');

        // 1. Tìm kiếm theo Từ khóa (Tên sách HOẶC Tên tác giả)
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('author_name', 'LIKE', "%{$keyword}%");
            });
        }

        // 2. Lọc theo Thể loại (Category)
        // Nếu chọn "Tất cả" (value="all") thì bỏ qua bước này
        if ($request->has('category_id') && $request->category_id != 'all') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Lấy dữ liệu, sắp xếp mới nhất và phân trang
        // withQueryString() giúp giữ lại các tham số tìm kiếm khi chuyển trang (VD: trang 2 vẫn đang tìm kiếm "Harry Potter")
        $books = $query->latest()->paginate(10)->withQueryString();

        // Lấy tất cả danh mục để hiển thị trong dropdown bộ lọc
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
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

        // Xử lý ảnh bìa
        if ($request->hasFile('cover_image')) {
            // Ưu tiên file upload
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        } elseif ($request->filled('cover_image_url')) {
            // Nếu không có file, sử dụng URL
            $data['cover_image'] = $request->cover_image_url;
        }

        // 1. Tạo sách
        $book = Book::create($data);

        // 2. Gắn thể loại (Quan hệ nhiều-nhiều)
        $book->categories()->attach($request->category_ids);

        // 3. Xử lý tác giả: cho phép nhập nhiều tên (phân cách bằng dấu phẩy)
        $authorInput = $request->input('author_name', '');
        $names = array_filter(array_map('trim', preg_split('/[\r\n,;]+/', $authorInput)));
        $authorIds = [];
        foreach ($names as $name) {
            if (empty($name)) continue;
            $slug = Author::generateSlug($name);
            $author = Author::firstOrCreate(['name' => $name], ['slug' => $slug]);
            $authorIds[] = $author->id;
        }
        if (!empty($authorIds)) {
            $book->authors()->sync($authorIds);
            // Đồng bộ field author_name (giữ tương thích với chỗ khác)
            $book->author_name = implode(', ', $names);
            $book->save();
        }

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

        // Xử lý ảnh bìa
        if ($request->hasFile('cover_image')) {
            // Xóa ảnh cũ nếu có (chỉ xóa file local, không xóa URL)
            if ($book->cover_image && !str_starts_with($book->cover_image, 'http') && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        } elseif ($request->filled('cover_image_url')) {
            // Nếu không có file mới, sử dụng URL
            // Xóa ảnh cũ nếu có (chỉ xóa file local)
            if ($book->cover_image && !str_starts_with($book->cover_image, 'http') && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->cover_image_url;
        }

        // Update thông tin cơ bản và đồng bộ
        $book->update($data);
        $book->categories()->sync($request->category_ids);

        // Xử lý tác giả (tương tự store)
        $authorInput = $request->input('author_name', '');
        $names = array_filter(array_map('trim', preg_split('/[\r\n,;]+/', $authorInput)));
        $authorIds = [];
        foreach ($names as $name) {
            if (empty($name)) continue;
            $slug = Author::generateSlug($name);
            $author = Author::firstOrCreate(['name' => $name], ['slug' => $slug]);
            $authorIds[] = $author->id;
        }
        if (!empty($authorIds)) {
            $book->authors()->sync($authorIds);
            $book->author_name = implode(', ', $names);
            $book->save();
        }

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

    /**
     * Duyệt sách do người dùng đề xuất
     */
    public function approve(Book $book)
    {
        $oldValues = $book->toArray();
        
        $book->is_approved = true;
        $book->save();

        // Ghi log
        AdminActivityLog::log(
            'approve',
            "Duyệt sách: {$book->title}",
            Book::class,
            $book->id,
            $oldValues,
            $book->fresh()->toArray()
        );

        return redirect()->route('admin.books.index')->with('success', "Đã duyệt sách \"{$book->title}\" thành công!");
    }
}
