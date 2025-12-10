<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; 
use Illuminate\Support\Facades\Auth; 
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Str;

class PostController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|min:10',
            'book_id' => 'required|exists:books,id'
        ]);

        // Tạo tiêu đề tự động (Vì form không có ô nhập tiêu đề)
        $title = 'Review sách #' . $request->input('book_id') . ' bởi User ' . (Auth::id() ?? 52);
        
        // [QUAN TRỌNG] Tạo slug từ tiêu đề + thêm thời gian để tránh trùng lặp
        $slug = Str::slug($title) . '-' . time();

        // 2. Lưu vào Database
        Post::create([
            'user_id' => Auth::id() ?? 52, 
            'book_id' => $request->input('book_id'),
            
            // Thêm tiêu đề
            'title' => $title, 
            
            // [FIX LỖI] Thêm slug vào đây (Bắt buộc vì DB yêu cầu)
            'slug' => $slug,

            'rating' => $request->input('rating'),
            
            // Đổi 'content_text' thành 'content' để khớp với Model
            'content' => $request->input('content'), 
            
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
     public function toggleLike($id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!']);

        // Tìm like theo post_id
        $like = Like::where('user_id', $user->id)->where('post_id', $id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create(['user_id' => $user->id, 'post_id' => $id]);
            $liked = true;
        }

        // Đếm lại số like của post này
        $count = Like::where('post_id', $id)->count();

        return response()->json(['success' => true, 'liked' => $liked, 'count' => $count]);
    }

    // 3. Xử lý Ajax Comment
    public function postComment(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!']);

        $request->validate(['content' => 'required']);

        // Tạo comment cho post_id
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request->input('content')
        ]);

        return response()->json([
            'success' => true,
            'user_name' => $user->name,
            'avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name),
            'content' => $comment->content
        ]);
    }
}