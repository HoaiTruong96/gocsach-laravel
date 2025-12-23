<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    /**
     * Display a paginated list of authors (aggregated from books table)
     * Tách các tên tác giả phân cách bằng dấu phẩy thành các entry riêng
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $sort = $request->get('sort', 'popular');

        // Lấy tất cả author_name từ books (không bao gồm soft-deleted)
        $booksAuthors = DB::table('books')
            ->whereNotNull('author_name')
            ->where('author_name', '<>', '')
            ->where('is_approved', true)
            ->whereNull('deleted_at') // Loại bỏ soft-deleted
            ->select('author_name')
            ->get();

        // Tách các tên tác giả và đếm số sách
        $authorCounts = [];
        foreach ($booksAuthors as $book) {
            // Tách bằng dấu phẩy, dấu chấm phẩy, hoặc " và "
            $names = preg_split('/[,;]|\s+và\s+|\s+and\s+/iu', $book->author_name);
            foreach ($names as $name) {
                $name = trim($name);
                if (empty($name))
                    continue;

                if (!isset($authorCounts[$name])) {
                    $authorCounts[$name] = 0;
                }
                $authorCounts[$name]++;
            }
        }

        // Lọc theo từ khóa tìm kiếm
        if ($q) {
            $authorCounts = array_filter($authorCounts, function ($count, $name) use ($q) {
                return stripos($name, $q) !== false;
            }, ARRAY_FILTER_USE_BOTH);
        }

        // Lấy thông tin từ bảng authors
        $authorNames = array_keys($authorCounts);
        $authorsInfo = Author::whereIn('name', $authorNames)->get()->keyBy('name');

        // Tạo collection các tác giả
        $authorsData = collect($authorCounts)->map(function ($count, $name) use ($authorsInfo) {
            $info = $authorsInfo->get($name);
            return (object) [
                'name' => $name,
                'books_count' => $count,
                'photo' => $info->photo ?? null,
                'birth_year' => $info->birth_year ?? null,
                'death_year' => $info->death_year ?? null,
                'author_slug' => $info->slug ?? Str::slug($name),
                'bio' => $info->bio ?? null,
                'nationality' => $info->nationality ?? null,
            ];
        });

        // Sắp xếp
        if ($sort === 'name') {
            $authorsData = $authorsData->sortBy('name');
        } else {
            $authorsData = $authorsData->sortByDesc('books_count');
        }

        // Phân trang thủ công
        $page = $request->get('page', 1);
        $perPage = 24;
        $total = $authorsData->count();
        $authors = new \Illuminate\Pagination\LengthAwarePaginator(
            $authorsData->forPage($page, $perPage)->values(),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('authors.index', compact('authors', 'q', 'sort'));
    }

    /**
     * Hiển thị chi tiết tác giả (public)
     * Hỗ trợ tìm sách có tên tác giả nằm trong chuỗi phân cách bằng dấu phẩy
     */
    public function show($slug)
    {
        // Tìm trong bảng authors trước
        $author = Author::where('slug', $slug)->first();

        $authorName = $author ? $author->name : str_replace('-', ' ', $slug);

        // Tìm sách có chứa tên tác giả (hỗ trợ nhiều dạng phân cách)
        // Đồng thời bao gồm các sách đã được gắn qua bảng pivot `author_book`.
        $books = Book::where('is_approved', true)
            ->where(function ($query) use ($authorName, $author) {
                // Tìm bằng LIKE với % ở cả 2 đầu để bắt mọi trường hợp
                $query->where('author_name', $authorName) // Exact match
                    ->orWhere('author_name', 'like', '%' . $authorName . '%'); // Substring match
    
                // Nếu tác giả tồn tại trong bảng authors, thêm các sách được liên kết qua pivot
                if ($author && isset($author->id)) {
                    $query->orWhereHas('authors', function ($q) use ($author) {
                        $q->where('authors.id', $author->id);
                    });
                }
            })
            ->paginate(12);

        // Nếu không tìm thấy author trong bảng authors, tạo object giả
        if (!$author) {
            $author = (object) [
                'name' => $authorName,
                'slug' => $slug,
                'photo' => null,
                'bio' => null,
                'birth_year' => null,
                'death_year' => null,
                'nationality' => null,
            ];
        }

        return view('authors.show', compact('author', 'books'));
    }

    // ========== ADMIN ONLY ==========

    /**
     * Danh sách tác giả cho Admin quản lý
     * Kết hợp dữ liệu từ bảng authors và books.author_name
     */
    public function adminIndex(Request $request)
    {
        $tab = $request->get('tab', 'all');

        // Lấy tất cả tác giả từ bảng authors với số sách
        $authorsFromTable = Author::withCount([
            'books' => function ($q) {
                $q->where('is_approved', true);
            }
        ])->orderBy('name')->get();

        // Lấy tất cả author_name từ books mà CHƯA có trong bảng authors
        // Cần tách nhiều tên tác giả trong một trường (phân cách bằng dấu phẩy, chấm phẩy, "và", "and")
        $registeredNames = Author::pluck('name')->map(fn($n) => mb_strtolower(trim($n)))->toArray();

        $booksWithAuthors = DB::table('books')
            ->select('author_name')
            ->whereNotNull('author_name')
            ->where('author_name', '<>', '')
            ->get();

        // Tách từng tên tác giả và đếm số sách
        $unregisteredCounts = [];
        foreach ($booksWithAuthors as $book) {
            // Tách bằng dấu phẩy, chấm phẩy, " và ", " and "
            $names = preg_split('/[,;]|\s+và\s+|\s+and\s+/iu', $book->author_name);
            foreach ($names as $name) {
                $name = trim($name);
                if (empty($name))
                    continue;

                // Kiểm tra tên này đã đăng ký hay chưa
                if (!in_array(mb_strtolower($name), $registeredNames)) {
                    if (!isset($unregisteredCounts[$name])) {
                        $unregisteredCounts[$name] = 0;
                    }
                    $unregisteredCounts[$name]++;
                }
            }
        }

        // Chuyển thành collection
        $authorsFromBooks = collect($unregisteredCounts)->map(function ($count, $name) {
            return (object) [
                'id' => null,
                'name' => $name,
                'slug' => Str::slug($name),
                'photo' => null,
                'bio' => null,
                'birth_year' => null,
                'death_year' => null,
                'nationality' => null,
                'books_count' => $count,
                'is_from_books' => true, // Đánh dấu chưa có trong bảng authors
            ];
        })->sortBy('name')->values();

        // Đánh dấu các tác giả đã có trong bảng authors
        $authorsFromTable->each(function ($author) {
            $author->is_from_books = false;
        });

        // Kết hợp và phân loại theo tab
        if ($tab === 'registered') {
            // Chỉ hiển thị tác giả đã có trong bảng authors
            $allAuthors = $authorsFromTable;
        } elseif ($tab === 'unregistered') {
            // Chỉ hiển thị tác giả từ books chưa có trong authors
            $allAuthors = $authorsFromBooks;
        } else {
            // Hiển thị tất cả
            $allAuthors = $authorsFromTable->concat($authorsFromBooks)->sortBy('name');
        }

        // Lọc theo từ khóa tìm kiếm
        $q = $request->get('q');
        if ($q) {
            $q = mb_strtolower(trim($q));
            $allAuthors = $allAuthors->filter(function ($author) use ($q) {
                return str_contains(mb_strtolower($author->name), $q);
            });
        }

        // Phân trang thủ công
        $page = $request->get('page', 1);
        $perPage = 15;
        $total = $allAuthors->count();
        $authors = new \Illuminate\Pagination\LengthAwarePaginator(
            $allAuthors->forPage($page, $perPage)->values(),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Thống kê
        $stats = [
            'total' => $authorsFromTable->count() + $authorsFromBooks->count(),
            'registered' => $authorsFromTable->count(),
            'unregistered' => $authorsFromBooks->count(),
        ];

        // Nếu là AJAX request, chỉ trả về table partial
        if ($request->ajax()) {
            return view('admin.authors.table', compact('authors', 'tab'));
        }

        return view('admin.authors.index', compact('authors', 'tab', 'stats', 'q'));
    }

    /**
     * Form thêm tác giả mới (Admin only)
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Lưu tác giả mới (Admin only)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name',
            'photo' => 'nullable|string|max:500',
            'photo_file' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'cropped_photo' => 'nullable|string',
            'bio' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'death_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'nationality' => 'nullable|string|max:100',
        ]);

        // Handle cropped base64 image (priority)
        if (!empty($request->cropped_photo)) {
            $base64 = $request->cropped_photo;
            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
                $ext = $matches[1];
                $base64 = substr($base64, strpos($base64, ',') + 1);
                $image = base64_decode($base64);
                $filename = 'authors/' . uniqid() . '.' . $ext;
                \Storage::disk('public')->put($filename, $image);
                $validated['photo'] = $filename;
            }
        }
        // Handle file upload
        elseif ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('authors', 'public');
            $validated['photo'] = $path;
        }

        unset($validated['photo_file'], $validated['cropped_photo']);

        $validated['slug'] = Str::slug($validated['name']);

        Author::create($validated);

        return redirect()->route('admin.authors.index', ['tab' => 'registered'])
            ->with('success', 'Đã thêm tác giả thành công!');
    }

    /**
     * Form chỉnh sửa tác giả (Admin only)
     */
    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Cập nhật tác giả (Admin only)
     */
    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
            'photo' => 'nullable|string|max:500',
            'photo_file' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'cropped_photo' => 'nullable|string',
            'bio' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'death_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'nationality' => 'nullable|string|max:100',
        ]);

        // Delete old file helper
        $deleteOldPhoto = function () use ($author) {
            if ($author->photo && !str_starts_with($author->photo, 'http')) {
                \Storage::disk('public')->delete($author->photo);
            }
        };

        // Handle cropped base64 image (priority)
        if (!empty($request->cropped_photo)) {
            $base64 = $request->cropped_photo;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
                $deleteOldPhoto();
                $ext = $matches[1];
                $base64 = substr($base64, strpos($base64, ',') + 1);
                $image = base64_decode($base64);
                $filename = 'authors/' . uniqid() . '.' . $ext;
                \Storage::disk('public')->put($filename, $image);
                $validated['photo'] = $filename;
            }
        }
        // Handle file upload
        elseif ($request->hasFile('photo_file')) {
            $deleteOldPhoto();
            $path = $request->file('photo_file')->store('authors', 'public');
            $validated['photo'] = $path;
        }

        unset($validated['photo_file'], $validated['cropped_photo']);

        $validated['slug'] = Str::slug($validated['name']);

        $author->update($validated);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Đã cập nhật tác giả thành công!');
    }

    /**
     * Xóa tác giả (Admin only)
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', 'Đã xóa tác giả thành công!');
    }
}