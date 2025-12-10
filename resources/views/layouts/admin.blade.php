<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Góc Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <!-- 1. Tổng quan (Dashboard) -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Tổng Quan</span>
                </a>

                <!-- 2. Quản lý Sách -->
                <a href="{{ route('books.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('books.*') ? 'bg-red-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} rounded-lg transition">
                    <i class="fas fa-book w-5"></i>
                    <span>Quản lý Sách</span>
                </a>

                <!-- 3. Về trang chủ -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition border-t border-gray-800 mt-4">
                    <i class="fas fa-home w-5"></i>
                    <span>Xem Trang Chủ</span>
                </a>

                <!-- 4. Đăng xuất -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-900/20 rounded-lg transition mt-2 text-left">
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
                <!-- Header của từng trang -->
                <div class="mb-8 flex justify-between items-end">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">@yield('header')</h1>
                    </div>
                    <div class="text-sm text-gray-400">Hôm nay: {{ date('d/m/Y') }}</div>
                </div>

                <!-- Thông báo thành công nếu có -->
                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <!-- ĐÂY LÀ CHỖ CHỨA NỘI DUNG RIÊNG CỦA TỪNG TRANG -->
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>