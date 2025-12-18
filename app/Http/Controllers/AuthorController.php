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
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $sort = $request->get('sort', 'popular');

        $query = DB::table('books as b')
            ->leftJoin('authors as a', 'b.author_name', '=', 'a.name')
            ->selectRaw('b.author_name as name, COUNT(*) as books_count, MAX(a.photo) as photo, MAX(a.birth_year) as birth_year, MAX(a.death_year) as death_year, MAX(a.slug) as author_slug, MAX(a.bio) as bio, MAX(a.nationality) as nationality')
            ->whereNotNull('b.author_name')
            ->where('b.author_name', '<>', '');

        if ($q) {
            $query->where('author_name', 'like', "%{$q}%");
        }

        $query->groupBy('author_name');

        if ($sort === 'name') {
            $query->orderBy('author_name', 'asc');
        } else {
            $query->orderByDesc('books_count');
        }

        $authors = $query->paginate(24)->withQueryString();

        // Convert stdClass results to objects with properties for blade convenience
        $authors->getCollection()->transform(function($a) {
            return (object) [
                'name' => $a->name,
                'books_count' => $a->books_count,
                'photo' => $a->photo,
                'birth_year' => $a->birth_year,
                'death_year' => $a->death_year,
                'author_slug' => $a->author_slug,
                'bio' => $a->bio,
                'nationality' => $a->nationality,
            ];
        });

        return view('authors.index', compact('authors', 'q', 'sort'));
    }

    /**
     * Hiển thị chi tiết tác giả (public)
     */
    public function show($slug)
    {
        // Tìm trong bảng authors trước
        $author = Author::where('slug', $slug)->first();

        if ($author) {
            $books = Book::where('author_name', $author->name)->paginate(12);
        } else {
            // Nếu không tìm thấy trong authors, tìm theo tên trong books
            $authorName = str_replace('-', ' ', $slug);
            $books = Book::where('author_name', 'like', "%{$authorName}%")->paginate(12);
            
            // Tạo object giả để hiển thị
            $author = (object) [
                'name' => $books->first()->author_name ?? $authorName,
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
        $authorsFromTable = Author::withCount(['books' => function($q) {
            $q->where('is_approved', true);
        }])->orderBy('name')->get();
        
        // Lấy tất cả author_name từ books mà CHƯA có trong bảng authors
        $authorsFromBooks = DB::table('books')
            ->select('author_name', DB::raw('COUNT(*) as books_count'))
            ->whereNotNull('author_name')
            ->where('author_name', '<>', '')
            ->whereNotIn('author_name', Author::pluck('name'))
            ->groupBy('author_name')
            ->orderBy('author_name')
            ->get()
            ->map(function($item) {
                return (object) [
                    'id' => null,
                    'name' => $item->author_name,
                    'slug' => Str::slug($item->author_name),
                    'photo' => null,
                    'bio' => null,
                    'birth_year' => null,
                    'death_year' => null,
                    'nationality' => null,
                    'books_count' => $item->books_count,
                    'is_from_books' => true, // Đánh dấu chưa có trong bảng authors
                ];
            });
        
        // Đánh dấu các tác giả đã có trong bảng authors
        $authorsFromTable->each(function($author) {
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
        
        // Phân trang thủ công
        $page = $request->get('page', 1);
        $perPage = 20;
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

        return view('admin.authors.index', compact('authors', 'tab', 'stats'));
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
            'photo' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'death_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'nationality' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Author::create($validated);

        return redirect()->route('admin.authors.index')
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
            'photo' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'death_year' => 'nullable|integer|min:0|max:' . date('Y'),
            'nationality' => 'nullable|string|max:100',
        ]);

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