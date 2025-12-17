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
use App\Notifications\CommentLikedNotification;

class PostController extends Controller
{
    // 1. Tạo bài viết mới
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating'  => 'required|integer|min:1|max:5',
            'title'   => 'required|string|max:255',
            'content' => 'required|min:10',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'book_id.exists' => 'Vui lòng chọn một cuốn sách hợp lệ.',
            'title.required' => 'Bạn chưa nhập tiêu đề bài viết.',
            'content.min' => 'Nội dung review quá ngắn.',
            'thumbnail.image' => 'File tải lên phải là hình ảnh.',
            'thumbnail.max' => 'Ảnh không được lớn hơn 2MB.',
        ]); // [ĐÃ SỬA] Thêm dấu đóng ngoặc bị thiếu

        // [ĐÃ SỬA] Xử lý Upload Ảnh (Code cũ bị thiếu đoạn này)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
        }

        // Tạo Slug
        $slug = Str::slug($request->title) . '-' . time();

        // [ĐÃ SỬA] Gán vào biến $post để dùng ở dưới
        $post = Post::create([
            'user_id'      => Auth::id(),
            'book_id'      => $request->input('book_id'),
            'title'        => $request->input('title'),
            'slug'         => $slug,
            'rating'       => $request->input('rating'),
            'content'      => $request->input('content'),
            'thumbnail'    => $thumbnailPath,
            'status'       => 'pending', // Mặc định chờ duyệt
            'published_at' => null,
        ]);
        
        // Cập nhật tiến độ (Chỉ chạy nếu status là published - logic admin duyệt sau này)
        if ($post->status == 'published') {
            Auth::user()->updateChallengeProgress();
        }
        
        return redirect()->route('detail', $post->book->slug)
                        ->with('success', 'Đã gửi bài viết! Vui lòng chờ Admin phê duyệt.');
   }

    // 2. Xử lý Like (Dùng AJAX)
    public function toggleLike($id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Unauthenticated'], 401);

        $post = Post::find($id);
        if (!$post) return response()->json(['error' => 'Bài viết không tồn tại!'], 404);

        $like = Like::where('user_id', $user->id)->where('post_id', $id)->first();
        $liked = false;

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create(['user_id' => $user->id, 'post_id' => $id]);
            $liked = true;

            if ($post->user_id != $user->id) {
                $post->user->notify(new CommentLikedNotification($user, $post));
            }
        }

        $count = Like::where('post_id', $id)->count();

        return response()->json([
            'success' => true, 
            'liked' => $liked, 
            'count' => $count
        ]);
    }

    // 3. Xử lý Bình luận (Form Submit)
    public function postComment(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $request->validate(['content' => 'required|max:500']);

        $post = Post::find($id);
        if (!$post) return redirect()->back()->with('error', 'Bài viết không tồn tại!');

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request->input('content')
        ]);

        if ($post->user_id != $user->id) {
           $post->user->notify(new NewCommentNotification($user, $post));
        }

        // [QUAN TRỌNG] Redirect back để hiển thị lại trang
        return redirect()->back()->with('success', 'Đã đăng bình luận thành công!');
    }
}