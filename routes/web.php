<?php

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


// --- ƯU TIÊN 2: Route ngắn hơn (Catch-all) ---
// Xem chi tiết sách
Route::get('/chi-tiet/{slug}', [BookController::class, 'show'])->name('detail');
Route::get('/review-search', [BookController::class, 'search'])->name('books.search');

Route::get('/book/{slug}', [BookController::class, 'show'])->name('book.show');

Route::get('/ranking/top-liked', [RankingController::class, 'topLikedPosts']);
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
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
Route::middleware('auth')->group(function () {
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Trang cá nhân
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Gửi đánh giá (Review) - Phải đăng nhập mới được đánh giá
    // Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    // Đổi mật khẩu
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password.post');
});

// ====================================================
// 4. NHÓM ADMIN (Phải có quyền Admin)
// ====================================================
// ... Bên trong nhóm Route admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/reviews', [AdminController::class, 'dashboardReviews'])->name('dashboard.reviews');
    Route::get('/dashboard/users', [AdminController::class, 'dashboardUsers'])->name('dashboard.users');
    Route::get('/dashboard/export-excel', [AdminController::class, 'exportExcel'])->name('dashboard.export');

    // 1. Quản lý Sách
    Route::resource('books', AdminBookController::class);

    // 2. Quản lý Danh mục
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // 3. Quản lý Review
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class)->only(['index', 'update', 'destroy']);

    // 4. Quản lý Thành viên
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // 5. Lịch sử hoạt động Admin
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/trash', [\App\Http\Controllers\Admin\ActivityLogController::class, 'trash'])->name('activity-logs.trash');
    Route::get('/activity-logs/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::post('/activity-logs/cleanup', [\App\Http\Controllers\Admin\ActivityLogController::class, 'cleanup'])->name('activity-logs.cleanup');
    Route::post('/activity-logs/{activityLog}/restore', [\App\Http\Controllers\Admin\ActivityLogController::class, 'restore'])->name('activity-logs.restore');
    Route::post('/activity-logs/restore-trashed', [\App\Http\Controllers\Admin\ActivityLogController::class, 'restoreTrashed'])->name('activity-logs.restore-trashed');
    Route::delete('/activity-logs/force-delete', [\App\Http\Controllers\Admin\ActivityLogController::class, 'forceDelete'])->name('activity-logs.force-delete');
});
