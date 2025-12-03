<?php

namespace App\Http\Controllers;

use App\Models\User; // Gọi Model User để thêm dữ liệu vào DB
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Thư viện mã hóa mật khẩu

class AuthController extends Controller
{
    // --- 1. ĐĂNG NHẬP ---
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home'); // Đăng nhập xong về trang chủ
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // --- 2. ĐĂNG KÝ ---
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        // Validate dữ liệu (Thêm secret_code)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'secret_code' => 'required|string|max:255', // [CẬP NHẬT] Bắt buộc nhập mã bí mật
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Tạo user mới trong Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'secret_code' => $request->secret_code, // [CẬP NHẬT] Lưu mã bí mật vào DB
            'password' => Hash::make($request->password),
        ]);

        // Đăng nhập luôn cho người dùng sau khi đăng ký
        Auth::login($user);

        return redirect()->route('home');
    }

    // --- 3. QUÊN MẬT KHẨU (MỚI) ---
    
    // Hiển thị form nhập Email & Mã bí mật
    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    // Kiểm tra xem Email và Mã bí mật có khớp trong DB không
    public function checkSecret(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'secret_code' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('secret_code', $request->secret_code)
                    ->first();

        if ($user) {
            // Nếu đúng, chuyển sang trang nhập mật khẩu mới (gửi kèm ID user)
            return view('auth.reset-password', ['user_id' => $user->id]);
        }

        // Nếu sai, báo lỗi quay lại
        return back()->with('error', 'Email hoặc Mã bí mật không chính xác!');
    }

    // Thực hiện đổi mật khẩu mới (Quên mật khẩu)
    public function updatePassword(Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'user_id' => 'required'
        ]);

        // Tìm user theo ID
        $user = User::find($request->user_id);
        
        if($user) {
            // Cập nhật mật khẩu mới (đã mã hóa)
            $user->password = Hash::make($request->password);
            $user->save();
            
            return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công! Hãy đăng nhập lại.');
        }
        
        return redirect()->route('login')->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại.']);
    }

    // --- 4. ĐĂNG XUẤT ---
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // --- 5. ĐỔI MẬT KHẨU (Dành cho người đã đăng nhập) ---
    public function showChangePasswordForm() {
        return view('auth.change-password');
    }

    public function changePassword(Request $request) {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'new_password.different' => 'Mật khẩu mới không được trùng với mật khẩu cũ.'
        ]);

        // 2. Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // 3. Cập nhật mật khẩu mới
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Đổi mật khẩu thành công!');
    }
}