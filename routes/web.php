<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;     // Xử lý Đăng nhập/Đăng ký/Quên MK
use App\Http\Controllers\BookController;     // Hiển thị sách
use App\Http\Controllers\ProfileController;  // Hiển thị hồ sơ
use App\Http\Controllers\AdminController;    // <--- [CHUẨN] Nên khai báo ở đây

// ====================================================
// 1. TRANG CHỦ (Ai cũng xem được)
// ====================================================
Route::get('/', [BookController::class, 'index'])->name('home');
// ===> [MỚI THÊM] Trang Danh sách sách (Frontend tĩnh) <===
// Truy cập bằng đường dẫn: http://127.0.0.1:8000/danh-sach
Route::get('/danh-sach', function () {
    return view('list'); // Trả về file resources/views/list.blade.php
})->name('list');
Route::get('/chi-tiet', function () {
    return view('detail');
})->name('detail');
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