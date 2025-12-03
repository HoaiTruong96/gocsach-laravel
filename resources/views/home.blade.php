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

            <!-- NAV MENU CHÍNH -->
            <nav class="flex items-center space-x-6 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="text-brand-green font-bold border-b-2 border-brand-green pb-1">Trang Chủ</a>
                <a href="#" class="hover:text-brand-green transition">Thể Loại</a>
                <a href="#" class="hover:text-brand-green transition">Bài Viết</a>

                <!-- LOGIC AUTHENTICATION -->
                @auth
                <!-- Khi ĐÃ Đăng nhập -->
                <div class="relative group z-50">
                    <button class="flex items-center gap-2 text-brand-green font-bold focus:outline-none hover:opacity-80 transition">
                        <!-- Avatar tự động tạo theo tên -->
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=3E5F4E&color=fff" class="w-8 h-8 rounded-full border border-brand-green shadow-sm">
                        <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 hidden group-hover:block py-2 animate-fade-in">
                        <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-400">
                            Xin chào, {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-brand-beige hover:text-brand-green transition">
                            <i class="fas fa-user mr-2"></i> Hồ sơ cá nhân
                        </a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-brand-beige hover:text-brand-green transition">
                            <i class="fas fa-bookmark mr-2"></i> Tủ sách của tôi
                        </a>

                        <!-- [MỚI] Link Đổi mật khẩu -->
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
                @else
                <!-- Khi CHƯA Đăng nhập -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green transition">Đăng Nhập</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('register') }}" class="text-brand-green font-bold hover:underline decoration-2 underline-offset-4">Đăng Ký</a>
                </div>
                @endauth

            </nav>
        </div>
    </header>

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

    <main class="container mx-auto px-4 py-12 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <div class="lg:col-span-8 space-y-12">
                <section>
                    <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-2">
                        <h2 class="text-2xl font-bold text-brand-green font-serif">Review Mới Nhất</h2>
                        <a href="#" class="text-brand-green text-sm font-semibold hover:underline mb-1">Xem tất cả ></a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex gap-4 h-48">
                            <div class="w-28 flex-shrink-0 overflow-hidden rounded shadow-sm">
                                <img src="https://images.unsplash.com/photo-1592496431122-2349e0fbc666?auto=format&fit=crop&q=80&w=300" class="w-full h-full object-cover">
                            </div>
                            <div class="flex flex-col flex-1">
                                <h3 class="font-bold text-gray-800 line-clamp-2 mb-1 hover:text-brand-green transition text-lg font-serif">Mắt Biếc</h3>
                                <div class="flex text-yellow-400 text-xs mb-2">★★★★★</div>
                                <div class="flex items-center gap-2 mb-2">
                                    <img src="https://ui-avatars.com/api/?name=User+One" class="w-5 h-5 rounded-full">
                                    <span class="text-xs text-gray-500">Ngạn Si Tình</span>
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-2 mt-auto">Chuyện tình đơn phương buồn nhất của Nguyễn Nhật Ánh...</p>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex gap-4 h-48">
                            <div class="w-28 flex-shrink-0 overflow-hidden rounded shadow-sm">
                                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=300" class="w-full h-full object-cover">
                            </div>
                            <div class="flex flex-col flex-1">
                                <h3 class="font-bold text-gray-800 line-clamp-2 mb-1 hover:text-brand-green transition text-lg font-serif">Dế Mèn Phiêu Lưu Ký</h3>
                                <div class="flex text-yellow-400 text-xs mb-2">★★★★☆</div>
                                <div class="flex items-center gap-2 mb-2">
                                    <img src="https://ui-avatars.com/api/?name=To+Hoai" class="w-5 h-5 rounded-full">
                                    <span class="text-xs text-gray-500">Dế Mèn</span>
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-2 mt-auto">Bài học đường đời đầu tiên...</p>
                            </div>
                        </div>
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

                <section>
                    <h2 class="text-2xl font-bold text-brand-green mb-6 font-serif">Tác Giả Nổi Bật</h2>
                    <div class="flex gap-8 overflow-x-auto pb-4 scrollbar-hide">
                        <div class="flex flex-col items-center min-w-[90px] cursor-pointer group">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200 group-hover:border-brand-green transition mb-2">
                                <img src="https://ui-avatars.com/api/?name=Nguyen+Nhat+Anh&size=150" class="w-full h-full object-cover">
                            </div>
                            <span class="text-sm font-bold text-center text-gray-700">Nguyễn Nhật Ánh</span>
                        </div>
                        <div class="flex flex-col items-center min-w-[90px] cursor-pointer group">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200 group-hover:border-brand-green transition mb-2">
                                <img src="https://ui-avatars.com/api/?name=J+K+Rowling&size=150" class="w-full h-full object-cover">
                            </div>
                            <span class="text-sm font-bold text-center text-gray-700">J.K. Rowling</span>
                        </div>
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

            <div class="lg:col-span-4">
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100 font-serif border-l-4 border-brand-green pl-3">
                        Top Thịnh Hành
                    </h3>

                    <div class="space-y-6">
                        <div class="flex gap-4 items-start group cursor-pointer">
                            <div class="text-3xl font-bold text-[#EBE5D9] group-hover:text-brand-accent transition w-8 text-center leading-none font-serif">01</div>
                            <div class="w-12 h-16 flex-shrink-0 bg-gray-200 rounded overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=200" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition">Cây Cam Ngọt Của Tôi</h4>
                                <p class="text-xs text-gray-500 mb-1">José Mauro</p>
                                <div class="text-[10px] text-yellow-400">★★★★★ 4.9</div>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start group cursor-pointer">
                            <div class="text-3xl font-bold text-[#EBE5D9] group-hover:text-brand-accent transition w-8 text-center leading-none font-serif">02</div>
                            <div class="w-12 h-16 flex-shrink-0 bg-gray-200 rounded overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=200" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition">Dế Mèn Phiêu Lưu Ký</h4>
                                <p class="text-xs text-gray-500 mb-1">Tô Hoài</p>
                                <div class="text-[10px] text-yellow-400">★★★★☆ 4.8</div>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start group cursor-pointer">
                            <div class="text-3xl font-bold text-[#EBE5D9] group-hover:text-brand-accent transition w-8 text-center leading-none font-serif">03</div>
                            <div class="w-12 h-16 flex-shrink-0 bg-gray-200 rounded overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1629198688000-71f23e745b6e?auto=format&fit=crop&q=80&w=200" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition">Hoàng Tử Bé</h4>
                                <p class="text-xs text-gray-500 mb-1">Saint-Exupéry</p>
                                <div class="text-[10px] text-yellow-400">★★★★★ 4.9</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-[#2C3E36] text-white pt-16 pb-8 relative overflow-hidden">
        <div class="container mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">

                <div class="space-y-4">
                    <div class="flex flex-col items-start">
                        <div class="mb-2">
                            <i class="fas fa-book-open text-4xl text-[#E9EDC9]"></i>
                        </div>
                        <h3 class="font-bold text-lg leading-tight">
                            Mọt Sách Review - <br>
                            Kết nối tri thức
                        </h3>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Liên Kết Nhanh</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-[#D4A373] transition">Về chúng tôi</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Điều khoản</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Thể Loại</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-[#D4A373] transition">Danh sách</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Tiểu thuyết</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Kinh tế</a></li>
                        <li><a href="#" class="hover:text-[#D4A373] transition">Trinh thám</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Đăng Ký Nhận Tin</h4>

                    <form onsubmit="event.preventDefault();" class="flex mb-6">
                        <input type="email" placeholder="Email..."
                            class="w-full px-4 py-2 text-gray-800 rounded-l focus:outline-none text-sm">
                        <button class="bg-[#8C6B4B] hover:bg-[#6e5338] text-white font-bold px-4 py-2 rounded-r transition text-sm whitespace-nowrap">
                            Đăng Ký
                        </button>
                    </form>

                    <div class="flex gap-3">
                        <a href="#" class="w-8 h-8 bg-[#E9EDC9] text-[#2C3E36] rounded-full flex items-center justify-center hover:bg-white transition">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-[#E9EDC9] text-[#2C3E36] rounded-full flex items-center justify-center hover:bg-white transition">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-[#E9EDC9] text-[#2C3E36] rounded-full flex items-center justify-center hover:bg-white transition">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-[#E9EDC9] text-[#2C3E36] rounded-full flex items-center justify-center hover:bg-white transition">
                            <i class="fab fa-youtube text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-600 pt-8 text-center text-xs text-gray-400">
                Copyright © 2025 Mọt Sách Review
            </div>
        </div>

        <div class="absolute bottom-0 right-0 text-gray-500 opacity-20 transform translate-y-1/4 translate-x-1/4">
            <svg width="150" height="150" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" />
            </svg>
        </div>
    </footer>

</body>

</html>