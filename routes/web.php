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

    // 1. Quản lý Sách
    Route::resource('books', AdminBookController::class);

    // 2. Quản lý Danh mục
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // 3. Quản lý Review
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'update', 'destroy']);

    // 4. Quản lý Thành viên
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});
