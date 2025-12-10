<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;     // Xử lý Đăng nhập/Đăng ký/Quên MK
use App\Http\Controllers\BookController;     // Hiển thị sách
use App\Http\Controllers\ProfileController;  // Hiển thị hồ sơ
use App\Http\Controllers\AdminController;    // Quản trị viên
use App\Http\Controllers\PostController;   // Xử lý đánh giá
use App\Models\Post;

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
Route::get('/post-search', [BookController::class, 'search'])->name('books.search');

// Xem chi tiết sách
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');
Route::get('/chi-tiet', function () {
    return view('detail');
})->name('detail');
Route::get('/danh-sach', function () {
    // Lấy tất cả sách, phân trang 12 cuốn
    $books = Book::with('categories')->latest()->paginate(12);
    
    // Trả về view 'list'
    return view('list', compact('books'));
})->name('list'); // Tên route là 'list' để khớp với menu
Route::get('/chi-tiet/{slug}', [BookController::class, 'show'])->name('detail');
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
    Route::post('/post', [PostController::class, 'store'])->name('post.store');

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
Route::middleware('auth')->group(function () {
    // Ajax Like & Comment (Dùng post/{id})
    Route::post('/post/{id}/like', [PostController::class, 'toggleLike']);
    Route::post('/post/{id}/comment', [PostController::class, 'postComment']);
});
