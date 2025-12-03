<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi Mật Khẩu</title>
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
        <div class="text-center mb-6">
            <div class="text-brand-green text-3xl mb-2">
                <i class="fas fa-key"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 font-serif">Đổi Mật Khẩu</h3>
        </div>

        <form method="POST" action="{{ route('change.password.post') }}">
            @csrf

            <!-- Báo lỗi/Thành công -->
            @if (session('status'))
                <div class="bg-green-50 text-green-700 p-3 rounded mb-4 text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Mật khẩu hiện tại -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-1">Mật khẩu hiện tại</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brand-green" required>
                    <button type="button" onclick="togglePassword('current_password', 'eye-1')" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-brand-green">
                        <i class="fas fa-eye" id="eye-1"></i>
                    </button>
                </div>
            </div>

            <!-- Mật khẩu mới -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-1">Mật khẩu mới</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brand-green" required>
                    <button type="button" onclick="togglePassword('new_password', 'eye-2')" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-brand-green">
                        <i class="fas fa-eye" id="eye-2"></i>
                    </button>
                </div>
            </div>

            <!-- Nhập lại mật khẩu mới -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-1">Xác nhận mật khẩu mới</label>
                <div class="relative">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brand-green" required>
                    <button type="button" onclick="togglePassword('new_password_confirmation', 'eye-3')" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-brand-green">
                        <i class="fas fa-eye" id="eye-3"></i>
                    </button>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('home') }}" class="w-1/2 bg-gray-200 text-gray-700 font-bold py-2 rounded-lg text-center hover:bg-gray-300">Hủy</a>
                <button type="submit" class="w-1/2 bg-brand-green text-white font-bold py-2 rounded-lg hover:bg-[#2C3E36]">Lưu Thay Đổi</button>
            </div>
        </form>
    </div>

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