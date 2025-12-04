<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góc Sách - Mạng Xã Hội Đọc Sách</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300&family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2A483A',
                        'brand-green-light': '#3E5F4E',
                        'brand-cream': '#FDFBF7',
                        'brand-beige': '#F2E8DC',
                        'brand-brown': '#8C6B4B',
                        'brand-accent': '#D4A373',
                    },
                    fontFamily: {
                        sans: ['Nunito Sans', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FAF9F6;
            color: #333;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #E5E7EB;
            border-radius: 20px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: #3E5F4E;
        }
        /* Slider Styles */
        .hero-slider-wrapper {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen selection:bg-brand-green selection:text-white">

    <!-- [NEW] TOP BAR: Thông tin liên hệ & Social -->
    <div class="bg-[#1F352B] text-white/80 text-xs py-2 hidden md:block border-b border-white/10">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex gap-6">
                <span class="hover:text-brand-accent cursor-pointer transition"><i class="fas fa-phone-alt mr-2"></i> Hotline: 1900 1234</span>
                <span class="hover:text-brand-accent cursor-pointer transition"><i class="fas fa-envelope mr-2"></i> contact@gocsach.com</span>
            </div>
            <div class="flex gap-4 items-center">
                <a href="#" class="hover:text-white transition">Trợ giúp</a>
                <span class="text-white/20">|</span>
                <a href="#" class="hover:text-white transition">Quy tắc cộng đồng</a>
                <div class="flex gap-3 ml-4">
                    <a href="#" class="hover:text-brand-accent transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-brand-accent transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-brand-accent transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- [UPGRADED] HEADER MAIN -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-wrap justify-between items-center gap-4">
                
                <!-- 1. Logo & Mobile Toggle -->
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-brand-green focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>

                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-brand-green text-white rounded-lg flex items-center justify-center shadow-md transform group-hover:rotate-6 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold font-serif text-brand-green leading-none tracking-tight">GÓC SÁCH</span>
                            <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Review & Share</span>
                        </div>
                    </a>
                </div>

                <!-- 2. Search Bar (Advanced) -->
                <div class="hidden md:flex flex-1 max-w-2xl px-8">
                    <div class="relative w-full group flex items-center">
                        <div class="absolute left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-xs font-bold bg-gray-100 px-2 py-1 rounded">Tất cả</span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400 ml-1"></i>
                        </div>
                        <input type="text" placeholder="Tìm kiếm sách, tác giả, bài viết..."
                            class="w-full bg-gray-50 border border-gray-200 group-hover:border-brand-green/30 rounded-full py-2.5 pl-24 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/20 focus:bg-white transition-all text-gray-700 placeholder-gray-400 shadow-inner">
                        <button class="absolute right-2 top-1.5 w-8 h-8 bg-brand-green text-white rounded-full flex items-center justify-center hover:bg-brand-accent transition shadow-md">
                            <i class="fas fa-search text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- 3. Right Actions (User, Noti, Cart) -->
                <div class="flex items-center gap-3 md:gap-5">
                    
                    @auth
                        <!-- Notification (Only for logged in) -->
                        <div class="relative hidden sm:block">
                            <button class="text-gray-500 hover:text-brand-green transition relative">
                                <i class="far fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                        </div>

                        <!-- Bookmarks -->
                        <div class="relative hidden sm:block">
                            <button class="text-gray-500 hover:text-brand-green transition" title="Tủ sách đã lưu">
                                <i class="far fa-bookmark text-xl"></i>
                            </button>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative group z-50 pl-2 border-l border-gray-200">
                            <button class="flex items-center gap-2 focus:outline-none py-1">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3E5F4E&color=fff&size=40" 
                                     class="w-9 h-9 rounded-full border-2 border-brand-beige shadow-sm hover:border-brand-green transition">
                                <div class="hidden lg:flex flex-col items-start">
                                    <span class="text-xs font-bold text-gray-700 truncate max-w-[80px]">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] text-gray-400">Thành viên</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400 ml-1"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <!-- [FIX] Thêm lớp giả before: để nối liền khoảng hở, tránh mất hover -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-card border border-gray-100 hidden group-hover:block py-2 animate-fade-in origin-top-right before:content-[''] before:absolute before:-top-3 before:w-full before:h-4 before:left-0 before:bg-transparent">
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50 rounded-t-xl">
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Xin chào</p>
                                    <p class="text-sm font-bold text-brand-green truncate">{{ Auth::user()->name }}</p>
                                </div>
                                
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-red-600 hover:bg-red-50 transition font-bold">
                                        <i class="fas fa-tachometer-alt w-5 mr-2"></i> Dashboard Admin
                                    </a>
                                    <div class="border-t border-gray-50 my-1"></div>
                                @endif

                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-brand-cream hover:text-brand-green transition">
                                    <i class="fas fa-user-circle w-5 mr-2"></i> Hồ sơ cá nhân
                                </a>
                                <a href="#" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-brand-cream hover:text-brand-green transition">
                                    <i class="fas fa-book-reader w-5 mr-2"></i> Tủ sách của tôi
                                </a>
                                <a href="{{ route('change.password') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-brand-cream hover:text-brand-green transition">
                                    <i class="fas fa-cog w-5 mr-2"></i> Đổi mật khẩu
                                </a>
                                
                                <div class="border-t border-gray-50 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-gray-500 hover:bg-red-50 hover:text-red-600 transition font-medium">
                                        <i class="fas fa-sign-out-alt w-5 mr-2"></i> Đăng Xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Actions -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green font-bold text-sm px-3 py-2 rounded-lg hover:bg-gray-100 transition hidden sm:block">Đăng Nhập</a>
                            <a href="{{ route('register') }}" class="bg-brand-green text-white px-5 py-2.5 rounded-full hover:bg-brand-green-light hover:shadow-lg transition transform hover:-translate-y-0.5 font-bold shadow-md text-sm flex items-center gap-2">
                                <i class="fas fa-user-plus text-xs"></i> <span>Đăng Ký</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- 4. Navigation Links (Desktop) -->
            <div class="hidden md:flex justify-center mt-2 border-t border-gray-100 pt-3">
                <nav class="flex items-center gap-8 text-sm font-semibold text-gray-500">
                    <a href="{{ route('home') }}" class="text-brand-green border-b-2 border-brand-green pb-3 -mb-3.5 transition-colors">Trang Chủ</a>
                    <a href="#" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all">Sách Mới</a>
                    <a href="#" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all">Review Hay</a>
                    <a href="#" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all">Tác Giả</a>
                    <a href="#" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all">Cộng Đồng</a>
                    <a href="#" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all text-brand-accent">
                        <i class="fas fa-fire mr-1"></i>Thử Thách
                    </a>
                </nav>
            </div>
        </div>

        <!-- 5. Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full left-0 top-full shadow-lg animate-fade-in-down">
            <div class="p-4 space-y-4">
                <form class="relative">
                    <input type="text" placeholder="Tìm kiếm..." class="w-full bg-gray-50 border border-gray-200 rounded-lg py-2 px-4 text-sm focus:outline-none focus:border-brand-green">
                    <button class="absolute right-3 top-2 text-gray-400"><i class="fas fa-search"></i></button>
                </form>
                <nav class="flex flex-col gap-2 text-sm font-medium text-gray-600">
                    <a href="{{ route('home') }}" class="p-2 rounded hover:bg-brand-cream hover:text-brand-green">Trang Chủ</a>
                    <a href="#" class="p-2 rounded hover:bg-brand-cream hover:text-brand-green">Sách Mới</a>
                    <a href="#" class="p-2 rounded hover:bg-brand-cream hover:text-brand-green">Review Hay</a>
                    <a href="#" class="p-2 rounded hover:bg-brand-cream hover:text-brand-green">Tác Giả</a>
                    <a href="#" class="p-2 rounded hover:bg-brand-cream hover:text-brand-green">Cộng Đồng</a>
                </nav>
                @auth
                    <div class="border-t border-gray-100 pt-4">
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 p-2 rounded hover:bg-brand-cream">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3E5F4E&color=fff&size=32" class="w-8 h-8 rounded-full">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button class="w-full text-left p-2 rounded hover:bg-red-50 text-red-600">Đăng Xuất</button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-100 pt-4 flex gap-3">
                        <a href="{{ route('login') }}" class="flex-1 text-center py-2 border border-gray-200 rounded-lg text-gray-600">Đăng Nhập</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center py-2 bg-brand-green text-white rounded-lg">Đăng Ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- [UPDATED] HERO SLIDER SECTION -->
    @php
        // Dữ liệu giả lập cho Slider (Đã xóa thuộc tính bg_class)
        // BẠN CÓ THỂ THAY ĐỔI ẢNH BÌA SÁCH Ở CÁC DÒNG 'image' BÊN DƯỚI
        $heroSlides = [
            [
                'title' => 'Cây Cam Ngọt Của Tôi',
                'tag' => 'Sách Của Tháng 12',
                'desc' => '"Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào của trí tưởng tượng..."',
                'image' => 'https://library.hust.edu.vn/sites/default/files/C%C3%A2y%20cam%20ng%E1%BB%8Dt%20c%E1%BB%A7a%20t%C3%B4i%20-%20%E1%BA%A2nh%20b%C3%ACa.jpg', // <--- THAY LINK ẢNH TẠI ĐÂY
                'rating' => '4.9/5.0',
            ],
            [
                'title' => 'Nhà Giả Kim',
                'tag' => 'Bán Chạy Nhất',
                'desc' => '"Khi bạn khao khát một điều gì đó, cả vũ trụ sẽ hợp lực giúp bạn đạt được nó."',
                'image' => 'https://baocantho.com.vn/image/news/2017/20170107/fckimage/40361498129094_102.jpg', // <--- THAY LINK ẢNH TẠI ĐÂY
                'rating' => '4.8/5.0',
            ],
            [
                'title' => 'Hoàng Tử Bé',
                'tag' => 'Văn Học Kinh Điển',
                'desc' => '"Người ta chỉ nhìn thấy thật rõ ràng bằng trái tim. Cái cốt yếu thì mắt thường không thấy được."',
                'image' => 'https://product.hstatic.net/200000343865/product/hoang-tu-be---tb-2022_f0f2f9b813c246c4878e7e685f683d50_5b46a794d64c4996a6695f6e9e8d3213.jpg', // <--- THAY LINK ẢNH TẠI ĐÂY
                'rating' => '5.0/5.0',
            ]
        ];
    @endphp

    <!-- Section luôn giữ màu nền xanh rêu -->
    <section id="hero-carousel" class="relative text-white py-12 lg:py-16 overflow-hidden bg-[#2A483A] group">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/20 to-transparent pointer-events-none"></div>

        <!-- Slider Wrapper -->
        <div class="hero-slider-wrapper flex w-full" id="sliderWrapper">
            @foreach($heroSlides as $index => $slide)
                <div class="w-full flex-shrink-0 px-4 transition-all duration-700">
                    <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 justify-center">
                        <!-- Book Image -->
                        <div class="w-full md:w-5/12 flex justify-center md:justify-end perspective-1000">
                            <div class="relative w-48 h-72 md:w-56 md:h-80 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-r-lg rounded-l-sm transform rotate-y-12 hover:rotate-y-0 hover:scale-105 transition-all duration-700 cursor-pointer group/book">
                                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/book:opacity-20 transition-opacity z-20"></div>
                                <img src="{{ $slide['image'] }}" class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-white/10">
                                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-r from-white/30 to-transparent z-10"></div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="w-full md:w-7/12 text-center md:text-left space-y-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-xs font-bold uppercase tracking-widest text-brand-beige">{{ $slide['tag'] }}</span>
                            </div>
                            
                            <h1 class="text-3xl md:text-5xl font-bold leading-tight font-serif text-brand-beige drop-shadow-md">
                                {{ $slide['title'] }}
                            </h1>
                            
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                <div class="flex text-yellow-400 text-lg">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-white/80 text-sm font-medium px-2 py-0.5 bg-white/10 rounded">{{ $slide['rating'] }}</span>
                            </div>
                            
                            <p class="text-gray-200 text-lg font-light italic max-w-2xl leading-relaxed drop-shadow">
                                {{ $slide['desc'] }}
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-2">
                                <a href="#" class="inline-flex items-center justify-center gap-2 bg-brand-accent text-white font-bold px-6 py-3 rounded-full shadow-lg hover:bg-[#c29263] transition-all transform hover:-translate-y-1">
                                    <span>Đọc Review</span> <i class="fas fa-arrow-right text-sm"></i>
                                </a>
                                <a href="#" class="inline-flex items-center justify-center gap-2 bg-transparent border border-white/30 text-white font-bold px-6 py-3 rounded-full hover:bg-white/10 transition-all">
                                    <i class="fas fa-bookmark"></i> Lưu Đọc Sau
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20">
            <i class="fas fa-chevron-left text-xl"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20">
            <i class="fas fa-chevron-right text-xl"></i>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20">
            @foreach($heroSlides as $index => $slide)
                <button onclick="goToSlide({{ $index }})" class="indicator-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-all {{ $index === 0 ? 'bg-brand-accent w-8' : '' }}" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 py-12 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- CỘT TRÁI (Nội dung chính) -->
            <div class="lg:col-span-8 space-y-16">
                
                <!-- SECTION: GÓC NHÌN & SUY NGẪM -->
                <section>
                    <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-3">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 font-serif mb-1">Tạp Chí Đọc</h2>
                            <p class="text-sm text-gray-500">Góc nhìn sâu sắc về sách và cuộc sống</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-brand-green hover:text-white rounded-full text-xs font-bold transition">Kỹ Năng</a>
                            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-brand-green hover:text-white rounded-full text-xs font-bold transition">Tản Văn</a>
                            <a href="#" class="text-brand-green text-sm font-bold ml-2 flex items-center">Xem thêm <i class="fas fa-chevron-right text-xs ml-1"></i></a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <article class="md:col-span-3 group cursor-pointer">
                            <div class="relative h-64 md:h-80 rounded-2xl overflow-hidden mb-4 shadow-md">
                                <img src="https://images.unsplash.com/photo-1491841550275-ad7854e35ca6?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <span class="absolute top-4 left-4 bg-brand-accent text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Tiêu Điểm</span>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <div class="text-xs opacity-80 mb-2"><i class="far fa-calendar-alt mr-1"></i> 04/12/2025 • Bởi Minh Tâm</div>
                                    <h3 class="text-2xl font-bold font-serif leading-tight group-hover:text-brand-beige transition">5 Cuốn sách thay đổi hoàn toàn tư duy của bạn về sự thành công</h3>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
                                Thành công không phải là đích đến, mà là một hành trình. Những cuốn sách này sẽ giúp bạn định hình lại cách nhìn nhận thế giới...
                            </p>
                        </article>

                        <div class="md:col-span-2 flex flex-col gap-6">
                            <article class="flex flex-col group cursor-pointer">
                                <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
                                    <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                </div>
                                <div>
                                    <span class="text-brand-green text-xs font-bold uppercase">Mẹo Đọc</span>
                                    <h3 class="font-serif font-bold text-base text-gray-800 leading-snug group-hover:text-brand-green transition mt-1">
                                        Nghệ thuật đọc sách hiệu quả: Đọc ít hiểu nhiều
                                    </h3>
                                </div>
                            </article>

                            <article class="flex flex-col group cursor-pointer">
                                <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
                                    <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                </div>
                                <div>
                                    <span class="text-brand-green text-xs font-bold uppercase">Cảm Hứng</span>
                                    <h3 class="font-serif font-bold text-base text-gray-800 leading-snug group-hover:text-brand-green transition mt-1">
                                        Tại sao sách giấy vẫn có chỗ đứng trong kỷ nguyên số?
                                    </h3>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>

                <!-- SECTION: REVIEW SÁCH (Compact Grid) -->
                <section>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 font-serif border-l-4 border-brand-accent pl-3">Review Cộng Đồng</h2>
                        <div class="hidden sm:flex gap-2">
                            <button class="text-xs font-bold px-3 py-1 bg-brand-green text-white rounded-full">Mới nhất</button>
                            <button class="text-xs font-bold px-3 py-1 bg-gray-100 text-gray-500 hover:bg-gray-200 rounded-full transition">Đọc nhiều</button>
                            <button class="text-xs font-bold px-3 py-1 bg-gray-100 text-gray-500 hover:bg-gray-200 rounded-full transition">Điểm cao</button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @forelse($books as $book)
                            @php
                                $authorName = 'Ẩn danh';
                                if (is_object($book->author)) $authorName = $book->author->name ?? $authorName;
                                elseif (is_string($book->author)) {
                                    $trimmed = trim($book->author);
                                    $authorName = str_starts_with($trimmed, '{') ? (json_decode($trimmed)->name ?? $book->author) : $book->author;
                                }

                                $categoryName = 'Chưa phân loại';
                                if (isset($book->category)) {
                                    if (is_object($book->category)) $categoryName = $book->category->name ?? $categoryName;
                                    elseif (is_string($book->category)) {
                                        $trimmedCat = trim($book->category);
                                        $categoryName = str_starts_with($trimmedCat, '{') ? (json_decode($trimmedCat)->name ?? $book->category) : $book->category;
                                    }
                                }
                            @endphp

                            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-card transition-all duration-300 group flex flex-col h-full">
                                <div class="p-4 flex gap-4">
                                    <div class="w-24 h-36 flex-shrink-0 rounded-lg overflow-hidden shadow-md relative">
                                        <img src="{{ $book->image_url }}" alt="{{ $book->title }}" 
                                             class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110"
                                             onerror="this.src='https://via.placeholder.com/150x225?text=No+Image'">
                                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                                    </div>

                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start">
                                            <span class="text-[10px] font-bold uppercase text-brand-green bg-brand-green/10 px-2 py-0.5 rounded">{{ $categoryName }}</span>
                                            <div class="flex text-yellow-400 text-xs gap-0.5">
                                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                            </div>
                                        </div>

                                        <h3 class="font-serif font-bold text-lg text-gray-800 mt-2 mb-1 leading-tight group-hover:text-brand-accent transition cursor-pointer">
                                            <a href="{{ route('book.show', $book->id) }}">{{ $book->title }}</a>
                                        </h3>
                                        
                                        <p class="text-xs text-gray-500 mb-3">bởi <span class="font-semibold">{{ $authorName }}</span></p>
                                        
                                        <p class="text-xs text-gray-500 line-clamp-2 mb-3 flex-grow">
                                            {{ $book->description ?? 'Chưa có mô tả.' }}
                                        </p>

                                        <div class="flex items-center justify-between border-t border-gray-50 pt-2 mt-auto">
                                            <div class="flex items-center gap-1">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background=random&size=16" class="w-4 h-4 rounded-full">
                                                <span class="text-[10px] text-gray-400">{{ $book->created_at ? $book->created_at->format('d/m') : 'N/A' }}</span>
                                            </div>
                                            <a href="{{ route('book.show', $book->id) }}" class="text-xs font-bold text-brand-green hover:underline">Chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-10 text-center text-gray-500 bg-white rounded-xl border border-dashed">
                                Chưa có sách nào.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 flex justify-center">
                        <nav class="flex items-center gap-2">
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:border-brand-green hover:text-brand-green transition bg-white text-sm"><i class="fas fa-chevron-left"></i></a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg bg-brand-green text-white font-bold text-sm shadow-md">1</a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-brand-cream hover:border-brand-green hover:text-brand-green transition bg-white text-sm">2</a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-brand-cream hover:border-brand-green hover:text-brand-green transition bg-white text-sm">3</a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:border-brand-green hover:text-brand-green transition bg-white text-sm"><i class="fas fa-chevron-right"></i></a>
                        </nav>
                    </div>
                </section>

                <div class="bg-[#2A483A] rounded-xl p-8 relative overflow-hidden shadow-lg text-white">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <span class="text-brand-accent text-xs font-bold uppercase tracking-wider border border-brand-accent/30 px-2 py-1 rounded">Sự kiện</span>
                            <h3 class="text-2xl font-serif font-bold mt-2 mb-2">Thử Thách Đọc Sách 2025</h3>
                            <p class="text-white/80 text-sm font-light max-w-md">Hoàn thành 3 cuốn sách để nhận huy hiệu "Mọt Sách Cần Cù".</p>
                        </div>
                        <button class="bg-brand-accent hover:bg-[#c29263] text-white px-6 py-2.5 rounded-full font-bold shadow-lg transition text-sm whitespace-nowrap">Tham Gia Ngay</button>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (Sidebar) -->
            <div class="lg:col-span-4">
                <!-- WRAPPER STICKY: Gom cả 2 widget vào đây để cùng dính -->
                <div class="sticky top-24 space-y-8">
                    
                    <!-- Widget 1: Trending -->
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-soft">
                        <h3 class="font-serif font-bold text-lg text-gray-800 mb-5 flex items-center gap-2">
                            <span class="text-brand-accent">🔥</span> Top Thịnh Hành
                        </h3>
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach(['Cây Cam Ngọt Của Tôi', 'Dế Mèn Phiêu Lưu Ký', 'Hoàng Tử Bé', 'Nhà Giả Kim', 'Mắt Biếc'] as $index => $title)
                            <a href="#" class="group flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition">
                                <div class="relative flex-shrink-0">
                                    <span class="absolute -top-1.5 -left-1.5 w-5 h-5 flex items-center justify-center rounded-full text-[10px] font-bold shadow-sm z-10 {{ $index < 3 ? 'bg-brand-accent text-white' : 'bg-gray-200 text-gray-600' }}">{{ $index + 1 }}</span>
                                    <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden shadow-sm">
                                        <img src="https://source.unsplash.com/random/200x300?book,sig={{ $index }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition">{{ $title }}</h4>
                                    <div class="text-[10px] text-yellow-400 mt-1">★★★★★ (4.9)</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Widget 2: Categories -->
                    <div class="bg-brand-beige/30 rounded-xl p-6 border border-brand-beige">
                        <h3 class="font-serif font-bold text-lg text-brand-green mb-4">Thể Loại</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Tiểu Thuyết', 'Kinh Tế', 'Tâm Lý', 'Trinh Thám', 'Lịch Sử', 'Khoa Học', 'Thiếu Nhi'] as $tag)
                                <a href="#" class="bg-white text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-100 hover:border-brand-accent hover:text-brand-accent transition shadow-sm">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <!-- [UPDATED] Footer với đường lượn sóng và Logo Mới -->
    <div class="relative mt-20">
        <!-- SVG Wave Divider -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none z-10 transform -translate-y-full">
            <svg class="relative block w-full h-12 md:h-16 text-[#1F352B]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>

        <footer class="bg-[#1F352B] text-white pt-10 pb-12 relative overflow-hidden">
            <!-- Decorative Background Pattern -->
            <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            
            <!-- Glow Effect -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-green-light/20 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-accent/10 rounded-full blur-[80px] -ml-10 -mb-10 pointer-events-none"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                    
                    <!-- Column 1: Brand Info -->
                    <div class="col-span-1 md:col-span-1 space-y-5">
                        <div class="flex items-center gap-3">
                            <!-- Footer Logo -->
                            <div class="w-10 h-10 bg-brand-accent text-brand-green rounded-lg flex items-center justify-center shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-serif font-bold text-xl tracking-wide text-brand-beige">GÓC SÁCH</span>
                                <span class="text-[10px] text-white/50 uppercase tracking-widest">Review & Share</span>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Nơi kết nối những tâm hồn yêu sách. Chia sẻ cảm nhận, lan tỏa tri thức và tìm kiếm cuốn sách thay đổi cuộc đời bạn.
                        </p>
                        <div class="flex gap-4 pt-2">
                            <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-facebook-f text-sm"></i></a>
                            <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-twitter text-sm"></i></a>
                            <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-instagram text-sm"></i></a>
                            <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-tiktok text-sm"></i></a>
                        </div>
                    </div>
                    
                    <!-- Column 2: Quick Links -->
                    <div>
                        <h4 class="font-bold mb-6 text-brand-beige uppercase tracking-wide text-xs">Khám Phá</h4>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Sách Mới Phát Hành</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Top Review Tháng</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Tác Giả Nổi Bật</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Thử Thách Đọc</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Blog Văn Học</a></li>
                        </ul>
                    </div>
                    
                    <!-- Column 3: Support -->
                    <div>
                        <h4 class="font-bold mb-6 text-brand-beige uppercase tracking-wide text-xs">Hỗ Trợ</h4>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Về Chúng Tôi</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Điều Khoản Sử Dụng</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Chính Sách Bảo Mật</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Câu Hỏi Thường Gặp</a></li>
                            <li><a href="#" class="hover:text-brand-accent hover:pl-2 transition-all duration-300">Liên Hệ</a></li>
                        </ul>
                    </div>
                    
                    <!-- Column 4: Newsletter -->
                    <div>
                        <h4 class="font-bold mb-6 text-brand-beige uppercase tracking-wide text-xs">Đăng Ký Nhận Tin</h4>
                        <p class="text-xs text-gray-400 mb-4 leading-relaxed">Nhận thông báo về sách mới, sự kiện offline và các bài viết hay hàng tuần.</p>
                        <form onsubmit="event.preventDefault();" class="relative group">
                            <input type="email" placeholder="Email của bạn..." class="w-full pl-4 pr-12 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-brand-accent/50 focus:bg-white/10 text-sm text-white placeholder-gray-500 transition-all">
                            <button class="absolute right-1 top-1 bg-brand-accent hover:bg-[#c29263] text-white w-10 h-10 rounded-md transition flex items-center justify-center shadow-lg group-hover:scale-105">
                                <i class="fas fa-paper-plane text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                    <p>&copy; 2025 Mọt Sách Review. Được thiết kế với <i class="fas fa-heart text-red-500 mx-1"></i> và niềm đam mê sách.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                        <a href="#" class="hover:text-white transition">Cookie Settings</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- SCRIPT FOR HERO SLIDER -->
    <script>
        let currentSlide = 0;
        const totalSlides = {{ count($heroSlides) }};
        const sliderWrapper = document.getElementById('sliderWrapper');
        const dots = document.querySelectorAll('.indicator-dot');
        const container = document.getElementById('hero-carousel');
        
        // REMOVED: color logic to keep background static green
        // const colors = ... 

        function updateSlider() {
            // Move slider wrapper
            sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update dots
            dots.forEach((dot, index) => {
                if (index === currentSlide) {
                    dot.classList.add('bg-brand-accent', 'w-8');
                    dot.classList.remove('bg-white/30');
                } else {
                    dot.classList.remove('bg-brand-accent', 'w-8');
                    dot.classList.add('bg-white/30');
                }
            });

            // REMOVED: Background Color changing logic
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlider();
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Mobile Menu Toggle Script
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu'); // Make sure this element exists if you uncommented it

        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                // Logic to toggle mobile menu visibility would go here
                // For now, since the HTML for mobile-menu is hidden/commented out in header, 
                // you would need to add the mobile menu HTML block back to make this functional.
                alert('Tính năng menu mobile sẽ được cập nhật!');
            });
        }
    </script>

</body>
</html>