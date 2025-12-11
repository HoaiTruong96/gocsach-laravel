<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\NewLikeNotification;
use App\Notifications\NewCommentNotification;

class PostController extends Controller
{
    // 1. Xử lý Lưu bài viết (Review sách)
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|min:10',
        ], [
            'book_id.exists' => 'Vui lòng chọn một cuốn sách hợp lệ.',
            'content.min' => 'Nội dung review quá ngắn, hãy viết thêm chút nữa nhé!',
        ]);

        // Tạo tiêu đề tự động nếu người dùng không nhập (hoặc lấy từ input nếu có)
        // Vì trong form review bạn không có ô nhập title, ta tự sinh ra
        $title = 'Review sách #' . $request->input('book_id') . ' - ' . Auth::user()->name;
        $slug = Str::slug($title) . '-' . time();

        Post::create([
            'user_id'      => Auth::id(),
            'book_id'      => $request->input('book_id'),
            'title'        => $title,
            'slug'         => $slug,
            'rating'       => $request->input('rating'),
            'content'      => $request->input('content'),
            'status'       => 'published', // [QUAN TRỌNG] Để 'published' luôn để hiện ra ngay (hoặc 'pending' nếu muốn duyệt)
            'published_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

    // 2. Xử lý Ajax Like/Unlike
    public function toggleLike($id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!'], 401);

        $post = Post::find($id);
        if (!$post) return response()->json(['error' => 'Bài viết không tồn tại!'], 404);

        // Tìm like
        $like = Like::where('user_id', $user->id)->where('post_id', $id)->first();
        $liked = false;

        if ($like) {
            $like->delete(); // Unlike
            $liked = false;
        } else {
            Like::create(['user_id' => $user->id, 'post_id' => $id]); // Like
            $liked = true;

            // Gửi thông báo (Trừ khi tự like bài mình)
            if ($post->user_id != $user->id) {
                $post->user->notify(new NewLikeNotification($user, $post));
            }
        }

        // Đếm lại số like
        $count = Like::where('post_id', $id)->count();

        return response()->json([
            'success' => true, 
            'liked' => $liked, 
            'count' => $count
        ]);
    }

    // 3. Xử lý Ajax Comment
    public function postComment(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!'], 401);

        $request->validate(['content' => 'required']);

        $post = Post::find($id);
        if (!$post) return response()->json(['error' => 'Bài viết không tồn tại!'], 404);

        // Lưu comment
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request->input('content')
        ]);

        // Gửi thông báo (Trừ khi tự comment bài mình)
        if ($post->user_id != $user->id) {
           $post->user->notify(new NewCommentNotification($user, $post));
        }

        // Đếm lại số comment
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