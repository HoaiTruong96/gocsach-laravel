<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\NewLikeNotification;
use App\Notifications\PostCommentedNotification;
use App\Notifications\CommentLikedNotification;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|min:10',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'thumbnail_url' => 'nullable|url|max:500',
        ], [
            'book_id.exists' => 'Vui lòng chọn một cuốn sách hợp lệ.',
            'title.required' => 'Bạn chưa nhập tiêu đề bài viết.',
            'content.min' => 'Nội dung review quá ngắn.',
            'thumbnail.image' => 'File tải lên phải là hình ảnh.',
            'thumbnail.max' => 'Ảnh không được lớn hơn 2MB.',
            'thumbnail_url.url' => 'Đường dẫn ảnh không hợp lệ.',
        ]);

        // 2. Xử lý upload thumbnail (ưu tiên file, sau đó là URL)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        } elseif ($request->filled('thumbnail_url')) {
            $thumbnailPath = $request->thumbnail_url;
        }

        // 3. Tạo Slug
        $slug = Str::slug($request->title) . '-' . time();

        // 4. Xác định trạng thái: Admin = tự động duyệt, User = chờ duyệt
        $isAdmin = Auth::user()->role === 'admin';
        $status = $isAdmin ? 'published' : 'pending';

        // 5. Lưu vào Database
        $post = Post::create([
            'user_id' => Auth::id(),
            'book_id' => $request->input('book_id'),
            'title' => $request->input('title'),
            'slug' => $slug,
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
            'thumbnail' => $thumbnailPath,
            'status' => $status,
        ]);

        // 6. Cập nhật tiến độ Thử Thách (Chỉ khi bài đã được duyệt - admin)
        if ($post->status == 'published') {
            Auth::user()->updateChallengeProgress();
        }

        // 7. Thông báo phù hợp với trạng thái
        $message = $isAdmin
            ? 'Bài viết đã được đăng thành công!'
            : 'Đã gửi bài viết! Vui lòng chờ Admin phê duyệt.';

        return redirect()->route('profile', Auth::id())
            ->with('success', $message);
    }

    // Toggle Like (Giữ nguyên)
    public function toggleLike($id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Bạn cần đăng nhập!'], 401);

        $post = Post::find($id);
        if (!$post)
            return response()->json(['error' => 'Bài viết không tồn tại!'], 404);

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
                $post->user->notify(new CommentLikedNotification($user, $post));
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

    // Post Comment (Giữ nguyên)
    public function postComment(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Bạn cần đăng nhập!'], 401);

        $request->validate(['content' => 'required']);

        $post = Post::find($id);
        if (!$post)
            return response()->json(['error' => 'Bài viết không tồn tại!'], 404);

        // Lưu comment
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request->input('content')
        ]);

        // Gửi thông báo (Trừ khi tự comment bài mình)
        if ($post->user_id != $user->id) {
            $post->user->notify(new PostCommentedNotification($user, $post));
        }

        // Đếm lại số comment
        $commentCount = Comment::where('post_id', $id)->count();

        return response()->json([
            'success' => true,
            'comment_id' => $comment->id,
            'user_name' => $user->name,
            'user_avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random',
            'content' => $comment->content,
            'count' => $commentCount,
            'created_at' => 'Vừa xong'
        ]);
    }
}