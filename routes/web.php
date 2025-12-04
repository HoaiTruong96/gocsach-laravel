<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;     // Xử lý Đăng nhập/Đăng ký/Quên MK
use App\Http\Controllers\BookController;     // Hiển thị sách
use App\Http\Controllers\ProfileController;  // Hiển thị hồ sơ
use App\Http\Controllers\AdminController;    // Trang Admin Dashboard
use App\Http\Controllers\HomeController;     // Trang chủ

// ====================================================
// 1. PUBLIC ROUTES (Ai cũng xem được)
// ====================================================

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang Danh sách sách (Frontend tĩnh)
Route::get('/danh-sach', function () {
    return view('list');
})->name('list');

// Trang Chi tiết sách (Giao diện tĩnh - test)
Route::get('/chi-tiet', function () {
    return view('detail');
})->name('detail');

// [QUAN TRỌNG] Route xem chi tiết sách thật (Lấy từ DB theo ID hoặc Slug)
// Ưu tiên dùng slug nếu controller đã hỗ trợ, ở đây tạm dùng ID theo code cũ của bạn
// Nếu dùng slug: Route::get('/sach/{slug}', [BookController::class, 'show'])->name('book.show');
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

    // Trang cá nhân - Xem & Cập nhật
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update'); // [MỚI] Route update avatar

    // Đổi mật khẩu
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password.post');
});

// ====================================================
// 4. NHÓM ADMIN (Phải có quyền Admin)
// ====================================================
// Lưu ý: Nếu chưa có middleware 'admin', bạn có thể tạm bỏ 'admin' ra khỏi mảng middleware
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Trang Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // [QUAN TRỌNG] QUẢN LÝ SÁCH (CRUD)
    // Dòng này tạo ra toàn bộ các route: index, create, store, edit, update, destroy
    Route::resource('books', BookController::class);
});

// Route chạy lệnh fix ảnh (Tùy chọn, chạy xong nhớ xóa)
Route::get('/fix-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Đã tạo link storage thành công!';
});
