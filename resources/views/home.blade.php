@extends('layouts.app')

@section('title', 'Trang Chủ - Góc Sách')

@section('content')
    {{-- ========================================================================= --}}
    {{-- SECTION: HERO SLIDER (BANNER CHÍNH) --}}
    {{-- ========================================================================= --}}
    <section id="hero-carousel" class="relative text-white py-12 lg:py-16 overflow-hidden bg-[#2A483A] group">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/20 to-transparent pointer-events-none"></div>

        {{-- Slider Wrapper --}}
        <div class="hero-slider-wrapper flex w-full transition-transform duration-700 ease-in-out" id="sliderWrapper">
            @foreach($heroSlides as $index => $slide)
                <div class="w-full flex-shrink-0 px-4 relative group/edit">
                    {{-- [ADMIN TOOL] Nút Sửa Banner --}}
                    @if(Auth::check() && Auth::user()->isAdmin() && isset($slide->id))
                        <a href="{{ route('admin.banners.edit', $slide->id) }}" 
                           class="absolute top-0 right-10 z-50 bg-white/90 text-blue-600 px-4 py-2 rounded-full shadow-lg hover:bg-blue-600 hover:text-white transition font-bold flex items-center gap-2 opacity-0 group-hover/edit:opacity-100 backdrop-blur-sm cursor-pointer">
                            <i class="fas fa-cog"></i> Sửa Banner
                        </a>
                    @endif

                    <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 justify-center">
                        {{-- 1. Ảnh Bìa Sách --}}
                        <div class="w-full md:w-5/12 flex justify-center md:justify-end perspective-1000">
                            <div class="relative w-48 h-72 md:w-56 md:h-80 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-r-lg rounded-l-sm transform rotate-y-12 hover:rotate-y-0 hover:scale-105 transition-all duration-700 cursor-pointer group/book">
                                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/book:opacity-20 transition-opacity z-20"></div>
                                @php
                                    $imagePath = is_object($slide) ? $slide->image : $slide['image'];
                                    $imgSrc = Str::startsWith($imagePath, 'http') ? $imagePath : asset('storage/' . $imagePath);
                                @endphp
                                <img src="{{ $imgSrc }}" class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-white/10" alt="Book Cover">
                                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-r from-white/30 to-transparent z-10"></div>
                            </div>
                        </div>
                        
                        {{-- 2. Nội Dung Banner --}}
                        <div class="w-full md:w-7/12 text-center md:text-left space-y-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-xs font-bold uppercase tracking-widest text-brand-beige">
                                    {{ is_object($slide) ? ($slide->tag ?? 'Nổi Bật') : $slide['tag'] }}
                                </span>
                            </div>
                            
                            <h1 class="text-3xl md:text-5xl font-bold leading-tight font-serif text-brand-beige drop-shadow-md">
                                {{ is_object($slide) ? $slide->title : $slide['title'] }}
                            </h1>
                            
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                <div class="flex text-yellow-400 text-lg">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-white/80 text-sm font-medium px-2 py-0.5 bg-white/10 rounded">
                                    {{ is_object($slide) ? ($slide->rating ?? '5.0') : $slide['rating'] }}
                                </span>
                            </div>
                            
                            <p class="text-gray-200 text-lg font-light italic max-w-2xl leading-relaxed drop-shadow">
                                {{ is_object($slide) ? ($slide->description ?? $slide->desc ?? '') : $slide['desc'] }}
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-2">
                                @php
                                    $link = is_object($slide) ? ($slide->link ?? '#') : '#';
                                @endphp
                                <a href="{{ $link }}" class="inline-flex items-center justify-center gap-2 bg-brand-accent text-white font-bold px-6 py-3 rounded-full shadow-lg hover:bg-[#c29263] transition-all transform hover:-translate-y-1">
                                    <span>Đọc review</span> <i class="fas fa-arrow-right text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Nút Điều Hướng --}}
        <button id="heroPrevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20 cursor-pointer">
            <i class="fas fa-chevron-left text-xl"></i>
        </button>
        <button id="heroNextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20 cursor-pointer">
            <i class="fas fa-chevron-right text-xl"></i>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20">
            @foreach($heroSlides as $index => $slide)
                <button class="indicator-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-all {{ $index === 0 ? 'bg-brand-accent w-8' : '' }}" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </section>

    {{-- ========================================================================= --}}
    {{-- SECTION: MAIN CONTENT --}}
    {{-- ========================================================================= --}}
    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- [CỘT TRÁI - CHIẾM 8 PHẦN] --}}
            <div class="lg:col-span-8 space-y-16">
                
                {{-- 1. TẠP CHÍ ĐỌC --}}
                <section>
                    <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-3">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 font-serif mb-1">Tạp Chí Đọc</h2>
                            <p class="text-sm text-gray-500">Góc nhìn sâu sắc về sách và cuộc sống</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        {{-- BÀI VIẾT CHÍNH (FEATURED) --}}
                        @if(isset($featuredArticle))
                        <article class="md:col-span-3 group cursor-pointer relative" 
                                 onclick="window.location.href='{{ route('article.detail', $featuredArticle->slug) }}'">
                            
                            @if(Auth::check() && Auth::user()->isAdmin())
                                {{-- Nút sửa (Ngăn chặn click bong bóng để không nhảy trang) --}}
                                <a href="{{ route('admin.articles.edit', $featuredArticle->id) }}" 
                                   onclick="event.stopPropagation()" 
                                   class="absolute top-4 right-4 z-20 bg-white/90 text-blue-600 p-2 rounded-full shadow-lg hover:bg-blue-600 hover:text-white transition opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif

                            <div class="relative h-64 md:h-80 rounded-2xl overflow-hidden mb-4 shadow-md">
                                <img src="{{ $featuredArticle->thumbnail }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <span class="absolute top-4 left-4 bg-brand-accent text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    {{ $featuredArticle->tag ?? 'Tiêu Điểm' }}
                                </span>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <div class="text-xs opacity-80 mb-2"><i class="far fa-calendar-alt mr-1"></i> {{ $featuredArticle->created_at->format('d/m/Y') }} • Bởi {{ $featuredArticle->user->name }}</div>
                                    <h3 class="text-2xl font-bold font-serif leading-tight group-hover:text-brand-beige transition">
                                        {{ $featuredArticle->title }}
                                    </h3>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed">{{ $featuredArticle->excerpt }}</p>
                        </article>
                        @endif

                        {{-- DANH SÁCH BÀI VIẾT PHỤ (SIDEBAR) --}}
                        <div class="md:col-span-2 flex flex-col gap-6">
                            @if(isset($sidebarArticles))
                                @foreach($sidebarArticles as $article)
                                <article class="flex flex-col group cursor-pointer relative" 
                                         onclick="window.location.href='{{ route('article.detail', $article->slug) }}'">
                                    
                                    @if(Auth::check() && Auth::user()->isAdmin())
                                         <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                            onclick="event.stopPropagation()"
                                            class="absolute top-2 right-2 z-20 bg-white/90 text-blue-600 p-1.5 rounded-full shadow hover:bg-blue-600 hover:text-white opacity-0 group-hover:opacity-100 transition">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                    @endif

                                    <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
                                        <img src="{{ $article->thumbnail }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                    </div>
                                    <div>
                                        <span class="text-brand-green text-xs font-bold uppercase">{{ $article->tag ?? 'Tin Tức' }}</span>
                                        <h3 class="font-serif font-bold text-base text-gray-800 leading-snug group-hover:text-brand-green transition mt-1">
                                            {{ $article->title }}
                                        </h3>
                                    </div>
                                </article>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>

                {{-- 2. SÁCH MỚI CẬP NHẬT --}}
                <section id="new-books" class="relative group/slider">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 font-serif border-l-4 border-brand-green pl-3">Sách Mới Cập Nhật</h2>
                        <a href="{{ route('list') }}" class="text-xs font-bold px-3 py-1 bg-gray-100 text-gray-500 hover:bg-brand-green hover:text-white rounded-full transition">Xem kho sách</a>
                    </div>
                    
                    <div class="relative px-2"> 
                        <button id="btnPrevNewBooks" class="absolute left-0 top-1/3 -translate-y-1/2 -ml-5 z-10 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-gray-600 hover:text-brand-green hover:scale-110 transition opacity-0 group-hover/slider:opacity-100 duration-300">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div id="sliderNewBooks" class="flex gap-5 overflow-x-auto scroll-smooth no-scrollbar pb-4" style="scroll-behavior: smooth;">
                            @if(isset($books) && $books->count() > 0)
                                @foreach($books->take(10) as $book) 
                                    @php
                                        $coverUrl = !empty($book->cover_image) 
                                            ? (str_starts_with($book->cover_image, 'http') ? $book->cover_image : asset('storage/' . $book->cover_image))
                                            : 'https://via.placeholder.com/150x225?text=No+Image';
                                    @endphp

                                    <div class="w-32 md:w-40 flex-shrink-0 group flex flex-col">
                                        <div class="relative w-full aspect-[2/3] rounded-lg overflow-hidden shadow-md mb-2 border border-gray-100 bg-gray-50">
                                            <a href="{{ route('detail', $book->slug) }}">
                                                <img src="{{ $coverUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110">
                                            </a>
                                            @if($loop->index < 3) <div class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow-sm">MỚI</div> @endif
                                        </div>
                                        <h3 class="font-serif font-bold text-sm text-gray-800 leading-tight mb-1 line-clamp-2 group-hover:text-brand-green transition h-9 overflow-hidden">
                                            <a href="{{ route('detail', $book->slug) }}" title="{{ $book->title }}">{{ $book->title }}</a>
                                        </h3>
                                        <p class="text-[11px] text-gray-500 truncate">{{ $book->author_name ?? 'Ẩn danh' }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="w-full py-8 text-center text-gray-400 bg-gray-50 rounded-lg">Chưa có sách mới.</div>
                            @endif
                        </div>
                        <button id="btnNextNewBooks" class="absolute right-0 top-1/3 -translate-y-1/2 -mr-5 z-10 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-gray-600 hover:text-brand-green hover:scale-110 transition opacity-0 group-hover/slider:opacity-100 duration-300"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </section>

                {{-- 3. CỘNG ĐỒNG REVIEW (AJAX READY) --}}
                <section id="community-posts" class="mb-16 scroll-mt-24">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 font-serif border-l-4 border-brand-accent pl-3">Cộng Đồng Review</h2>
                            <p class="text-sm text-gray-500 pl-4 mt-1">Góc chia sẻ cảm nhận chân thực từ độc giả</p>
                        </div>
                        
                        {{-- Bộ lọc Review --}}
                        <div class="bg-gray-100 p-1 rounded-full flex text-xs font-bold shadow-inner">
                            <button onclick="loadComments('latest')" 
                                    id="tab-latest"
                                    class="px-5 py-2 rounded-full transition-all duration-300 bg-white text-brand-green shadow-sm">
                                Mới nhất
                            </button>
                            <button onclick="loadComments('popular')" 
                                    id="tab-popular"
                                    class="px-5 py-2 rounded-full transition-all duration-300 text-gray-500 hover:text-gray-700">
                                Nổi bật nhất
                            </button>
                        </div>
                    </div>
                    
                    {{-- Container chứa danh sách comment (AJAX sẽ load vào đây) --}}
                    <div id="comments-container" class="grid grid-cols-1 gap-6 min-h-[200px] relative">
                        {{-- Loading Spinner (Ẩn mặc định) --}}
                        <div id="loading-spinner" class="hidden absolute inset-0 bg-white/80 z-10 flex items-center justify-center">
                            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-brand-green"></div>
                        </div>

                        {{-- Load file Partial lần đầu tiên (Server Side Render) --}}
                        @include('partials.home_comments')
                    </div>
                </section>

                {{-- Banner Sự Kiện --}}
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
            </div> {{-- END CỘT 8 --}}

            {{-- [CỘT PHẢI - 4 PHẦN] --}}
            <div class="lg:col-span-4">
                <div class="space-y-8">
                    {{-- Widget 1: Top Thịnh Hành (Để trôi tự nhiên, không sticky) --}}
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-soft">
                        <h3 class="font-serif font-bold text-lg text-gray-800 mb-5 flex items-center gap-2">
                            <span class="text-brand-accent">🔥</span> Top Thịnh Hành
                        </h3>
                        <div class="space-y-4">
                            @if(isset($books) && $books->count() > 0)
                                @foreach($books->sortByDesc('view_count')->take(5)->values() as $index => $book)
                                    @php
                                        $coverUrl = !empty($book->cover_image) 
                                            ? (str_starts_with($book->cover_image, 'http') ? $book->cover_image : asset('storage/' . $book->cover_image))
                                            : 'https://via.placeholder.com/150x225?text=No+Image';
                                    @endphp
                                    <a href="{{ route('detail', $book->slug) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition cursor-pointer group">
                                        <span class="font-bold text-gray-300 w-6 text-center text-xl italic group-hover:text-brand-accent transition font-serif">{{ $index + 1 }}</span>
                                        <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0 shadow-sm border border-gray-100">
                                            <img src="{{ $coverUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition" title="{{ $book->title }}">{{ $book->title }}</h4>
                                            <div class="flex items-center gap-2 text-xs mt-1">
                                                <span class="text-yellow-500 font-bold flex items-center">{{ number_format($book->avg_rating, 1) }} <i class="fas fa-star text-[10px] ml-0.5"></i></span>
                                                <span class="text-gray-400">|</span>
                                                <span class="text-gray-500 flex items-center" title="Lượt xem"><i class="far fa-eye mr-1"></i> {{ number_format($book->view_count) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="text-center text-sm text-gray-400 py-4 italic">Dữ liệu đang cập nhật...</div>
                            @endif
                        </div>
                    </div>

                    {{-- [MỚI] GOM 2 WIDGET DƯỚI VÀO 1 DIV STICKY --}}
                    {{-- top-24 để chừa khoảng cách với header khi cuộn xuống --}}
                    <div class="sticky top-24 space-y-6">
                        
                        {{-- Widget 2: Thể Loại --}}
                        {{-- Đã xóa class sticky cũ ở đây --}}
                        <div class="bg-brand-beige/30 rounded-xl p-6 border border-brand-beige">
                            <h3 class="font-serif font-bold text-lg text-brand-green mb-4 flex items-center gap-2"><i class="fas fa-tags text-brand-accent"></i> Thể Loại</h3>
                            <div class="flex flex-wrap gap-2">
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $category)
                                        <a href="{{ route('list', ['category' => $category->id]) }}" class="group flex items-center gap-2 bg-white text-gray-600 px-3 py-1.5 rounded-full text-xs font-bold border border-gray-100 hover:border-brand-accent hover:text-brand-accent hover:shadow-md transition-all duration-300">
                                            <span>{{ $category->name }}</span>
                                            <span class="bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-full text-[10px] group-hover:bg-brand-accent/10 group-hover:text-brand-accent transition">
                                                {{ $category->books_count ?? 0 }}
                                            </span>
                                        </a>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-400 italic">Đang cập nhật...</span>
                                @endif
                            </div>
                            
                            @if(isset($categories) && $categories->count() > 10)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('list') }}" class="text-xs text-brand-green font-bold hover:underline">Xem tất cả thể loại</a>
                                </div>
                            @endif
                        </div>

                        {{-- Widget 3: Liên Kết Mua Sách --}}
                        {{-- Đã xóa class sticky cũ ở đây --}}
                        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <h3 class="font-serif font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                                <span class="text-brand-accent">🛒</span> Mua Sách Giá Tốt
                            </h3>
                            
                            <div class="space-y-3">
                                <a href="https://tiki.vn/nha-sach-tiki/c8322" target="_blank" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition group bg-white">
                                    <div class="flex items-center gap-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/43/Logo_Tiki_2023.png" class="w-8 h-8 object-contain" alt="Tiki">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm text-gray-700 group-hover:text-blue-600">Tiki Trading</span>
                                            <span class="text-[10px] text-green-600 font-bold bg-green-100 px-1.5 py-0.5 rounded w-fit">Giảm tới 35%</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-external-link-alt text-gray-300 text-xs group-hover:text-blue-500"></i>
                                </a>

                                <a href="https://shopee.vn/nhasachphuongnam" target="_blank" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-orange-400 hover:bg-orange-50 transition group bg-white">
                                    <div class="flex items-center gap-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" class="w-8 h-8 object-contain" alt="Shopee">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm text-gray-700 group-hover:text-orange-600">Shopee Mall</span>
                                            <span class="text-[10px] text-orange-500 font-bold bg-orange-100 px-1.5 py-0.5 rounded w-fit">Freeship Extra</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-external-link-alt text-gray-300 text-xs group-hover:text-orange-500"></i>
                                </a>

                                <a href="https://www.fahasa.com/" target="_blank" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-red-400 hover:bg-red-50 transition group bg-white">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs">F</div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm text-gray-700 group-hover:text-red-600">Fahasa.com</span>
                                            <span class="text-[10px] text-gray-500">Sách chính hãng</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-external-link-alt text-gray-300 text-xs group-hover:text-red-500"></i>
                                </a>
                            </div>
                        </div>

                    </div> {{-- END DIV STICKY GROUP --}}

                </div>
            </div> {{-- END CỘT 4 --}}
        </div>
    </main>
