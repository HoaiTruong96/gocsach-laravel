<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/', [BookController::class, 'home'])->name('home');

// ===> [MỚI THÊM] Trang Danh sách sách (Frontend tĩnh) <===
// Truy cập bằng đường dẫn: http://127.0.0.1:8000/danh-sach
Route::get('/danh-sach', function () {
    return view('list');
})->name('list');

Route::get('/chi-tiet', function () {
    return view('detail');
})->name('detail');

Route::get('/review-search', [BookController::class, 'search'])->name('books.search');

Route::get('/book/{slug}', [BookController::class, 'show'])->name('book.show');

Route::get('/ranking/top-liked', [RankingController::class, 'topLikedPosts']);

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
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Sẽ tạo ra các route: admin.books.index, admin.books.create...
    Route::resource('books', AdminBookController::class);
});
