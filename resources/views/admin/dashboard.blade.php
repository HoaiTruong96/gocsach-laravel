<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Góc Sách</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        
        <!-- ================= SIDEBAR (MENU TRÁI) ================= -->
        <div class="w-64 bg-gray-900 text-white flex-shrink-0 hidden md:block">
            <div class="p-6 border-b border-gray-800 flex items-center gap-3">
                <i class="fas fa-user-shield text-red-500 text-2xl"></i>
                <span class="font-bold text-xl tracking-wide">ADMIN PANEL</span>
            </div>
            
            <nav class="mt-6 px-4 space-y-2">
                <!-- Menu Item: Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-red-600 rounded-lg text-white shadow-md transition">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Tổng Quan</span>
                </a>

                <!-- Menu Item: Quản lý Sách -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    <i class="fas fa-book w-5"></i>
                    <span>Quản lý Sách</span>
                </a>

                <!-- Menu Item: Về trang chủ -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition border-t border-gray-800 mt-4">
                    <i class="fas fa-home w-5"></i>
                    <span>Xem Trang Chủ</span>
                </a>

                <!-- Menu Item: Đăng Xuất (Dùng Form vì Route là POST) -->
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-900/20 rounded-lg transition text-left">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Đăng Xuất</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- ================= MAIN CONTENT (NỘI DUNG PHẢI) ================= -->
        <div class="flex-1 flex flex-col">
            
            <!-- Header Mobile -->
            <div class="bg-white p-4 shadow md:hidden flex justify-between items-center">
                <span class="font-bold">Admin Panel</span>
                <button class="text-gray-600"><i class="fas fa-bars"></i></button>
            </div>

            <!-- Nội dung chính -->
            <main class="p-8">
                <!-- Lời chào -->
                <div class="mb-8 flex justify-between items-end">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Xin chào, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-gray-500 mt-1">Chào mừng bạn quay trở lại trang quản trị.</p>
                    </div>
                    <div class="text-sm text-gray-400">
                        Hôm nay: {{ date('d/m/Y') }}
                    </div>
                </div>

                <!-- Thống kê (Stats Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    
                    <!-- Card 1: Tổng số sách -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Tổng đầu sách</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $bookCount ?? 0 }}</h3>
                        </div>
                    </div>

                    <!-- Card 2: Thành viên (Giả lập) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Thành viên</p>
                            <h3 class="text-2xl font-bold text-gray-800">1</h3>
                        </div>
                    </div>

                    <!-- Card 3: Review (Giả lập) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-xl">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Đánh giá mới</p>
                            <h3 class="text-2xl font-bold text-gray-800">0</h3>
                        </div>
                    </div>
                </div>

                <!-- Khu vực nội dung trống (Sau này sẽ hiện danh sách sách ở đây) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center py-20">
                    <div class="inline-block p-4 bg-gray-50 rounded-full mb-4">
                        <i class="fas fa-layer-group text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Chưa có hoạt động mới</h3>
                    <p class="text-gray-500 mt-1">Hệ thống đang hoạt động bình thường.</p>
                </div>

            </main>
        </div>
    </div>

</body>
</html>