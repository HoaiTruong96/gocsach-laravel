<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Like;         // Model cho Post Like
use App\Models\CommentLike;  // Model cho Comment Like
use Illuminate\Support\Facades\Auth;
use App\Notifications\CommentLikedNotification;
use App\Notifications\CommentRepliedNotification;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Banner Slider
        $heroSlides = Banner::where('is_active', true)
                            ->orderBy('order', 'asc')
                            ->latest()
                            ->get();

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([
                (object)[
                    'id' => null,
                    'title' => 'Cây Cam Ngọt Của Tôi',
                    'tag' => 'Sách Kinh Điển',
                    'description' => '"Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào của trí tưởng tượng..."',
                    'image' => 'https://library.hust.edu.vn/sites/default/files/C%C3%A2y%20cam%20ng%E1%BB%8Dt%20c%E1%BB%A7a%20t%C3%B4i%20-%20%E1%BA%A2nh%20b%C3%ACa.jpg',
                    'rating' => '4.9/5.0',
                    'link' => '#'
                ]
            ]);
        }

        // 2. Sách mới
        $books = Book::where('is_approved', true)
                    ->with('categories')
                    ->withAvg(['posts' => function($q) {
                        $q->where('status', 'published'); // Chỉ tính bài đã duyệt
                    }], 'rating')
                    ->latest()
                    ->take(10) // Lấy 10 cuốn (dùng chung cho cả Slider và Top thịnh hành)
                    ->get();

        // [QUAN TRỌNG] Ghi đè giá trị hiển thị bằng giá trị tính toán
        foreach($books as $book) {
            // Lấy điểm posts_avg_rating vừa tính, làm tròn 1 số lẻ
            $book->avg_rating = round($book->posts_avg_rating ?? 0, 1);
        }
        // 3. Tạp chí đọc
        $featuredArticle = Article::with('user')
                            ->where('is_featured', true)
                            ->latest()
                            ->first();

        $sidebarArticles = Article::with('user')
                            ->where('is_featured', false)
                            ->latest()
                            ->take(2)
                            ->get();

        // 4. Review Cộng Đồng
        $sortReview = $request->get('sort_review', 'latest');
        $commentQuery = Comment::with(['user', 'book']);

        // Đếm like của comment
        $commentQuery->withCount('likes'); 

        if ($sortReview == 'popular') {
            $commentQuery->orderByDesc('likes_count');
        } else {
            $commentQuery->latest();
        }

        $latestComments = $commentQuery->paginate(5)
                                     ->withQueryString()
                                     ->fragment('community-posts');

        // 5. Danh mục
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();

        return view('home', compact(
            'heroSlides',
            'books', 
            'latestComments', 
            'categories', 
            'featuredArticle', 
            'sidebarArticles'
        ));
    }

    // --- LOGIC XỬ LÝ LIKE ---
    public function toggleLike(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:post,comment', 
        ]);

        $userId = Auth::id();
        $id = $request->id;
        $type = $request->type;
        $liked = false;
        $count = 0;

        if ($type === 'post') {
            // --- LIKE BÀI VIẾT (POST) ---
            $existingLike = Like::where('user_id', $userId)->where('post_id', $id)->first();

            if ($existingLike) {
                $existingLike->delete(); // Unlike
                $liked = false;
            } else {
                Like::create([
                    'user_id' => $userId, 
                    'post_id' => $id
                ]); 
                $liked = true;
            }
            
            $count = Like::where('post_id', $id)->count();

        } else {
            // --- LIKE BÌNH LUẬN (COMMENT) ---
            $existingLike = CommentLike::where('user_id', $userId)->where('comment_id', $id)->first();

            if ($existingLike) {
                $existingLike->delete(); // Unlike
                $liked = false;
            } else {
                CommentLike::create([
                    'user_id' => $userId, 
                    'comment_id' => $id,
                    'is_like' => 1 
                ]); 
                $liked = true;

                // --- GỬI THÔNG BÁO ---
                $comment = Comment::find($id);
                
                // Kiểm tra: Chỉ gửi nếu comment tồn tại VÀ người like KHÔNG PHẢI người viết
                if ($comment && $comment->user_id != $userId) {
                    try {
                        $comment->user->notify(new CommentLikedNotification(Auth::user(), $comment));
                    } catch (\Exception $e) {
                        // Bỏ qua lỗi nếu gửi thông báo thất bại
                    }
                }
            }

            $count = CommentLike::where('comment_id', $id)->count();
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $count,
            'type' => $type
        ]);
    }

    // --- LOGIC REPLY ---
    public function storeReply(Request $request, $id)
    {
        $request->validate(['content' => 'required|max:500']);
        
        $parentComment = Comment::findOrFail($id);
        $user = Auth::user();
        
        $reply = new Comment();
        $reply->user_id = $user->id;
        $reply->post_id = $parentComment->post_id; 
        $reply->parent_id = $id;
        $reply->content = $request->input('content');
        $reply->save();

        // --- GỬI THÔNG BÁO ---
        // Chỉ gửi thông báo nếu người trả lời KHÔNG PHẢI người viết comment gốc
        if ($parentComment->user_id != $user->id) {
            try {
                $parentComment->user->notify(new CommentRepliedNotification($user, $reply));
            } catch (\Exception $e) {
                // Bỏ qua lỗi
            }
        }

        return response()->json([
            'success' => true,
            'user_name' => $user->name,
            'user_avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random',
            'content' => $reply->content,
            'time' => 'Vừa xong'
        ]);
    }

    // --- XỬ LÝ THÔNG BÁO ---
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $link = $notification->data['link'] ?? route('home');
        return redirect($link);
    }
    public function readNotification($id)
    {
        // Tìm thông báo trong danh sách của user hiện tại
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead(); // Đánh dấu đã đọc
            
            // Nếu thông báo có link (đã set ở Bước 1), chuyển hướng tới đó
            if (isset($notification->data['link'])) {
                return redirect($notification->data['link']);
            }
        }

        return redirect()->back();
    }
}