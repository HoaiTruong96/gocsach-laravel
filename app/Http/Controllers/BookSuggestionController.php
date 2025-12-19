<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookSuggestionController extends Controller
{
    /**
     * Show form to suggest a new book
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('suggest-book', compact('categories'));
    }

    /**
     * Store new book suggestion
     */
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'description' => 'nullable|string|max:2000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required' => 'Vui lòng nhập tên sách.',
            'author_name.required' => 'Vui lòng nhập tên tác giả.',
            'category_ids.*.exists' => 'Danh mục không hợp lệ.',
            'description.max' => 'Mô tả không được quá 2000 ký tự.',
            'cover_image.image' => 'File tải lên phải là hình ảnh.',
            'cover_image.max' => 'Ảnh bìa không được lớn hơn 2MB.',
        ]);

        // 2. Xử lý upload ảnh bìa
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('books/covers', 'public');
        }

        // 3. Create slug
        $slug = Str::slug($request->title) . '-' . Str::random(4);

        // 4. Create book with is_approved = false
        $book = Book::create([
            'title' => $request->title,
            'slug' => $slug,
            'author_name' => $request->author_name,
            'description' => $request->description,
            'cover_image' => $coverPath,
            'is_approved' => false,
            'created_by_user_id' => Auth::id(),
            'view_count' => 0,
        ]);

        // 5. Attach categories if selected
        if ($request->category_ids && count($request->category_ids) > 0) {
            $book->categories()->attach($request->category_ids);
        }

        // 6. Redirect back to profile with success message
        return redirect()->route('profile', Auth::id())
                        ->with('success', 'Đề xuất sách thành công! Vui lòng chờ Admin phê duyệt.');
    }
}
