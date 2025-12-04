<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Góc Sách - Khám Phá Tri Thức</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300&family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2A483A', // Xanh rêu đậm hơn chút cho sang
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
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Tùy chỉnh thanh cuộn cho danh sách thịnh hành */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #E5E7EB; /* Màu xám nhạt mặc định */
            border-radius: 20px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: #3E5F4E; /* Hover vào khung thì thanh cuộn đậm lên */
        }
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen selection:bg-brand-green selection:text-white">

    <!-- HEADER -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-brand-green text-2xl font-bold flex items-center gap-2 group">
                    <span class="text-3xl transform group-hover:rotate-12 transition-transform duration-300">📚</span>
                    <span class="font-serif tracking-tight">GÓC SÁCH</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 mx-8 max-w-xl">
                <div class="relative w-full group">
                    <input type="text" placeholder="Tìm kiếm sách, tác giả, thể loại..."
                        class="w-full bg-gray-50 border border-transparent group-hover:border-brand-green/30 rounded-full py-2.5 px-6 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/20 focus:bg-white transition-all text-gray-700 placeholder-gray-400 shadow-inner">
                    <button class="absolute right-4 top-2.5 text-gray-400 hover:text-brand-green transition-colors">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center gap-6 text-sm font-semibold text-gray-600">
                <a href="{{ route('home') }}" class="text-brand-green border-b-2 border-brand-green pb-0.5">Trang Chủ</a>
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1 text-red-600 bg-red-50 px-3 py-1.5 rounded-full hover:bg-red-100 transition">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                @endif

                <a href="{{ route('list') }}" class="hover:text-brand-green transition-colors relative group">
                    Danh Sách
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-green transition-all duration-300 group-hover:w-full"></span>
                </a>

                @auth
                    <div class="relative group z-50">
                        <button class="flex items-center gap-2 text-brand-green font-bold focus:outline-none hover:opacity-80 transition py-1">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3E5F4E&color=fff&size=32" 
                                 class="w-8 h-8 rounded-full border-2 border-brand-beige shadow-sm">
                            <span class="max-w-[100px] truncate hidden lg:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-card border border-gray-100 hidden group-hover:block py-2 animate-fade-in origin-top-right">
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Tài khoản</p>
                                <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            </div>
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-brand-cream hover:text-brand-green transition">
                                <i class="fas fa-user-circle w-5 mr-2"></i> Hồ sơ cá nhân
                            </a>
                            <a href="{{ route('change.password') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-brand-cream hover:text-brand-green transition">
                                <i class="fas fa-key w-5 mr-2"></i> Đổi mật khẩu
                            </a>
                            <div class="border-t border-gray-50 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-red-600 hover:bg-red-50 transition font-medium">
                                    <i class="fas fa-sign-out-alt w-5 mr-2"></i> Đăng Xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-brand-green transition font-bold">Đăng Nhập</a>
                        <a href="{{ route('register') }}" class="bg-brand-green text-white px-5 py-2 rounded-full hover:bg-brand-green-light hover:shadow-lg transition transform hover:-translate-y-0.5 font-bold shadow-md">Đăng Ký</a>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <!-- BANNER HERO -->
    <section class="relative bg-[#2A483A] text-white py-16 lg:py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/20 to-transparent"></div>
        
        <div class="container mx-auto px-4 relative z-10 flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-5/12 flex justify-center md:justify-end perspective-1000">
                <div class="relative w-56 h-80 md:w-64 md:h-96 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-r-lg rounded-l-sm transform rotate-y-12 hover:rotate-y-0 hover:scale-105 transition-all duration-700 cursor-pointer group">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-20 transition-opacity z-20"></div>
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-white/10">
                    <!-- Book Spine Effect -->
                    <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-r from-white/30 to-transparent z-10"></div>
                </div>
            </div>
            
            <div class="w-full md:w-7/12 text-center md:text-left space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold uppercase tracking-widest text-brand-beige">Sách Của Tháng 12</span>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold leading-tight font-serif text-brand-beige">
                    Cây Cam Ngọt <br/> Của Tôi
                </h1>
                
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <div class="flex text-yellow-400 text-lg">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-white/80 text-sm font-medium px-2 py-0.5 bg-white/10 rounded">4.9/5.0</span>
                    <span class="text-white/60 text-sm">• Văn Học Kinh Điển</span>
                </div>
                
                <p class="text-gray-300 text-lg md:text-xl font-light italic max-w-2xl leading-relaxed">
                    "Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào của trí tưởng tượng..."
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-4">
                    <a href="#" class="inline-flex items-center justify-center gap-2 bg-brand-accent text-white font-bold px-8 py-3.5 rounded-full shadow-lg hover:bg-[#c29263] hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <span>Đọc Review Ngay</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#" class="inline-flex items-center justify-center gap-2 bg-transparent border border-white/30 text-white font-bold px-8 py-3.5 rounded-full hover:bg-white/10 transition-all">
                        <i class="fas fa-bookmark"></i> Lưu Đọc Sau
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 py-16 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- LEFT COLUMN (Book List) -->
            <div class="lg:col-span-8 space-y-12">
                <section>
                    <div class="flex justify-between items-end mb-8">
                        <div class="relative">
                            <h2 class="text-3xl font-bold text-gray-800 font-serif z-10 relative">Review Mới Nhất</h2>
                            <div class="absolute bottom-1 left-0 w-full h-3 bg-brand-beige/60 -z-0"></div>
                        </div>
                        <a href="{{ route('list') }}" class="group flex items-center text-sm font-bold text-brand-green hover:text-brand-accent transition">
                            Xem tất cả 
                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($books as $book)
                            @php
                                // --- FIX LỖI JSON ---
                                $authorName = 'Tác giả ẩn danh';
                                $categoryName = 'Chưa phân loại';

                                // Xử lý Author
                                if (is_object($book->author)) {
                                    $authorName = $book->author->name ?? $authorName;
                                } elseif (is_string($book->author)) {
                                    $trimmed = trim($book->author);
                                    if (str_starts_with($trimmed, '{')) {
                                        $decoded = json_decode($trimmed);
                                        $authorName = $decoded->name ?? $book->author;
                                    } else {
                                        $authorName = $book->author;
                                    }
                                }

                                // Xử lý Category (Nếu có)
                                if (isset($book->category)) {
                                    if (is_object($book->category)) {
                                        $categoryName = $book->category->name ?? $categoryName;
                                    } elseif (is_string($book->category) && str_starts_with(trim($book->category), '{')) {
                                        $decodedCat = json_decode($book->category);
                                        $categoryName = $decodedCat->name ?? $book->category;
                                    } else {
                                        $categoryName = $book->category;
                                    }
                                }
                            @endphp

                            <!-- Horizontal Card Style -->
                            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-card transition-all duration-300 group flex flex-col sm:flex-row gap-6 relative overflow-hidden">
                                <!-- Decoration -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-green/5 rounded-full blur-3xl -z-0 group-hover:bg-brand-accent/10 transition-colors"></div>

                                <!-- Image -->
                                <div class="w-full sm:w-36 h-56 sm:h-auto flex-shrink-0 relative rounded-lg overflow-hidden shadow-md">
                                    <img src="{{ $book->image_url }}" alt="{{ $book->title }}" 
                                         class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110"
                                         onerror="this.src='https://via.placeholder.com/300x450?text=Book+Cover'">
                                    
                                    <!-- Overlay gradient on hover -->
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="{{ route('book.show', $book->id) }}" class="bg-white text-brand-green rounded-full p-3 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex flex-col flex-1 z-10">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-brand-beige text-brand-brown text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                                            {{ $categoryName }}
                                        </span>
                                        <span class="text-xs text-gray-400">• {{ $book->created_at ? $book->created_at->diffForHumans() : 'Vừa xong' }}</span>
                                    </div>

                                    <h3 class="font-serif font-bold text-xl text-gray-800 mb-2 leading-tight group-hover:text-brand-green transition-colors">
                                        <a href="{{ route('book.show', $book->id) }}">{{ $book->title }}</a>
                                    </h3>
                                    
                                    <div class="flex items-center gap-2 mb-4">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background=random&size=24" class="w-6 h-6 rounded-full border border-white shadow-sm">
                                        <span class="text-sm font-medium text-gray-600">Bởi <span class="text-gray-800 font-bold">{{ $authorName }}</span></span>
                                    </div>
                                    
                                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4 flex-grow">
                                        {{ $book->description ?? 'Chưa có mô tả chi tiết cho cuốn sách này. Hãy là người đầu tiên viết review để chia sẻ cảm nhận của bạn với cộng đồng!' }}
                                    </p>

                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span class="flex items-center gap-1 hover:text-brand-accent transition"><i class="far fa-heart"></i> 125</span>
                                            <span class="flex items-center gap-1 hover:text-brand-accent transition"><i class="far fa-comment"></i> 42</span>
                                        </div>
                                        <div class="flex text-yellow-400 text-sm">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white p-12 rounded-2xl text-center border-2 border-dashed border-gray-200">
                                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book-open text-3xl text-gray-300"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-700 mb-2">Chưa có bài viết nào</h3>
                                <p class="text-gray-500">Hãy quay lại sau hoặc đóng góp bài viết đầu tiên nhé!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-8">
                        @if(method_exists($books, 'links'))
                            {{ $books->links() }}
                        @endif
                    </div>
                </section>

                <!-- Featured Section (Middle) -->
                <div class="bg-gradient-to-r from-[#2A483A] to-[#3E5F4E] rounded-2xl p-8 md:p-12 relative overflow-hidden shadow-lg text-white">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-brand-accent/20 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="max-w-md">
                            <span class="inline-block py-1 px-3 rounded-full bg-brand-accent/20 text-brand-accent text-xs font-bold uppercase tracking-wider mb-3 border border-brand-accent/30">Sự kiện</span>
                            <h3 class="text-3xl font-serif font-bold mb-4">Thử Thách Đọc Sách Mùa Thu 2025</h3>
                            <p class="text-white/80 mb-6 font-light">Hoàn thành 3 cuốn sách trong tháng này để nhận huy hiệu "Mọt Sách Cần Cù" và cơ hội nhận quà tặng đặc biệt.</p>
                            <button class="bg-brand-accent hover:bg-[#c29263] text-white px-8 py-3 rounded-full font-bold shadow-lg transition transform hover:-translate-y-1">Tham Gia Ngay</button>
                        </div>
                        <div class="hidden md:block text-9xl text-white/10">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (Sidebar) -->
            <aside class="lg:col-span-4 space-y-8">
                <!-- Trending Widget -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-soft sticky top-24">
                    <h3 class="font-serif font-bold text-xl text-gray-800 mb-6 flex items-center gap-2">
                        <span class="text-brand-accent">🔥</span> Top Thịnh Hành
                    </h3>

                    <!-- Cập nhật class để cho phép cuộn nội dung -->
                    <div class="space-y-5 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach(['Cây Cam Ngọt Của Tôi', 'Dế Mèn Phiêu Lưu Ký', 'Hoàng Tử Bé', 'Nhà Giả Kim', 'Mắt Biếc', 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 'Harry Potter', 'Tuổi Trẻ Đáng Giá Bao Nhiêu'] as $index => $title)
                        <a href="#" class="group flex items-center gap-4 cursor-pointer p-2 rounded-xl hover:bg-gray-50 transition-all duration-300">
                            <div class="relative flex-shrink-0">
                                <span class="absolute -top-2 -left-2 w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-sm z-10
                                    {{ $index == 0 ? 'bg-yellow-400 text-white' : ($index == 1 ? 'bg-gray-400 text-white' : ($index == 2 ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-500')) }}">
                                    {{ $index + 1 }}
                                </span>
                                <div class="w-16 h-24 bg-gray-200 rounded-md overflow-hidden shadow-md group-hover:shadow-lg transition-all duration-300">
                                    <img src="https://source.unsplash.com/random/200x300?book,sig={{ $index }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-2 group-hover:text-brand-green transition-colors mb-1 leading-snug">{{ $title }}</h4>
                                <p class="text-xs text-gray-500 mb-2">Nhiều Tác Giả</p>
                                <div class="flex items-center gap-1 text-[10px]">
                                    <div class="flex text-yellow-400"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                    <span class="text-gray-400">(4.9)</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    
                    <button class="w-full mt-6 py-2.5 text-sm font-bold text-brand-green border border-brand-green/20 rounded-full hover:bg-brand-green hover:text-white transition">
                        Xem Bảng Xếp Hạng
                    </button>
                </div>

                <!-- Categories Widget -->
                <div class="bg-brand-beige/30 rounded-2xl p-6 border border-brand-beige">
                    <h3 class="font-serif font-bold text-lg text-brand-green mb-4">Khám Phá Thể Loại</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Tiểu Thuyết', 'Kinh Tế', 'Tâm Lý', 'Trinh Thám', 'Lịch Sử', 'Khoa Học', 'Thiếu Nhi', 'Kỹ Năng Sống'] as $tag)
                            <a href="#" class="bg-white text-gray-600 px-4 py-1.5 rounded-full text-sm font-medium border border-gray-100 hover:border-brand-accent hover:text-brand-accent transition shadow-sm">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#1F352B] text-white pt-20 pb-10 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 border-b border-white/10 pb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="text-3xl">📚</span>
                        <h3 class="font-serif font-bold text-2xl">GÓC SÁCH</h3>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Nơi kết nối những tâm hồn yêu sách. Chia sẻ review, thảo luận và tìm kiếm cuốn sách yêu thích tiếp theo của bạn.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-accent transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold mb-6 text-brand-beige">Khám Phá</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-brand-accent transition">Sách Mới Phát Hành</a></li>
                        <li><a href="#" class="hover:text-brand-accent transition">Top Review Tháng</a></li>
                        <li><a href="#" class="hover:text-brand-accent transition">Tác Giả Nổi Bật</a></li>
                        <li><a href="#" class="hover:text-brand-accent transition">Thử Thách Đọc</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-6 text-brand-beige">Hỗ Trợ</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-brand-accent transition">Về Chúng Tôi</a></li>
                        <li><a href="#" class="hover:text-brand-accent transition">Điều Khoản Sử Dụng</a></li>
                        <li><a href="#" class="hover:text-brand-accent transition">Chính Sách Bảo Mật</a></li>
                        <li><a href="#" class="hover:text-brand-accent transition">Liên Hệ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-6 text-brand-beige">Đăng Ký Nhận Tin</h4>
                    <p class="text-xs text-gray-400 mb-4">Nhận thông báo về sách mới và sự kiện hàng tuần.</p>
                    <form onsubmit="event.preventDefault();" class="relative">
                        <input type="email" placeholder="Email của bạn..." class="w-full pl-4 pr-12 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-brand-accent text-sm text-white placeholder-gray-500">
                        <button class="absolute right-1 top-1 bg-brand-accent hover:bg-[#c29263] text-white w-10 h-10 rounded-md transition flex items-center justify-center">
                            <i class="fas fa-paper-plane text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; 2025 Mọt Sách Review. All rights reserved.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>