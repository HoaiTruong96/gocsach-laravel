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
   public function store(Request $request)
{
    // 1. Validate dữ liệu (Bao gồm cả ảnh thumbnail)
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'rating'  => 'required|integer|min:1|max:5',
        'title'   => 'required|string|max:255',
        'content' => 'required|min:10',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh
    ], [
        'book_id.exists' => 'Vui lòng chọn một cuốn sách hợp lệ.',
        'title.required' => 'Bạn chưa nhập tiêu đề bài viết.',
        'content.min' => 'Nội dung review quá ngắn.',
        'thumbnail.image' => 'File tải lên phải là hình ảnh.',
        'thumbnail.max' => 'Ảnh không được lớn hơn 2MB.',
    ]);

    // 2. Xử lý Upload Ảnh (Nếu có)
    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
        // Lưu ảnh vào thư mục storage/app/public/posts
        $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
    }

    // 3. Tạo Slug
    $slug = \Illuminate\Support\Str::slug($request->title) . '-' . time();

    // 4. Lưu vào Database (Kết hợp cả Thumbnail và Pending)
    \App\Models\Post::create([
        'user_id'      => \Illuminate\Support\Facades\Auth::id(),
        'book_id'      => $request->book_id,
        'title'        => $request->title,
        'slug'         => $slug,
        'rating'       => $request->rating,
        'content'      => $request->content,
        
        'thumbnail'    => $thumbnailPath, // [QUAN TRỌNG 1] Lưu đường dẫn ảnh
        
        'status'       => 'pending',      // [QUAN TRỌNG 2] Đặt trạng thái chờ duyệt
        
        'published_at' => now(),          // Ngày gửi bài
    ]);
    
    // 5. Quay về Profile với thông báo chờ duyệt
    return redirect()->route('profile', \Illuminate\Support\Facades\Auth::id())
                     ->with('success', 'Bài viết đã được gửi và đang chờ Admin phê duyệt!');
}
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