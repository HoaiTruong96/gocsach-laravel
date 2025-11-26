<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góc Sách - Review & Chia Sẻ</title>
    
    <!-- Dùng CDN cho nhanh (Sau này chuyên nghiệp sẽ dùng npm run dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        body { font-family: 'Roboto', sans-serif; }
        .banner-gradient { background: linear-gradient(90deg, #00c6ff 0%, #0072ff 100%); }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Top Bar -->
    <div class="bg-black text-white text-xs py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-4">
                <!-- Blade: Hiển thị ngày tháng cực gọn -->
                <span>Hôm nay: {{ date('d/m/Y') }}</span>
                <span class="font-bold cursor-pointer hover:text-blue-400">Top Sách Bán Chạy</span>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-blue-400"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-blue-400"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-blue-400"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- Header & Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center">
            
            <!-- Logo -->
            <div class="flex flex-col items-center mb-4 md:mb-0">
                <a href="/" class="text-red-700 text-3xl font-bold flex flex-col items-center hover:opacity-80 transition">
                    <i class="fas fa-book-reader mb-1"></i>
                    <span class="text-xl tracking-widest uppercase">Góc Sách</span>
                </a>
                <span class="text-xs text-gray-500 tracking-wide">Review & Share</span>
            </div>

            <!-- Banner -->
            <div class="hidden md:flex w-2/3 h-24 banner-gradient rounded-lg relative overflow-hidden text-white items-center justify-between px-8 mx-4 shadow-md">
                <div class="z-10">
                    <h2 class="text-2xl font-bold">THẾ GIỚI SÁCH</h2>
                    <p class="text-sm opacity-90">Khám phá tri thức vô tận</p>
                </div>
                <div class="z-10">
                    <button class="bg-white text-blue-600 px-5 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition shadow-sm">
                        Xem Ngay <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
                <div class="absolute top-[-20px] left-[-20px] w-24 h-24 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-[-40px] right-[50px] w-32 h-32 bg-white opacity-10 rounded-full"></div>
            </div>

             <!-- Mobile Icons -->
             <div class="md:hidden flex items-center space-x-4">
                <i class="fas fa-search text-lg"></i>
                <i class="fas fa-shopping-bag text-lg text-blue-500"></i>
            </div>
        </div>

        <!-- Menu -->
        <nav class="border-t border-gray-100 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-3 overflow-x-auto whitespace-nowrap scrollbar-hide">
                    <ul class="flex space-x-6 text-sm font-medium uppercase text-gray-700">
                        <li class="text-blue-600 border-b-2 border-blue-600 pb-1"><a href="/">Trang Chủ</a></li>
                        <li class="hover:text-blue-600 cursor-pointer transition">Review Sách</li>
                        <li class="hover:text-blue-600 cursor-pointer transition">Tác Giả</li>
                        <li class="hover:text-blue-600 cursor-pointer transition">Top List</li>
                        <li class="hover:text-blue-600 cursor-pointer transition">Cộng Đồng</li>
                    </ul>
                    <div class="hidden md:block">
                        <div class="relative">
                            <input type="text" placeholder="Tìm kiếm sách..." class="pl-3 pr-8 py-1 border rounded-full text-sm focus:outline-none focus:border-blue-500">
                            <i class="fas fa-search text-gray-400 absolute right-3 top-2 text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 min-h-screen">
        
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold border-l-4 border-blue-500 pl-3">Mới Cập Nhật</h2>
            <a href="#" class="text-sm text-blue-500 hover:underline">Xem tất cả</a>
        </div>

        <!-- Grid Sách -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Blade: Dùng @forelse thay vì @foreach để tự động xử lý khi không có dữ liệu --}}
            @forelse($books as $book)
                
                <div class="flex flex-col group cursor-pointer h-full">
                    <div class="overflow-hidden rounded-lg mb-3 relative shadow-sm border border-gray-100">
                        <!-- Ảnh bìa -->
                        <img src="{{ $book->image_url }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-64 object-cover transform transition duration-500 group-hover:scale-105"
                             onerror="this.src='https://via.placeholder.com/300x400?text=No+Image'">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300"></div>
                        
                        <!-- Category -->
                        <span class="absolute top-2 left-2 bg-blue-600 text-white text-[10px] px-2 py-1 rounded shadow uppercase font-bold">
                            {{ $book->category }}
                        </span>
                    </div>

                    <div class="flex flex-col flex-grow">
                        <div class="flex items-center text-xs text-gray-500 mb-2 space-x-2">
                            <span class="font-medium text-gray-700"><i class="far fa-user mr-1"></i>{{ $book->author }}</span>
                            <span class="text-gray-300">|</span>
                            {{-- Format ngày tháng trong Blade --}}
                            <span><i class="far fa-clock mr-1"></i>{{ date('d/m/Y', strtotime($book->publish_date)) }}</span>
                        </div>
                        
                        <h3 class="text-lg font-bold leading-tight group-hover:text-blue-600 transition duration-300 line-clamp-2 mb-2">
                            <a href="#">{{ $book->title }}</a>
                        </h3>
                        
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">
                            {{ $book->description ?? 'Chưa có mô tả cho cuốn sách này.' }}
                        </p>
                    </div>
                </div>

            @empty
                {{-- Phần này sẽ hiện ra nếu Database chưa có sách nào --}}
                <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <i class="fas fa-book-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Chưa có cuốn sách nào trong cơ sở dữ liệu.</p>
                </div>
            @endforelse

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-12 py-8 border-t border-gray-200">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-bold text-gray-700 mb-2">Góc Sách</h3>
            <p class="text-gray-500 text-sm mb-4">Kết nối tri thức - Chia sẻ đam mê</p>
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} HoaiTruong96. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>