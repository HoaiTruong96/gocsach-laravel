<!-- TOP BAR: Thông tin liên hệ & Social -->
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

<!-- HEADER MAIN -->
<header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-300">
    <div class="container mx-auto px-4 py-3">
        <div class="flex flex-wrap justify-between items-center gap-4">
            
            <!-- 1. Logo & Mobile Toggle -->
            <div class="flex items-center gap-4">
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

            <!-- 2. Search Bar -->
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

            <!-- 3. Right Actions -->
            <div class="flex items-center gap-3 md:gap-5">
                @auth
                    <!-- Logged In View -->
                    <div class="relative hidden sm:block">
                        <button class="text-gray-500 hover:text-brand-green transition relative">
                            <i class="far fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                    </div>
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
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-card border border-gray-100 hidden group-hover:block py-2 animate-fade-in origin-top-right before:content-[''] before:absolute before:-top-3 before:w-full before:h-4 before:left-0 before:bg-transparent">
                            <!-- Dropdown content here (Keep your existing dropdown code) -->
                            <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50 rounded-t-xl">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Xin chào</p>
                                <p class="text-sm font-bold text-brand-green truncate">{{ Auth::user()->name }}</p>
                            </div>
                            @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-red-600 bg-red-50 hover:bg-red-100 transition font-bold">
                            <i class="fas fa-tachometer-alt w-5 mr-2"></i> Trang Quản Trị
                            </a><div class="border-t border-gray-100 my-1"></div>
                            @endif
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-brand-cream hover:text-brand-green transition">
                                <i class="fas fa-user-circle w-5 mr-2"></i> Hồ sơ cá nhân
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
                    <!-- Guest View -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green font-bold text-sm px-3 py-2 rounded-lg hover:bg-gray-100 transition hidden sm:block">Đăng Nhập</a>
                        <a href="{{ route('register') }}" class="bg-brand-green text-white px-5 py-2.5 rounded-full hover:bg-brand-green-light hover:shadow-lg transition transform hover:-translate-y-0.5 font-bold shadow-md text-sm flex items-center gap-2">
                            <i class="fas fa-user-plus text-xs"></i> <span>Đăng Ký</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- 4. Navigation Links -->
        <div class="hidden md:flex justify-center mt-2 border-t border-gray-100 pt-3">
                <nav class="flex items-center gap-8 text-sm font-semibold text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all">Trang Chủ</a>
                    
                    <a href="{{ route('list') }}" class="text-brand-green border-b-2 border-brand-green pb-3 -mb-3.5 transition-colors">Danh Sách</a>
                    
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
</header>