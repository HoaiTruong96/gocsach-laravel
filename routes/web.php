<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookSuggestionController;

// ====================================================
// 1. NHÓM PUBLIC (Ai cũng xem được)
// ====================================================

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang tĩnh (Footer)
Route::view('/ve-chung-toi', 'pages.about')->name('page.about');
Route::view('/dieu-khoan-su-dung', 'pages.terms')->name('page.terms');
Route::view('/chinh-sach-bao-mat', 'pages.privacy')->name('page.privacy');
Route::view('/lien-he', 'pages.contact')->name('page.contact');
Route::post('/post/{post_id}/comment', [CommentController::class, 'store'])->middleware('auth');
// AJAX Live Search (cho Header)
Route::get('/ajax-search', function (Illuminate\Http\Request $request) {
    $keyword = $request->get('keyword');
    
    if (!$keyword || strlen($keyword) < 2) {
        return response()->json([]);
    }
    
    $books = App\Models\Book::where('is_approved', true)
        ->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('author_name', 'like', "%{$keyword}%");
        })
        ->select('id', 'title', 'slug', 'author_name', 'cover_image', 'avg_rating')
        ->orderBy('view_count', 'desc')
        ->limit(8)
        ->get();
    
    return response()->json($books);
})->name('ajax.search');

// Trang chi tiết bài viết Tạp chí
Route::get('/tap-chi/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Trang Danh sách sách
Route::get('/danh-sach', [BookController::class, 'list'])->name('books.list');

// Tìm kiếm Review/Sách
Route::get('/review-search', [BookController::class, 'search'])->name('books.search');

// Tác giả
Route::get('/tac-gia', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/tac-gia/{slug}', [AuthorController::class, 'show'])->name('authors.show');

// Xem chi tiết sách & Đánh giá
Route::get('/chi-tiet/{slug}', [BookController::class, 'show'])->name('detail');
Route::get('/chi-tiet/{slug}/danh-gia', [BookController::class, 'showReviews'])->name('book.reviews');
// Route dự phòng cho link cũ (nếu có)
Route::get('/book/{slug}', [BookController::class, 'show'])->name('book.show');

// API Public lấy danh sách Follow (Cho trang Profile)
Route::get('/api/user/{id}/followers', [FollowController::class, 'getFollowers']);
Route::get('/api/user/{id}/following', [FollowController::class, 'getFollowing']);

// Ranking
Route::get('/ranking/top-liked', [RankingController::class, 'topLikedPosts']);


// ====================================================
// 2. NHÓM KHÁCH (GUEST ONLY)
// ====================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/check-secret', [AuthController::class, 'checkSecret'])->name('check.secret');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');
});
// Route cho trang Thử Thách
// Code này chạy qua Controller để lấy dữ liệu rồi mới trả về View
Route::get('/thu-thach', [ChallengeController::class, 'index'])->name('challenges.index');


// ====================================================
// 3. NHÓM THÀNH VIÊN (AUTH REQUIRED)
// ====================================================
Route::middleware('auth')->group(function () {
    
    // --- AUTH ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password.post');

    // --- PROFILE & FOLLOW ---
    Route::get('/profile/{id?}', [ProfileController::class, 'index'])->name('profile');
    Route::post('/follow/toggle', [FollowController::class, 'toggleFollow'])->name('follow.toggle');

    // --- ĐỀ XUẤT SÁCH ---
    Route::get('/sach/de-xuat', [BookSuggestionController::class, 'create'])->name('books.suggest');
    Route::post('/sach/de-xuat', [BookSuggestionController::class, 'store'])->name('books.suggest.store');

    // --- LIKE & COMMENT (AJAX) ---
    // Route xử lý Like chung (cho cả Post và Comment)
    Route::post('/like', [HomeController::class, 'toggleLike'])->name('handle.like');
    
    // Route gửi Reply (Bình luận trả lời)
    Route::post('/comment/{id}/reply', [HomeController::class, 'storeReply'])->name('comment.reply');
    
    // Route comment bài viết (nếu dùng PostController riêng)
    Route::post('/posts/{id}/comment', [PostController::class, 'postComment'])->name('posts.comment');

    // --- THÔNG BÁO (NOTIFICATION) ---
    // Đánh dấu tất cả là đã đọc
    Route::get('/notifications/read-all', [HomeController::class, 'markAllAsRead'])->name('notification.readAll');
    
    // Đọc 1 thông báo cụ thể -> Chuyển hướng
    Route::get('/notifications/{id}', [HomeController::class, 'markAsRead'])->name('notification.read');

    // --- REVIEW / POST ---
    Route::get('/reviews/viet-bai', function () {
        $user = Auth::user();
        return view('create-review', compact('user'));
    })->name('reviews.create');

    // Lưu bài viết mới
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');

    // --- API NỘI BỘ (Cho JS tìm sách khi viết review) ---
    Route::get('/api/books/search', function (Illuminate\Http\Request $request) {
        $query = $request->get('q');
        $books = Illuminate\Support\Facades\DB::table('books')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('author_name', 'like', "%{$query}%")
            ->select('id', 'title', 'author_name', 'published_year', 'cover_image', 'slug')
            ->limit(10)
            ->get();
        return response()->json($books);
    });
    // chalenges
    Route::post('/challenge/join/{id}', [ChallengeController::class, 'join'])->name('challenge.join');
});


// ====================================================
// 4. NHÓM ADMIN (AUTH + ADMIN REQUIRED)
// ====================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/reviews', [AdminController::class, 'dashboardReviews'])->name('dashboard.reviews');
    Route::get('/dashboard/users', [AdminController::class, 'dashboardUsers'])->name('dashboard.users');
    Route::get('/dashboard/export-excel', [AdminController::class, 'exportExcel'])->name('dashboard.export');

    // Resource Controllers
    Route::resource('books', AdminBookController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class)->only(['index', 'update', 'destroy']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('badges', \App\Http\Controllers\Admin\BadgeController::class);
    Route::resource('challenges', \App\Http\Controllers\Admin\ChallengeController::class);
    // Authors - dùng adminIndex() thay vì index() cho trang admin
    Route::get('authors', [AuthorController::class, 'adminIndex'])->name('authors.index');
    Route::get('authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::put('authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::resource('quotes', \App\Http\Controllers\Admin\QuoteController::class);

    // Activity Logs
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/trash', [\App\Http\Controllers\Admin\ActivityLogController::class, 'trash'])->name('activity-logs.trash');
    Route::get('/activity-logs/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::post('/activity-logs/cleanup', [\App\Http\Controllers\Admin\ActivityLogController::class, 'cleanup'])->name('activity-logs.cleanup');
    Route::post('/activity-logs/{activityLog}/restore', [\App\Http\Controllers\Admin\ActivityLogController::class, 'restore'])->name('activity-logs.restore');
    Route::post('/activity-logs/restore-trashed', [\App\Http\Controllers\Admin\ActivityLogController::class, 'restoreTrashed'])->name('activity-logs.restore-trashed');
    Route::delete('/activity-logs/force-delete', [\App\Http\Controllers\Admin\ActivityLogController::class, 'forceDelete'])->name('activity-logs.force-delete');

    // Game / Gamification
    Route::get('/game', [\App\Http\Controllers\Admin\GameController::class, 'index'])->name('game.index');
    Route::post('/challenges/{challenge}/award-badge/{userId}', [\App\Http\Controllers\Admin\ChallengeController::class, 'awardBadge'])->name('challenges.award-badge');
});
