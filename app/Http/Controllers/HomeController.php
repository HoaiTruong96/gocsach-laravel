<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Like;        
use App\Models\CommentLike; 
use Illuminate\Support\Facades\Auth;
use App\Notifications\CommentLikedNotification;
use App\Notifications\CommentRepliedNotification;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. XỬ LÝ PHẦN REVIEW CỘNG ĐỒNG ---
        $sortReview = $request->get('sort_review', 'latest');
        
        // [ĐÃ SỬA]: Xóa bỏ where('is_active', true) để tránh lỗi SQL
        $commentQuery = Comment::with(['user', 'book', 'likes']);

        // Đếm số like để phục vụ sắp xếp
        $commentQuery->withCount('likes'); 

        if ($sortReview == 'popular') {
            $commentQuery->orderByDesc('likes_count');
        } else {
            $commentQuery->latest();
        }

        $latestComments = $commentQuery->paginate(5)->withQueryString();

        // [QUAN TRỌNG]: Nếu là Ajax (bấm phân trang/tab), chỉ trả về Partial View
        if ($request->ajax()) {
            // Đảm bảo bạn đã có file resources/views/partials/home_comments.blade.php
            return view('partials.home_comments', compact('latestComments'))->render();
        }

        // --- 2. CÁC PHẦN DỮ LIỆU KHÁC (Load khi vào trang chủ lần đầu) ---
        
        // Banner
        $heroSlides = Banner::where('is_active', true)->orderBy('order', 'asc')->latest()->get();
        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([(object)[
                'id' => null, 'title' => 'Cây Cam Ngọt Của Tôi', 'tag' => 'Sách Kinh Điển',
                'description' => '"Vị chua chát của cái nghèo hòa trộn..."',
                'image' => 'https://library.hust.edu.vn/sites/default/files/C%C3%A2y%20cam%20ng%E1%BB%8Dt%20c%E1%BB%A7a%20t%C3%B4i%20-%20%E1%BA%A2nh%20b%C3%ACa.jpg',
                'rating' => '4.9/5.0', 'link' => '#'
            ]]);
        }

        // Sách mới (Giả sử cột duyệt là is_approved, nếu không có thì xóa where đi)
        $bookQuery = Book::with('categories')
            ->withAvg(['posts' => function($q) { 
                // Kiểm tra nếu bảng posts có cột status
                // $q->where('status', 'published'); 
            }], 'rating')
            ->latest()
            ->take(10);
            
        // Nếu bảng books có cột is_approved
        // $bookQuery->where('is_approved', true);
        
        $books = $bookQuery->get();

        foreach($books as $book) {
            $book->avg_rating = round($book->posts_avg_rating ?? 0, 1);
        }

        // Tạp chí
        $featuredArticle = Article::with('user')->where('is_featured', true)->latest()->first();
        $sidebarArticles = Article::with('user')->where('is_featured', false)->latest()->take(2)->get();

        // Danh mục
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();

        return view('home', compact(
            'heroSlides', 'books', 'latestComments', 'categories', 
            'featuredArticle', 'sidebarArticles'
        ));
    }

    // --- LOGIC LIKE ---
    public function toggleLike(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

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
            $existingLike = Like::where('user_id', $userId)->where('post_id', $id)->first();
            if ($existingLike) {
                $existingLike->delete();
                $liked = false;
            } else {
                Like::create(['user_id' => $userId, 'post_id' => $id]);
                $liked = true;
            }
            $count = Like::where('post_id', $id)->count();
        } else {
            $existingLike = CommentLike::where('user_id', $userId)->where('comment_id', $id)->first();
            if ($existingLike) {
                $existingLike->delete();
                $liked = false;
            } else {
                CommentLike::create(['user_id' => $userId, 'comment_id' => $id, 'is_like' => 1]);
                $liked = true;

                // Gửi thông báo
                $comment = Comment::find($id);
                if ($comment && $comment->user_id != $userId) {
                    try {
                        $comment->user->notify(new CommentLikedNotification(Auth::user(), $comment));
                    } catch (\Exception $e) {}
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
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập'], 401);
        }

        $request->validate(['content' => 'required|max:500']);
        
        $parentComment = Comment::findOrFail($id);
        $user = Auth::user();
        
        $reply = new Comment();
        $reply->user_id = $user->id;
        $reply->post_id = $parentComment->post_id; 
        $reply->book_id = $parentComment->book_id;
        $reply->parent_id = $id;
        $reply->content = $request->input('content');
        // $reply->is_active = true; // Bỏ comment nếu cần set active
        $reply->save();

        if ($parentComment->user_id != $user->id) {
            try {
                $parentComment->user->notify(new CommentRepliedNotification($user, $reply));
            } catch (\Exception $e) {}
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

    public function readNotification($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            if (isset($notification->data['link'])) {
                return redirect($notification->data['link']);
            }
        }
        return redirect()->back();
    }
}