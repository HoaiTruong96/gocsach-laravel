<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất Cả Sách - Góc Sách</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#3E5F4E',
                        'brand-cream': '#FDFBF7',
                        'brand-beige': '#F3E5D0',
                        'brand-brown': '#8C6B4B',
                        'brand-accent': '#D4A373',
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
        body { background-color: #FDFBF7; color: #2C3E36; }
        .custom-checkbox:checked {
            background-color: #3E5F4E;
            border-color: #3E5F4E;
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
            
            <nav class="flex items-center space-x-6 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang Chủ</a>
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:text-red-800 font-bold border border-red-100 bg-red-50 px-3 py-1 rounded-full transition">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                @endif

                <a href="{{ route('list') }}" class="text-brand-green font-bold border-b-2 border-brand-green pb-1">Danh Sách</a>
                <a href="#" class="hover:text-brand-green transition">Bài Viết</a>

                @auth
                    <div class="relative group z-50">
                        <button class="flex items-center gap-2 text-brand-green font-bold focus:outline-none hover:opacity-80 transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3E5F4E&color=fff" class="w-8 h-8 rounded-full border border-brand-green shadow-sm">
                            <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 hidden group-hover:block py-2 animate-fade-in">
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

    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-brand-green">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Danh Sách Sách</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <aside class="lg:col-span-3 space-y-8">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">Thể Loại</h3>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" checked class="custom-checkbox w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
                            <span class="text-gray-600 group-hover:text-brand-green transition text-sm">Văn Học <span class="text-xs text-gray-400">(120)</span></span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" class="custom-checkbox w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
                            <span class="text-gray-600 group-hover:text-brand-green transition text-sm">Kinh Tế <span class="text-xs text-gray-400">(45)</span></span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" class="custom-checkbox w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
                            <span class="text-gray-600 group-hover:text-brand-green transition text-sm">Tâm Lý & Kỹ Năng <span class="text-xs text-gray-400">(32)</span></span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" class="custom-checkbox w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
                            <span class="text-gray-600 group-hover:text-brand-green transition text-sm">Trinh Thám <span class="text-xs text-gray-400">(18)</span></span>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">Đánh Giá</h3>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="rating" class="text-brand-green focus:ring-brand-green">
                            <div class="text-yellow-400 text-xs">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="rating" class="text-brand-green focus:ring-brand-green">
                            <div class="flex items-center text-xs">
                                <div class="text-yellow-400">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="text-gray-500 ml-1">Trở lên</span>
                            </div>
                        </label>
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-9">
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2 sm:mb-0">
                        Hiển thị <span class="font-bold text-brand-green">1-12</span> của 86 kết quả
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Sắp xếp:</span>
                        <select class="bg-[#FDFBF7] border border-gray-200 text-sm rounded-md px-3 py-1.5 text-gray-700 focus:outline-none focus:border-brand-green cursor-pointer">
                            <option>Mới nhất</option>
                            <option>Xem nhiều nhất</option>
                            <option>Đánh giá cao</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    
                    {{-- MOCK DATA --}}
                    @php
                        $books = [
                            [
                                'title' => 'Cây Cam Ngọt Của Tôi',
                                'author' => 'José Mauro',
                                'category' => 'Văn Học',
                                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400',
                                'rating' => 4.9,
                                'view' => '15k',
                                'hot' => true
                            ],
                            [
                                'title' => 'Dế Mèn Phiêu Lưu Ký',
                                'author' => 'Tô Hoài',
                                'category' => 'Thiếu Nhi',
                                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=400',
                                'rating' => 4.8,
                                'view' => '8.2k',
                                'hot' => false
                            ],
                            [
                                'title' => 'Mắt Biếc',
                                'author' => 'Nguyễn Nhật Ánh',
                                'category' => 'Tình Cảm',
                                'image' => 'https://images.unsplash.com/photo-1592496431122-2349e0fbc666?auto=format&fit=crop&q=80&w=400',
                                'rating' => 5.0,
                                'view' => '22k',
                                'hot' => true
                            ],
                            [
                                'title' => 'Tội Ác Và Trừng Phạt',
                                'author' => 'Dostoevsky',
                                'category' => 'Kinh Điển',
                                'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=400',
                                'rating' => 4.7,
                                'view' => '5k',
                                'hot' => false
                            ],
                            [
                                'title' => 'Nhà Giả Kim',
                                'author' => 'Paulo Coelho',
                                'category' => 'Kinh Tế',
                                'image' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=400',
                                'rating' => 4.8,
                                'view' => '40k',
                                'hot' => false
                            ],
                            [
                                'title' => 'Hoàng Tử Bé',
                                'author' => 'Saint-Exupéry',
                                'category' => 'Văn Học',
                                'image' => 'https://images.unsplash.com/photo-1629198688000-71f23e745b6e?auto=format&fit=crop&q=80&w=400',
                                'rating' => 4.9,
                                'view' => '100k',
                                'hot' => false
                            ],
                        ];
                    @endphp

                    @foreach($books as $book)
                        <div class="group bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col h-full relative">
                            <div class="relative w-full aspect-[2/3] bg-gray-100 overflow-hidden">
                                <a href="{{ route('detail') }}">
                                    <img src="{{ $book['image'] }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                </a>
                                
                                @if($book['hot'])
                                    <div class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                        HOT
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4 flex flex-col flex-1">
                                <div class="text-[10px] text-brand-accent uppercase font-bold tracking-wider mb-1">{{ $book['category'] }}</div>
                                
                                <h3 class="font-serif font-bold text-gray-800 text-lg leading-snug mb-1 line-clamp-2 group-hover:text-brand-green transition">
                                    <a href="{{ route('detail') }}">
                                        {{ $book['title'] }}
                                    </a>
                                </h3>
                                
                                <p class="text-xs text-gray-500 mb-3">{{ $book['author'] }}</p>
                                
                                <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                                    <div class="flex items-center text-yellow-400 gap-1">
                                        <i class="fas fa-star"></i> 
                                        <span class="text-gray-600 font-semibold">{{ $book['rating'] }}</span>
                                    </div>
                                    <div class="text-gray-400 flex items-center gap-1">
                                        <i class="far fa-eye"></i> {{ $book['view'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="mt-12 flex justify-center">
                    <nav class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-400 hover:text-brand-green transition">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-brand-green text-white font-bold text-sm shadow-md">1</a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-600 hover:text-brand-green transition text-sm font-medium">2</a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-600 hover:text-brand-green transition text-sm font-medium">3</a>
                        <span class="w-8 h-8 flex items-center justify-center text-gray-400 text-xs pb-2">...</span>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-600 hover:text-brand-green transition text-sm font-medium">8</a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-500 hover:text-brand-green transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </nav>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-[#2C3E36] text-white pt-16 pb-8 relative overflow-hidden mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="space-y-4">
                    <div class="flex flex-col items-start">
                        <div class="mb-2">
                            <i class="fas fa-book-open text-4xl text-[#E9EDC9]"></i>
                        </div>
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
                        <input type="email" placeholder="Email..." class="w-full px-4 py-2 text-gray-800 rounded-l text-sm focus:outline-none">
                        <button class="bg-[#8C6B4B] hover:bg-[#6e5338] text-white font-bold px-4 py-2 rounded-r text-sm transition">Đăng Ký</button>
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