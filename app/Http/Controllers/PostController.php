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
   public function store(Request $request)
   {
        // 1. Validate dữ liệu
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
        ]);

        // 2. Xử lý Upload Ảnh
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
        }

        // 3. Tạo Slug
        $slug = Str::slug($request->title) . '-' . time();

        // 4. Lưu vào Database
        $post = Post::create([
            'user_id'      => Auth::id(),
            'book_id'      => $request->input('book_id'),
            'title'        => $request->input('title'),
            'slug'         => $slug,
            'rating'       => $request->input('rating'),
            'content'      => $request->input('content'),
            'thumbnail'    => $thumbnailPath,
            
            // [ĐÃ SỬA] Đặt trạng thái là 'pending' để chờ Admin duyệt
            'status'       => 'pending', 
            
            // [ĐÃ SỬA] Chưa duyệt thì chưa có ngày đăng
            'published_at' => null,
        ]);
        
        // 5. Cập nhật tiến độ Thử Thách
        // Lưu ý: Vì status là 'pending' nên đoạn này tạm thời sẽ KHÔNG chạy ngay.
        // Logic cộng điểm nên được đặt ở Controller của Admin khi bấm nút "Duyệt bài".
        if ($post->status == 'published') {
            Auth::user()->updateChallengeProgress();
        }
        
        return redirect()->route('profile', Auth::id())
                        ->with('success', 'Đã gửi bài viết! Vui lòng chờ Admin phê duyệt.');
   }

    // Toggle Like (Giữ nguyên)
    public function toggleLike($id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!'], 401);

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

    // Post Comment (Giữ nguyên)
    public function postComment(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Bạn cần đăng nhập!'], 401);

        $request->validate(['content' => 'required']);

        $post = Post::find($id);
        if (!$post) return response()->json(['error' => 'Bài viết không tồn tại!'], 404);

        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request->input('content')
        ]);

        if ($post->user_id != $user->id) {
           $post->user->notify(new NewCommentNotification($user, $post));
        }

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