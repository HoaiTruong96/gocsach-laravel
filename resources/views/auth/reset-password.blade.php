<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu - Góc Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 'brand-green': '#3E5F4E', 'brand-cream': '#FDFBF7', 'brand-brown': '#8C6B4B' },
                    fontFamily: { sans: ['Segoe UI', 'Roboto', 'sans-serif'], serif: ['Merriweather', 'serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-cream font-sans min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div class="text-center mb-8">
            <div class="text-brand-green text-4xl mb-3">
                <i class="fas fa-lock-open"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 font-serif">Đặt Mật Khẩu Mới</h3>
            <p class="text-sm text-gray-500 mt-2">Hãy chọn một mật khẩu mạnh để bảo vệ tài khoản.</p>
        </div>

        <form method="POST" action="{{ route('update.password') }}">
            @csrf
            <!-- Giữ lại ID user để biết đang đổi pass cho ai -->
            <input type="hidden" name="user_id" value="{{ $user_id }}">

            <!-- Báo lỗi nếu có -->
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Ô Mật khẩu mới -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-1">Mật khẩu mới</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-lock"></i></span>
                    
                    <input type="password" name="password" id="password" class="w-full pl-10 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition" placeholder="••••••••" required>
                    
                    <!-- Nút mắt -->
                    <button type="button" onclick="togglePassword('password', 'eye-icon-pass')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-brand-green focus:outline-none cursor-pointer">
                        <i class="fas fa-eye" id="eye-icon-pass"></i>
                    </button>
                </div>
            </div>

            <!-- Ô Nhập lại mật khẩu -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-1">Nhập lại mật khẩu</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-check-circle"></i></span>
                    
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full pl-10 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green transition" placeholder="••••••••" required>
                    
                    <!-- Nút mắt -->
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-brand-green focus:outline-none cursor-pointer">
                        <i class="fas fa-eye" id="eye-icon-confirm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-green text-white font-bold py-3 rounded-lg hover:bg-[#2C3E36] transition transform hover:-translate-y-0.5 shadow-md">
                Xác Nhận Đổi
            </button>
        </form>
    </div>

    <!-- Script xử lý ẩn/hiện mật khẩu cho cả 2 ô -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>