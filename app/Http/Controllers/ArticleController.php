<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article; // Nhớ import Model Article

class ArticleController extends Controller
{
    /**
     * Hiển thị trang chi tiết bài viết
     */
    public function show($slug)
    {
        // 1. Tìm bài viết dựa trên slug
        // Sử dụng firstOrFail để nếu không thấy sẽ tự báo lỗi 404
        $article = Article::with('user') // Load kèm thông tin tác giả
                        ->where('slug', $slug)
                        ->firstOrFail();

        // 2. Trả về view chi tiết
        // Lưu ý: Tên view phải khớp với nơi bạn lưu file show.blade.php
        // Nếu bạn để file ở: resources/views/show.blade.php thì dùng: 'show'
        // Nếu bạn để ở: resources/views/articles/show.blade.php thì dùng: 'articles.show'
        
        return view('show', compact('article')); 
    }
}