@endsection

@push('scripts')
<script>
    // ==========================================
    // 1. AJAX REVIEW LOGIC (NEW: Sort + Pagination)
    // ==========================================
    let currentSortType = 'latest'; 

    function loadComments(param) {
        let url = '';

        // Trường hợp 1: Chuyển Tab (param = 'latest' hoặc 'popular')
        if (param === 'latest' || param === 'popular') {
            currentSortType = param;
            url = `/?sort_review=${param}`; // Reset về trang 1
            updateTabUI(param);
        } 
        // Trường hợp 2: Chuyển trang (param là URL phân trang)
        else {
            url = param;
            if (!url.includes('sort_review')) {
                url += `&sort_review=${currentSortType}`;
            }
        }

        // Hiện Loading
        const container = document.getElementById('comments-container');
        const spinner = document.getElementById('loading-spinner');
        if(spinner) spinner.classList.remove('hidden'); 

        // Gọi Ajax
        fetch(url, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.text())
        .then(html => {
            const spinnerHtml = `<div id="loading-spinner" class="hidden absolute inset-0 bg-white/80 z-10 flex items-center justify-center"><div class="animate-spin rounded-full h-10 w-10 border-b-2 border-brand-green"></div></div>`;
            container.innerHTML = spinnerHtml + html;
            
            // Gán lại sự kiện cho phân trang mới sinh ra
            attachPaginationEvents();
            
            // Scroll nhẹ
            document.getElementById('community-posts').scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi khi tải dữ liệu.');
        })
        .finally(() => {
            const newSpinner = document.getElementById('loading-spinner');
            if(newSpinner) newSpinner.classList.add('hidden');
        });
    }

    function updateTabUI(sortType) {
        const tabLatest = document.getElementById('tab-latest');
        const tabPopular = document.getElementById('tab-popular');
        const activeClass = ['bg-white', 'text-brand-green', 'shadow-sm'];
        const inactiveClass = ['text-gray-500', 'hover:text-gray-700'];

        if (sortType === 'latest') {
            tabLatest.classList.add(...activeClass);
            tabLatest.classList.remove(...inactiveClass);
            tabPopular.classList.remove(...activeClass);
            tabPopular.classList.add(...inactiveClass);
        } else {
            tabPopular.classList.add(...activeClass);
            tabPopular.classList.remove(...inactiveClass);
            tabLatest.classList.remove(...activeClass);
            tabLatest.classList.add(...inactiveClass);
        }
    }

    function attachPaginationEvents() {
        const paginationLinks = document.querySelectorAll('.ajax-pagination-link');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url) loadComments(url);
            });
        });
    }

    // ==========================================
    // 2. HERO SLIDER & OTHER EVENTS
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- Init Pagination Events ---
        attachPaginationEvents();

        // --- Hero Slider ---
        const sliderWrapper = document.getElementById('sliderWrapper');
        const dots = document.querySelectorAll('.indicator-dot');
        const prevBtn = document.getElementById('heroPrevBtn');
        const nextBtn = document.getElementById('heroNextBtn');
        
        const totalSlides = {{ isset($heroSlides) ? count($heroSlides) : 0 }};
        let currentSlide = 0;
        let slideInterval;

        if(totalSlides > 1) {
            function updateSlider() {
                if (!sliderWrapper) return;
                sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
                dots.forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.add('bg-brand-accent', 'w-8');
                        dot.classList.remove('bg-white/30');
                    } else {
                        dot.classList.remove('bg-brand-accent', 'w-8');
                        dot.classList.add('bg-white/30');
                    }
                });
            }

            function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; updateSlider(); resetTimer(); }
            function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; updateSlider(); resetTimer(); }
            function startTimer() { slideInterval = setInterval(nextSlide, 5000); }
            function resetTimer() { clearInterval(slideInterval); startTimer(); }

            if(nextBtn) nextBtn.addEventListener('click', nextSlide);
            if(prevBtn) prevBtn.addEventListener('click', prevSlide);

            dots.forEach((dot) => {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    currentSlide = index;
                    updateSlider();
                    resetTimer();
                });
            });
            startTimer();
        } else {
            if(prevBtn) prevBtn.style.display = 'none';
            if(nextBtn) nextBtn.style.display = 'none';
        }

        // --- New Books Slider ---
        const sliderNewBooks = document.getElementById('sliderNewBooks');
        const btnPrevNew = document.getElementById('btnPrevNewBooks');
        const btnNextNew = document.getElementById('btnNextNewBooks');

        if(sliderNewBooks && btnPrevNew && btnNextNew) {
            btnNextNew.addEventListener('click', () => { sliderNewBooks.scrollBy({ left: 220, behavior: 'smooth' }); });
            btnPrevNew.addEventListener('click', () => { sliderNewBooks.scrollBy({ left: -220, behavior: 'smooth' }); });
        }

        // --- Logic Like/Reply ---
        const currentUserId = "{{ Auth::id() }}";

        window.handleLike = function(id, type) {
            if (!currentUserId) { alert("Vui lòng đăng nhập!"); window.location.href = "/login"; return; }
            
            const btn = document.getElementById(`like-btn-${type}-${id}`);
            const icon = document.getElementById(`like-icon-${type}-${id}`);
            const countSpan = document.getElementById(`like-count-${type}-${id}`);
            if (!btn) return;

            const isLiked = icon.classList.contains('fas'); 
            if(isLiked) {
                icon.classList.remove('fas', 'text-red-500'); icon.classList.add('far');
                btn.classList.remove('text-red-500');
                countSpan.innerText = Math.max(0, parseInt(countSpan.innerText) - 1);
            } else {
                icon.classList.remove('far'); icon.classList.add('fas', 'bounce');
                btn.classList.add('text-red-500');
                countSpan.innerText = parseInt(countSpan.innerText) + 1;
            }

            fetch('/like', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ id: id, type: type })
            })
            .then(res => res.json())
            .then(data => { if(data.success) countSpan.innerText = data.count; })
            .catch(err => console.error(err));
        };

        window.toggleReplyForm = function(commentId) {
            if (!currentUserId) { alert("Vui lòng đăng nhập!"); window.location.href = "/login"; return; }
            const form = document.getElementById(`reply-form-${commentId}`);
            const input = document.getElementById(`reply-input-${commentId}`);
            document.querySelectorAll('[id^="reply-form-"]').forEach(el => el.classList.add('hidden'));
            
            if (form.classList.contains('hidden')) { form.classList.remove('hidden'); input.focus(); } 
            else { form.classList.add('hidden'); }
        };

        window.autoResize = function(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };

        window.handleEnter = function(event, commentId) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                window.submitInlineReply(commentId);
            }
        };

        window.submitInlineReply = function(commentId) {
            const input = document.getElementById(`reply-input-${commentId}`);
            const content = input.value.trim();
            if (!content) { alert("Nội dung trống!"); return; }

            fetch(`/comment/${commentId}/reply`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ content: content })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
                else alert("Lỗi!");
            })
            .catch(err => console.error(err));
        };
    });
</script>
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush