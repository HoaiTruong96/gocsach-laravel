<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góc Sách - Mạng Xã Hội Đọc Sách</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#3E5F4E', // Xanh rêu
                        'brand-cream': '#FDFBF7', // Nền kem
                        'brand-beige': '#F3E5D0', // Nền tag
                        'brand-brown': '#8C6B4B', // Chữ nâu
                        'brand-accent': '#D4A373', // Cam đất
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'Roboto', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FDFBF7;
            color: #2C3E36;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-brand-cream sticky top-0 z-50 border-b border-gray-200/50 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <a href="{{ route('home') }}" class="text-brand-green text-2xl font-bold flex items-center gap-2">
                    <span class="text-3xl">📚</span>
                    <span class="tracking-wide">GÓC SÁCH</span>
                </a>
            </div>
            <div class="hidden md:flex flex-1 mx-10 max-w-lg">
                <div class="relative w-full">
                    <input type="text" placeholder="Tìm kiếm sách, tác giả..."
                        class="w-full bg-[#EBE5D9] rounded-full py-2 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green text-gray-700 placeholder-gray-500">
                    <button class="absolute right-4 top-2.5 text-gray-500 hover:text-brand-green">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

           <nav class="flex items-center space-x-6 text-sm font-medium text-gray-600">
    
            <a href="{{ route('home') }}" class="text-brand-green font-bold border-b-2 border-brand-green pb-1">Trang Chủ</a>
    
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:text-red-800 font-bold border border-red-100 bg-red-50 px-3 py-1 rounded-full transition">
                <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
            </a>
        @endif

    <a href="{{ route('list') }}" class="hover:text-brand-green transition">Danh Sách</a>
    
    <a href="#" class="hover:text-brand-green transition">Bài Viết</a>

    @auth
                <div class="relative group z-50">
                    <button class="flex items-center gap-2 text-brand-green font-bold focus:outline-none hover:opacity-80 transition py-2"> <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3E5F4E&color=fff" class="w-8 h-8 rounded-full border border-brand-green shadow-sm">
                        <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>

                    <div class="absolute right-0 top-full pt-2 w-48 hidden group-hover:block">
                        
                        <div class="bg-white rounded-lg shadow-xl border border-gray-100 py-2 animate-fade-in">
                            <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-400">
                                Xin chào, {{ Auth::user()->name }}
                            </div>
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-brand-beige hover:text-brand-green transition">
                                <i class="fas fa-user mr-2"></i> Hồ sơ cá nhân
                            </a>
                            <a href="{{ route('change.password') }}" class="block px-4 py-2 text-gray-700 hover:bg-brand-beige hover:text-brand-green transition">
                                <i class="fas fa-key mr-2"></i> Đổi mật khẩu
                            </a>
            
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Đăng Xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green transition">Đăng Nhập</a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('register') }}" class="text-brand-green font-bold hover:underline decoration-2 underline-offset-4">Đăng Ký</a>
        </div>
    @endauth

    </nav>
        </div>
    </header>

    <!-- BANNER NỔI BẬT -->
    <section class="bg-brand-green text-white py-12">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center gap-10">
            <div class="w-full md:w-1/3 flex justify-center md:justify-end">
                <div class="relative w-48 h-72 shadow-2xl rounded-lg overflow-hidden border-4 border-white/20 transform hover:-translate-y-2 transition duration-500 cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="w-full md:w-2/3 text-center md:text-left">
                <span class="text-brand-beige text-xs font-bold uppercase tracking-widest mb-2 block opacity-90">Cuốn Sách Của Tháng</span>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight font-serif">Cây Cam Ngọt Của Tôi</h1>
                <div class="flex items-center justify-center md:justify-start text-yellow-400 mb-4 text-base gap-1">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    <span class="text-white ml-2 opacity-80 text-sm">(4.9)</span>
                </div>
                <p class="text-gray-200 text-lg mb-8 line-clamp-2 italic font-light max-w-2xl">"Hành trình cảm động về tuổi thơ, nỗi đau và tình yêu thương..."</p>
                <a href="#" class="inline-block bg-brand-beige text-brand-green font-bold px-8 py-3 rounded-lg shadow-lg hover:bg-white hover:scale-105 transition transform">Đọc Bài Review</a>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 py-12 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- CỘT TRÁI (DANH SÁCH SÁCH) -->
            <div class="lg:col-span-8 space-y-12">
                <section>
                    <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-2">
                        <h2 class="text-2xl font-bold text-brand-green font-serif">Review Mới Nhất</h2>
                        <a href="#" class="text-brand-green text-sm font-semibold hover:underline mb-1">Xem tất cả ></a>
                    </div>
                    
                    <!-- [DYNAMIC] Lưới hiển thị sách từ Database -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($books as $book)
                            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex gap-4 h-48 group cursor-pointer">
                                <!-- Ảnh bìa sách -->
                                <div class="w-28 flex-shrink-0 overflow-hidden rounded shadow-sm relative">
                                    <img src="{{ $book->image_url }}" alt="{{ $book->title }}" 
                                         class="w-full h-full object-cover transform transition duration-500 group-hover:scale-105"
                                         onerror="this.src='https://via.placeholder.com/300x400?text=No+Image'">
                                </div>
                                
                                <!-- Thông tin sách -->
                                <div class="flex flex-col flex-1">
                                    <h3 class="font-bold text-gray-800 line-clamp-2 mb-1 hover:text-brand-green transition text-lg font-serif">
                                        <a href="{{ route('book.show', $book->id) }}">{{ $book->title }}</a>
                                    </h3>
                                    
                                    <!-- Rating giả lập (hoặc lấy từ DB nếu có) -->
                                    <div class="flex text-yellow-400 text-xs mb-2">★★★★★</div>
                                    
                                    <div class="flex items-center gap-2 mb-2">
                                        <!-- Avatar tác giả (dùng UI Avatars) -->
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($book->author) }}&background=random" class="w-5 h-5 rounded-full">
                                        <span class="text-xs text-gray-500">{{ $book->author }}</span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-500 line-clamp-2 mt-auto">
                                        {{ $book->description ?? 'Chưa có mô tả cho cuốn sách này.' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-8 rounded-xl text-center border border-dashed border-gray-300">
                                <i class="fas fa-book-open text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Chưa có cuốn sách nào trong cơ sở dữ liệu.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-brand-green mb-4 font-serif">Thể Loại Phổ Biến</h2>
                    <div class="flex flex-wrap gap-3">
                        <a href="#" class="bg-[#EBE5D9] text-[#6B5A45] px-5 py-2 rounded-lg text-sm font-semibold hover:bg-brand-brown hover:text-white transition">Văn Học</a>
                        <a href="#" class="bg-[#EBE5D9] text-[#6B5A45] px-5 py-2 rounded-lg text-sm font-semibold hover:bg-brand-brown hover:text-white transition">Kinh Tế</a>
                        <a href="#" class="bg-[#EBE5D9] text-[#6B5A45] px-5 py-2 rounded-lg text-sm font-semibold hover:bg-brand-brown hover:text-white transition">Tâm Lý</a>
                        <a href="#" class="bg-[#EBE5D9] text-[#6B5A45] px-5 py-2 rounded-lg text-sm font-semibold hover:bg-brand-brown hover:text-white transition">Trinh Thám</a>
                    </div>
                </section>

                <div class="relative bg-brand-beige rounded-2xl p-8 overflow-hidden flex items-center justify-between shadow-sm">
                    <div class="relative z-10 w-2/3">
                        <h3 class="text-2xl font-bold text-brand-brown mb-2 font-serif">Thử Thách Đọc Sách Mùa Thu</h3>
                        <p class="text-brand-brown opacity-80 mb-4 text-sm">Tham gia ngay để nhận huy hiệu đặc biệt</p>
                        <button class="bg-brand-brown text-white px-6 py-2 rounded font-bold text-sm hover:bg-[#6e5338] transition">Tham Gia Ngay</button>
                    </div>
                    <div class="absolute right-4 bottom-[-10px] opacity-20 text-brand-brown">
                        <i class="fas fa-leaf text-8xl"></i>
                    </div>
                </div>
            </div>

            <!-- CỘT PHẢI (SIDEBAR) -->
            <div class="lg:col-span-4">
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100 font-serif border-l-4 border-brand-green pl-3">
                        Top Thịnh Hành
                    </h3>

                    <!-- Sidebar giả lập (Để cho đẹp) -->
                    <div class="space-y-6">
                        @foreach(['Cây Cam Ngọt Của Tôi', 'Dế Mèn Phiêu Lưu Ký', 'Hoàng Tử Bé'] as $index => $title)
                        <div class="flex gap-4 items-start group cursor-pointer">
                            <div class="text-3xl font-bold text-[#EBE5D9] group-hover:text-brand-accent transition w-8 text-center leading-none font-serif">{{ $index + 1 }}</div>
                            <div class="w-12 h-16 flex-shrink-0 bg-gray-200 rounded overflow-hidden shadow-sm">
                                <img src="https://source.unsplash.com/random/200x300?book,{{ $index }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition">{{ $title }}</h4>
                                <p class="text-xs text-gray-500 mb-1">Nhiều Tác Giả</p>
                                <div class="text-[10px] text-yellow-400">★★★★★ 4.9</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#2C3E36] text-white pt-16 pb-8 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="space-y-4">
                    <div class="flex flex-col items-start">
                        <div class="mb-2"><i class="fas fa-book-open text-4xl text-[#E9EDC9]"></i></div>
                        <h3 class="font-bold text-lg leading-tight">Mọt Sách Review - <br>Kết nối tri thức</h3>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Liên Kết Nhanh</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-[#D4A373] transition">Về chúng tôi</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Thể Loại</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-[#D4A373] transition">Tiểu thuyết</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Kinh tế</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Đăng Ký Nhận Tin</h4>
                    <form onsubmit="event.preventDefault();" class="flex mb-6">
                        <input type="email" placeholder="Email..." class="w-full px-4 py-2 text-gray-800 rounded-l focus:outline-none text-sm">
                        <button class="bg-[#8C6B4B] hover:bg-[#6e5338] text-white font-bold px-4 py-2 rounded-r transition text-sm whitespace-nowrap">Đăng Ký</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-600 pt-8 text-center text-xs text-gray-400">
                Copyright © 2025 Mọt Sách Review
            </div>
        </div>
    </footer>

</body>
</html>