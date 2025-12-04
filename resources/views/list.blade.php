<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất Cả Sách - Góc Sách</title>

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
        .custom-checkbox:checked {
            background-color: #2A483A;
            border-color: #2A483A;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen selection:bg-brand-green selection:text-white">

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

    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-wrap justify-between items-center gap-4">
                
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-600 hover:text-brand-green focus:outline-none">
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

                <div class="hidden md:flex flex-1 max-w-2xl px-8">
                    <div class="relative w-full group flex items-center">
                        <div class="absolute left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-xs font-bold bg-gray-100 px-2 py-1 rounded">Tất cả</span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400 ml-1"></i>
                        </div>
                        <input type="text" placeholder="Tìm kiếm sách, tác giả..."
                            class="w-full bg-gray-50 border border-gray-200 group-hover:border-brand-green/30 rounded-full py-2.5 pl-24 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/20 focus:bg-white transition-all text-gray-700 placeholder-gray-400 shadow-inner">
                        <button class="absolute right-2 top-1.5 w-8 h-8 bg-brand-green text-white rounded-full flex items-center justify-center hover:bg-brand-accent transition shadow-md">
                            <i class="fas fa-search text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3 md:gap-5">
                    @auth
                        <div class="relative hidden sm:block">
                            <button class="text-gray-500 hover:text-brand-green transition relative">
                                <i class="far fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                        </div>

                        <div class="relative hidden sm:block">
                            <button class="text-gray-500 hover:text-brand-green transition" title="Tủ sách đã lưu">
                                <i class="far fa-bookmark text-xl"></i>
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
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green font-bold text-sm px-3 py-2 rounded-lg hover:bg-gray-100 transition hidden sm:block">Đăng Nhập</a>
                            <a href="{{ route('register') }}" class="bg-brand-green text-white px-5 py-2.5 rounded-full hover:bg-brand-green-light hover:shadow-lg transition transform hover:-translate-y-0.5 font-bold shadow-md text-sm flex items-center gap-2">
                                <i class="fas fa-user-plus text-xs"></i> <span>Đăng Ký</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

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

    <div class="bg-brand-beige/40 py-4 border-b border-brand-beige/50">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Danh Sách Sách</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <aside class="lg:col-span-3 space-y-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">Thể Loại</h3>
                    <div class="space-y-3">
                        @foreach(['Văn Học (120)', 'Kinh Tế (45)', 'Tâm Lý & Kỹ Năng (32)', 'Trinh Thám (18)', 'Thiếu Nhi (10)'] as $cat)
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" class="custom-checkbox w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green">
                            <span class="text-gray-600 group-hover:text-brand-green transition text-sm font-medium">{{ $cat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">Đánh Giá</h3>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="rating" class="text-brand-green focus:ring-brand-green">
                            <div class="text-yellow-400 text-xs flex gap-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="rating" class="text-brand-green focus:ring-brand-green">
                            <div class="flex items-center text-xs">
                                <div class="text-yellow-400 flex gap-1">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="text-gray-500 ml-2 font-medium group-hover:text-brand-green">Trở lên</span>
                            </div>
                        </label>
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-9">
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-soft border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-2 sm:mb-0">
                        @if(isset($books) && count($books) > 0)
                            Hiển thị <span class="font-bold text-brand-green">{{ count($books) }}</span> kết quả
                        @else
                            Chưa có sách nào
                        @endif
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 font-medium">Sắp xếp:</span>
                        <select class="bg-gray-50 border border-gray-200 text-sm rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:border-brand-green cursor-pointer hover:bg-white transition">
                            <option>Mới nhất</option>
                            <option>Xem nhiều nhất</option>
                            <option>Đánh giá cao</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @if(isset($books) && count($books) > 0)
                        @foreach($books as $book)
                            @php
                                $authorName = 'Tác giả ẩn danh';
                                if (is_object($book->author)) {
                                    $authorName = $book->author->name ?? $authorName;
                                } elseif (is_string($book->author)) {
                                    // Logic xử lý nếu author lưu dạng JSON string (như file Home)
                                    $trimmed = trim($book->author);
                                    if (str_starts_with($trimmed, '{')) {
                                        $decoded = json_decode($trimmed);
                                        $authorName = $decoded->name ?? $book->author;
                                    } else {
                                        $authorName = $book->author;
                                    }
                                }
                                
                                // Xử lý Category
                                $catName = 'Mặc định';
                                if(isset($book->category)){
                                     if (is_object($book->category)) {
                                        $catName = $book->category->name ?? $catName;
                                    } elseif (is_string($book->category) && str_starts_with(trim($book->category), '{')) {
                                        $decodedCat = json_decode($book->category);
                                        $catName = $decodedCat->name ?? $book->category;
                                    } else {
                                        $catName = $book->category;
                                    }
                                }
                            @endphp

                            <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                                <div class="relative w-full aspect-[2/3] bg-gray-100 overflow-hidden">
                                    <a href="{{ route('detail', $book->id) }}">
                                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                                             alt="{{ $book->title }}"
                                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                    </a>
                                    
                                    @if($book->view_count > 1000)
                                        <div class="absolute top-3 left-3 bg-red-500/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md">
                                            HOT
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-4 flex flex-col flex-1">
                                    <div class="text-[10px] text-brand-accent uppercase font-bold tracking-wider mb-1.5">
                                        {{ $catName }}
                                    </div>
                                    
                                    <h3 class="font-serif font-bold text-gray-800 text-lg leading-snug mb-1 line-clamp-2 group-hover:text-brand-green transition">
                                        <a href="{{ route('detail', $book->id) }}">
                                            {{ $book->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 mb-3 font-medium">
                                        {{ $authorName }}
                                    </p>
                                    
                                    <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                        <div class="flex items-center text-yellow-400 gap-1">
                                            <i class="fas fa-star"></i> 
                                            <span class="text-gray-600 font-bold">5.0</span>
                                        </div>
                                        <div class="text-gray-400 flex items-center gap-1">
                                            <i class="far fa-eye"></i> {{ number_format($book->view_count) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-book text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Chưa có cuốn sách nào trong hệ thống.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-12 flex justify-center">
                    <nav class="flex items-center gap-2 bg-white px-2 py-2 rounded-full shadow-soft border border-gray-100">
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-400 hover:text-brand-green transition">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-brand-green text-white font-bold text-sm shadow-md">1</a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-600 hover:text-brand-green transition text-sm font-bold">2</a>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-600 hover:text-brand-green transition text-sm font-bold">3</a>
                        <span class="w-9 h-9 flex items-center justify-center text-gray-400 text-xs pb-1">...</span>
                        <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-brand-beige text-gray-500 hover:text-brand-green transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </nav>
                </div>

            </div>
        </div>
    </main>

    <div class="relative mt-20">
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none z-10 transform -translate-y-full">
            <svg class="relative block w-full h-12 md:h-16 text-[#1F352B]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>

        <footer class="bg-[#1F352B] text-white pt-10 pb-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-green-light/20 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-accent/10 rounded-full blur-[80px] -ml-10 -mb-10 pointer-events-none"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                    
                    <div class="col-span-1 md:col-span-1 space-y-5">
                        <div class="flex items-center gap-3">
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
                    
                    <div>
                        <h4 class="font-bold mb-6 text-brand-beige uppercase tracking-wide text-xs">Đăng Ký Nhận Tin</h4>
                        <p class="text-xs text-gray-400 mb-4 leading-relaxed">Nhận thông báo về sách mới hàng tuần.</p>
                        <form onsubmit="event.preventDefault();" class="relative group">
                            <input type="email" placeholder="Email của bạn..." class="w-full pl-4 pr-12 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-brand-accent/50 focus:bg-white/10 text-sm text-white placeholder-gray-500 transition-all">
                            <button class="absolute right-1 top-1 bg-brand-accent hover:bg-[#c29263] text-white w-10 h-10 rounded-md transition flex items-center justify-center shadow-lg group-hover:scale-105">
                                <i class="fas fa-paper-plane text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                    <p>&copy; 2025 Mọt Sách Review. All rights reserved.</p>
                    <div class="flex gap-6 mt-4 md:mt-0">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                        <a href="#" class="hover:text-white transition">Cookie Settings</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>