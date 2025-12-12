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
// ====================================================
// 1. NHÓM PUBLIC (Ai cũng xem được)
// ====================================================

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===> [MỚI THÊM] Trang Danh sách sách (Frontend tĩnh) <===
// Truy cập bằng đường dẫn: http://127.0.0.1:8000/danh-sach

Route::get('/danh-sach', function () {
    // Lấy tất cả sách, phân trang 12 cuốn
    $books = Book::with('categories')->latest()->paginate(12);

    // Trả về view 'list'
    return view('list', compact('books'));
})->name('list'); // Tên route là 'list' để khớp với menu
// --- ƯU TIÊN 1: Các route cụ thể, dài hơn ---
// Xem danh sách đánh giá của sách
Route::get('/chi-tiet/{slug}/danh-gia', [BookController::class, 'showReviews'])->name('book.reviews');

// Xem chi tiết sách
Route::get('/chi-tiet/{slug}', [BookController::class, 'show'])->name('detail');
// Alias cho route chi tiết sách (giữ lại để tránh lỗi nếu view cũ còn dùng)
Route::get('/book/{slug}', [BookController::class, 'show'])->name('book.show');

// Route tìm kiếm riêng cho việc viết review (nếu còn dùng)
Route::get('/review-search', [BookController::class, 'search'])->name('books.search');

// Route sách mới
Route::get('/sach-moi', [BookController::class, 'newBooks'])->name('books.new');

// code test
Route::middleware(['auth'])->group(function () {

    // Route hiển thị form (Bạn đã có)
    Route::get('/reviews/viet-bai', function () {
        $user = Auth::user();
        if (!$user)
            return redirect()->route('login');
        return view('create-review', compact('user'));
    })->name('reviews.create');

    // Route API tìm sách (Bạn đã có)
    Route::get('/api/books/search', function (Illuminate\Http\Request $request) {
        $query = $request->get('q');
        $books = Illuminate\Support\Facades\DB::table('books')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('author_name', 'like', "%{$query}%")
            ->select('id', 'title', 'author_name', 'published_year', 'cover_image')
            ->limit(10)
            ->get();
        return response()->json($books);
    });

    // ▼▼▼ 2. THÊM DÒNG QUAN TRỌNG NÀY ĐỂ SỬA LỖI ROUTE NOT DEFINED ▼▼▼
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
});

// Các trang tĩnh (Static Pages)
Route::view('/ve-chung-toi', 'pages.about')->name('page.about');
Route::view('/dieu-khoan-su-dung', 'pages.terms')->name('page.terms');
Route::view('/chinh-sach-bao-mat', 'pages.privacy')->name('page.privacy');
Route::view('/lien-he', 'pages.contact')->name('page.contact');


// ====================================================
// 2. NHÓM KHÁCH (Chưa đăng nhập mới được vào)
// ====================================================
Route::middleware('guest')->group(function () {
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Quên mật khẩu
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/check-secret', [AuthController::class, 'checkSecret'])->name('check.secret');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');
});

// ====================================================
// 3. NHÓM THÀNH VIÊN (Phải đăng nhập mới được vào)
// ====================================================
Route::middleware(['auth'])->group(function () {
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Trang cá nhân
    Route::get('/profile/{id?}', [ProfileController::class, 'index'])
    ->name('profile');
     Route::post('/follow/toggle', [FollowController::class, 'toggleFollow'])->name('follow.toggle');
    // Gửi đánh giá (Review) - Phải đăng nhập mới được đánh giá
    // Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    // Đổi mật khẩu
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password.post');

    // Xử lý bài đăng (Review)
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    // Alias dự phòng cho post store (để tránh lỗi code cũ)
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');

    // Route hiển thị form viết review
    Route::get('/reviews/viet-bai', function () {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        return view('create-review', compact('user'));
    })->name('reviews.create');

    // Route API tìm sách (Dành cho form viết review)
    Route::get('/api/books/search', function (Illuminate\Http\Request $request) {
        $query = $request->get('q');
        $books = Illuminate\Support\Facades\DB::table('books')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('author_name', 'like', "%{$query}%")
            ->select('id', 'title', 'author_name', 'published_year', 'cover_image')
            ->limit(10)
            ->get();
        return response()->json($books);
    });
});

// API Public (Không cần Auth)
Route::get('/api/user/{id}/followers', [FollowController::class, 'getFollowers']);
Route::get('/api/user/{id}/following', [FollowController::class, 'getFollowing']);

// ====================================================
// 4. NHÓM ADMIN (Phải có quyền Admin)
// ====================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/reviews', [AdminController::class, 'dashboardReviews'])->name('dashboard.reviews');
    Route::get('/dashboard/users', [AdminController::class, 'dashboardUsers'])->name('dashboard.users');
    Route::get('/dashboard/export-excel', [AdminController::class, 'exportExcel'])->name('dashboard.export');

    // 1. Quản lý Sách
    Route::resource('books', AdminBookController::class);
    Route::resource('articles', ArticleController::class);

    // 2. Quản lý Danh mục
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // 3. Quản lý Review
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class)->only(['index', 'update', 'destroy']);

    // 4. Quản lý Thành viên
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    // Route quản lý Banners (Tự động tạo: index, create, store, edit, update, destroy)
    Route::resource('banners', BannerController::class);

    // 5. Lịch sử hoạt động Admin
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/trash', [\App\Http\Controllers\Admin\ActivityLogController::class, 'trash'])->name('activity-logs.trash');
    Route::get('/activity-logs/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::post('/activity-logs/cleanup', [\App\Http\Controllers\Admin\ActivityLogController::class, 'cleanup'])->name('activity-logs.cleanup');
    Route::post('/activity-logs/{activityLog}/restore', [\App\Http\Controllers\Admin\ActivityLogController::class, 'restore'])->name('activity-logs.restore');
    Route::post('/activity-logs/restore-trashed', [\App\Http\Controllers\Admin\ActivityLogController::class, 'restoreTrashed'])->name('activity-logs.restore-trashed');
    Route::delete('/activity-logs/force-delete', [\App\Http\Controllers\Admin\ActivityLogController::class, 'forceDelete'])->name('activity-logs.force-delete');

    // 6. Trang tích hợp Thử thách & Danh hiệu
    Route::get('/game', [\App\Http\Controllers\Admin\GameController::class, 'index'])->name('game.index');

    // 7. Quản lý Danh hiệu (Badges)
    Route::resource('badges', \App\Http\Controllers\Admin\BadgeController::class);

    // 7. Quản lý Thử thách (Challenges)
    Route::resource('challenges', \App\Http\Controllers\Admin\ChallengeController::class);
    Route::post('/challenges/{challenge}/award-badge/{userId}', [\App\Http\Controllers\Admin\ChallengeController::class, 'awardBadge'])->name('challenges.award-badge');
});
