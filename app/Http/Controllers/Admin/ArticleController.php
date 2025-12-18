<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Hiển thị danh sách (nếu cần sau này)
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        // Tăng view (nếu bảng articles có cột view_count)
        // $article->increment('view_count'); 
        
        return view('articles.show', compact('article'));
    }

    // Hiển thị form tạo bài viết mới
    public function create()
    {
        return view('admin.articles.create');
    }

    // Xử lý lưu bài viết mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'tag' => 'nullable|max:50',
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_url' => 'nullable|url|max:500',
        ]);

        $data = $request->except(['thumbnail', 'thumbnail_url']);
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['is_featured'] = $request->has('is_featured');
        $data['user_id'] = auth()->id();
        $data['view_count'] = 0;

        // Xử lý upload ảnh hoặc URL
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles', 'public');
            $data['thumbnail'] = $path;
        } elseif ($request->filled('thumbnail_url')) {
            $data['thumbnail'] = $request->thumbnail_url;
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Tạo bài viết thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    // Xử lý cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'tag' => 'nullable|max:50',
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['thumbnail']);
        $data['is_featured'] = $request->has('is_featured'); // Checkbox trả về "on" hoặc null

        // Xử lý upload ảnh mới
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu không phải link online
            if ($article->thumbnail && !Str::startsWith($article->thumbnail, 'http')) {
                Storage::delete('public/' . $article->thumbnail);
            }
            
            // Lưu ảnh mới
            $path = $request->file('thumbnail')->store('articles', 'public');
            $data['thumbnail'] = $path;
        }

        $article->update($data);

        return redirect()->route('home')->with('success', 'Cập nhật bài viết thành công!');
    }
}