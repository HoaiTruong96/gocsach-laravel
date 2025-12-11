<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; 
use Illuminate\Support\Facades\Auth; 
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Notifications\NewLikeNotification;
use App\Notifications\NewCommentNotification;

class PostController extends Controller
{
   public function store(Request $request)
{
    // 1. Validate dữ liệu
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'rating'  => 'required|integer|min:1|max:5',
        'title'   => 'required|string|max:255', // Bắt buộc có tiêu đề
        'content' => 'required|min:10',
    ], [
        'book_id.exists' => 'Vui lòng chọn một cuốn sách hợp lệ từ danh sách gợi ý.',
        'title.required' => 'Bạn chưa nhập tiêu đề bài viết.',
        'content.min' => 'Nội dung review quá ngắn, hãy viết thêm chút nữa nhé!',
    ]);

    // 2. Tạo Slug duy nhất
    $slug = Str::slug($request->title) . '-' . time();

    // ... đoạn validate giữ nguyên ...

    // 3. Lưu vào Database
    Post::create([
        'user_id'      => Auth::id(),
        'book_id'      => $request->input('book_id'),
        'title'        => $request->input('title'),
        'slug'         => $slug,
        'rating'       => $request->input('rating'),
        'content'      => $request->input('content'),
        
        // [SỬA] Đổi 'published' thành 'pending'
        'status'       => 'pending', 
        
        'published_at' => now(), // Có thể để null hoặc now() tùy bạn
    ]);
    
    // 4. Quay về trang Profile
    // [SỬA] Đổi thông báo để người dùng không hoang mang
    return redirect()->route('profile', Auth::id())
                     ->with('success', 'Bài viết đã được gửi và đang chờ Admin phê duyệt!');
}
    public function toggleLike($id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!']);

        $post = Post::find($id);
        if (!$post) return response()->json(['error' => 'Bài viết không tồn tại!']);

        $like = Like::where('user_id', $user->id)->where('post_id', $id)->first();
        $action = '';

        if ($like) {
            $like->delete();
            $liked = false;
            $action = 'unliked';
        } else {
            Like::create(['user_id' => $user->id, 'post_id' => $id]);
            $liked = true;
            $action = 'liked';

            // Gửi thông báo (nếu có)
            if ($post->user_id != $user->id) {
                $post->user->notify(new NewLikeNotification($user, $post));
            }
        }

        // Đếm lại số like
        $count = Like::where('post_id', $id)->count();

        return response()->json([
            'success' => true, 
            'liked' => $liked, 
            'count' => $count,
            'action' => $action
        ]);
    }

    // 3. Xử lý Ajax Comment
    public function postComment(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!']);

        $request->validate(['content' => 'required']);

        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request->input('content')
        ]);

        // Gửi thông báo (nếu có)
        $post = Post::find($id);
        if ($post && $post->user_id != $user->id) {
           $post->user->notify(new NewCommentNotification($user, $post));
        }

        // Trả về số lượng comment mới
        $commentCount = Comment::where('post_id', $id)->count();

        return response()->json([
            'success' => true,
            'user_name' => $user->name,
            'avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random',
            'content' => $comment->content,
            'count' => $commentCount,
            'created_at' => 'Vừa xong'
        ]);
    }
}