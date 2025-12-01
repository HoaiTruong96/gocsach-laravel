<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên Mật Khẩu - Góc Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
        <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">Khôi Phục Tài Khoản</h3>
        
        <form method="POST" action="{{ route('check.secret') }}">
            @csrf
            @if(session('error'))
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email đăng ký</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-800" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Mã bí mật của bạn</label>
                <input type="text" name="secret_code" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-800" placeholder="Nhập mã bí mật" required>
            </div>
            
            <button type="submit" class="w-full bg-[#3E5F4E] text-white font-bold py-2 rounded-lg hover:opacity-90 transition">
                Kiểm Tra
            </button>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:underline">Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</body>
</html>