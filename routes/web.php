<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;     // Xử lý Đăng nhập/Đăng ký/Quên MK
use App\Http\Controllers\BookController;     // Hiển thị sách
use App\Http\Controllers\ProfileController;  // Hiển thị hồ sơ
use App\Http\Controllers\AdminController;    // Quản trị viên
use App\Http\Controllers\ReviewController;   // Xử lý đánh giá

// ====================================================
// 1. NHÓM PUBLIC (Ai cũng xem được)
// ====================================================

// Trang chủ
Route::get('/', [BookController::class, 'index'])->name('home');

// Trang danh sách (Fix lỗi route [list] not defined)
Route::get('/list', function () {
    return view('list');
})->name('list');
Route::get('/detail', function () {
    return view('detail');
})->name('detail');
// Tìm kiếm sách
Route::get('/review-search', [BookController::class, 'search'])->name('books.search');

// Xem chi tiết sách
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');


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
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    // Đổi mật khẩu
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password.post');
});


// ====================================================
// 4. NHÓM ADMIN (Phải có quyền Admin)
// ====================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Trang Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

});