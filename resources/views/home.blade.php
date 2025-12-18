@extends('layouts.app')

@section('title', 'Trang Chủ - Góc Sách')

@section('content')
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
                                <img src="{{ $imgSrc }}" class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-white/10">
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

    {{-- MAIN LAYOUT --}}
    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- [CỘT TRÁI - CHIẾM 8 PHẦN] --}}
            <div class="lg:col-span-8 space-y-16">
                
                {{-- 1. TẠP CHÍ ĐỌC --}}
                <section class="relative">
                    {{-- Decorative --}}
                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-brand-accent/5 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="flex justify-between items-end mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-brand-accent to-brand-green rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-newspaper text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 font-serif flex items-center gap-3">
                                    Tạp Chí Đọc
                                    <span class="text-xs bg-brand-green/10 text-brand-green px-2.5 py-1 rounded-full font-bold">FEATURED</span>
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">Góc nhìn sâu sắc về sách và cuộc sống</p>
                            </div>
                        </div>
                        <a href="#" class="hidden md:flex items-center gap-2 text-sm font-bold text-brand-green hover:text-brand-accent transition group">
                            <span>Xem tất cả</span>
                            <i class="fas fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        @if(isset($featuredArticle))
                        <article class="md:col-span-3 group cursor-pointer relative" onclick="window.location.href='{{ route('articles.show', $featuredArticle->slug ?? $featuredArticle->id) }}'">
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

                        <div class="md:col-span-2 flex flex-col gap-6">
                            @if(isset($sidebarArticles))
                                @foreach($sidebarArticles as $article)
                                <article class="flex flex-col group cursor-pointer relative" onclick="window.location.href='{{ route('articles.show', $article->slug ?? $article->id) }}'">
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
                <section id="new-books" class="relative group/slider bg-gradient-to-br from-brand-green/5 via-white to-brand-beige/20 rounded-2xl p-6 border border-gray-100 shadow-sm">
                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-brand-green/10 rounded-xl flex items-center justify-center">
                                <i class="fas fa-book-open text-brand-green"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 font-serif flex items-center gap-2">
                                    Sách Mới Cập Nhật
                                    <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full font-bold animate-pulse">MỚI</span>
                                </h2>
                                <p class="text-xs text-gray-500">Những tựa sách mới nhất trong thư viện</p>
                            </div>
                        </div>
                        <a href="{{ route('books.list') }}" class="text-xs font-bold px-4 py-2 bg-brand-green text-white hover:bg-brand-accent rounded-full transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center gap-2">
                            <span>Xem kho sách</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    
                    {{-- Slider Container --}}
                    <div class="relative px-2"> 
                        {{-- Prev Button --}}
                        <button id="btnPrevNewBooks" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-3 z-10 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-gray-600 hover:text-white hover:bg-brand-green hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 duration-300">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        {{-- Books Slider --}}
                        <div id="sliderNewBooks" class="flex gap-5 overflow-x-auto scroll-smooth no-scrollbar pb-4" style="scroll-behavior: smooth;">
                            @if(isset($books) && $books->count() > 0)
                                @foreach($books->take(10) as $book) 
                                    @php
                                        $coverUrl = !empty($book->cover_image) 
                                            ? (str_starts_with($book->cover_image, 'http') ? $book->cover_image : asset('storage/' . $book->cover_image))
                                            : 'https://via.placeholder.com/150x225?text=No+Image';
                                        $rating = $book->avg_rating ?? rand(35, 50) / 10;
                                    @endphp

                                    <div class="w-36 md:w-44 flex-shrink-0 group">
                                        {{-- Book Card --}}
                                        <div class="relative w-full aspect-[2/3] rounded-xl overflow-hidden shadow-lg mb-3 bg-gradient-to-br from-gray-100 to-gray-200 transform transition-all duration-500 group-hover:scale-105 group-hover:shadow-xl">
                                            {{-- Book Cover --}}
                                            <a href="{{ route('detail', $book->slug) }}" class="block w-full h-full">
                                                <img src="{{ $coverUrl }}" alt="{{ $book->title }}" 
                                                     class="w-full h-full object-cover transition duration-700 group-hover:brightness-110"
                                                     onerror="this.src='https://via.placeholder.com/150x225?text=No+Image'">
                                            </a>
                                            
                                            {{-- Overlay Gradient --}}
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            
                                            {{-- Badge NEW --}}
                                            @if($loop->index < 3)
                                                <div class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-orange-400 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md flex items-center gap-1 animate-pulse">
                                                    <i class="fas fa-fire text-[8px]"></i> MỚI
                                                </div>
                                            @endif
                                            
                                            {{-- Rating Badge --}}
                                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-bold px-2 py-1 rounded-full shadow-sm flex items-center gap-1">
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <span>{{ number_format($rating, 1) }}</span>
                                            </div>
                                            
                                            {{-- Quick Actions (on hover) --}}
                                            <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                                <a href="{{ route('detail', $book->slug) }}" 
                                                   class="w-full bg-white text-brand-green font-bold text-xs py-2 rounded-lg flex items-center justify-center gap-2 shadow-lg hover:bg-brand-green hover:text-white transition">
                                                    <i class="fas fa-eye"></i> Xem chi tiết
                                                </a>
                                            </div>
                                        </div>
                                        
                                        {{-- Book Info --}}
                                        <div class="px-1">
                                            <h3 class="font-serif font-bold text-sm text-gray-800 leading-tight mb-1 line-clamp-2 group-hover:text-brand-green transition min-h-[2.5rem]">
                                                <a href="{{ route('detail', $book->slug) }}" title="{{ $book->title }}">{{ $book->title }}</a>
                                            </h3>
                                            <p class="text-[11px] text-gray-500 truncate flex items-center gap-1">
                                                <i class="fas fa-user-edit text-[9px] text-gray-400"></i>
                                                {{ $book->author_name ?? 'Ẩn danh' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="w-full py-12 text-center text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    <i class="fas fa-books text-4xl mb-3 block text-gray-300"></i>
                                    <p class="font-medium">Chưa có sách mới trong thư viện.</p>
                                    <a href="{{ route('books.list') }}" class="text-brand-green text-sm font-bold hover:underline mt-2 inline-block">Khám phá kho sách →</a>
                                </div>
                            @endif
                        </div>

                        {{-- Next Button --}}
                        <button id="btnNextNewBooks" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-3 z-10 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-gray-600 hover:text-white hover:bg-brand-green hover:scale-110 transition-all opacity-0 group-hover/slider:opacity-100 duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    {{-- Decorative Element --}}
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-brand-accent/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-brand-green/10 rounded-full blur-3xl pointer-events-none"></div>
                </section>

                {{-- 3. CỘNG ĐỒNG REVIEW --}}
<section id="community-posts" class="mb-16 scroll-mt-24">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-1 h-8 bg-brand-accent rounded-full"></div> 
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 font-serif leading-none flex items-center gap-3">Cộng Đồng Review
                        {{-- [ĐÃ SỬA]: Dùng $latestReviews --}}
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-semibold">{{ $latestReviews->total() ?? 0 }} bài</span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Góc chia sẻ cảm nhận từ độc giả</p>
                </div>
            </div>
            
            {{-- Bộ lọc Review --}}
            <div class="flex items-center gap-3">
                <div class="bg-brand-green/10 rounded-full p-1.5 flex text-xs font-bold">
                    <button onclick="loadComments('latest')" id="tab-latest" class="px-4 py-1.5 rounded-full transition-all duration-300 bg-white text-brand-green shadow-sm">
                        Mới nhất
                    </button>
                    <button onclick="loadComments('popular')" id="tab-popular" class="px-4 py-1.5 rounded-full transition-all duration-300 text-gray-500 hover:bg-gray-50">
                        Nổi bật
                    </button>
                </div>
                <a href="{{ route('books.search') }}" class="text-xs text-gray-400 hover:text-gray-600 ml-3">Xem tất cả</a>
            </div>
        </div>
        
        {{-- Container chứa danh sách --}}
        <div id="comments-container" class="relative min-h-[200px] bg-gray-50 rounded-2xl p-4 border border-gray-100">
            {{-- Loading Spinner --}}
            <div id="loading-spinner" class="hidden absolute inset-0 bg-white/80 z-20 flex items-center justify-center rounded-2xl transition-opacity duration-300">
                <div class="animate-spin rounded-full h-8 w-8 border-2 border-brand-green border-t-transparent"></div>
            </div>

            {{-- NỘI DUNG AJAX SẼ ĐỔ VÀO ĐÂY --}}
            <div id="comments-content-wrapper">
                 {{-- [ĐÃ SỬA]: Truyền biến latestReviews --}}
                 @include('partials.home_comments', ['latestReviews' => $latestReviews])
            </div>
        </div>  
    </div>
</section>

                {{-- Banner Sự Kiện - PREMIUM --}}
                <div class="bg-gradient-to-br from-[#2A483A] via-[#1e3a2f] to-[#0f1f17] rounded-2xl p-8 relative overflow-hidden shadow-xl text-white group hover:shadow-2xl transition-all duration-500">
                    {{-- Decorative Elements --}}
                    <div class="absolute top-0 right-0 w-72 h-72 bg-brand-accent/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-green-500/10 rounded-full blur-2xl -ml-12 -mb-12"></div>
                    <div class="absolute top-1/2 right-1/4 w-2 h-2 bg-brand-accent rounded-full animate-ping"></div>
                    <div class="absolute bottom-1/3 left-1/4 w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-5">
                            {{-- Icon Trophy --}}
                            <div class="w-16 h-16 bg-gradient-to-br from-brand-accent to-yellow-400 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-6 transition-transform duration-300">
                                <i class="fas fa-trophy text-white text-2xl"></i>
                            </div>
                            
                            <div>
                                <span class="inline-flex items-center gap-2 text-brand-accent text-xs font-bold uppercase tracking-wider border border-brand-accent/40 bg-brand-accent/10 px-3 py-1 rounded-full mb-2">
                                    <span class="w-1.5 h-1.5 bg-brand-accent rounded-full animate-pulse"></span>
                                    Sự kiện HOT
                                </span>
                                <h3 class="text-2xl md:text-3xl font-serif font-bold mb-2 text-brand-beige">Thử Thách Đọc Sách 2025</h3>
                                <p class="text-white/70 text-sm font-light max-w-md leading-relaxed">
                                    <i class="fas fa-medal text-yellow-400 mr-1"></i>
                                    Hoàn thành <span class="text-brand-accent font-bold">3 cuốn sách</span> để nhận huy hiệu "Mọt Sách Cần Cù" và nhiều phần thưởng hấp dẫn!
                                </p>
                            </div>
                        </div>
                        
                        <a href="{{ route('challenges.index') }}" class="bg-gradient-to-r from-brand-accent to-yellow-500 hover:from-yellow-500 hover:to-brand-accent text-white px-8 py-3.5 rounded-full font-bold shadow-xl hover:shadow-2xl transition-all text-sm whitespace-nowrap flex items-center gap-2 transform hover:-translate-y-1">
                            <i class="fas fa-rocket"></i>
                            Tham Gia Ngay
                        </a>
                    </div>
                </div>
            </div> {{-- END CỘT 8 --}}

            {{-- [CỘT PHẢI - 4 PHẦN] --}}
            <div class="lg:col-span-4">
                <div class="space-y-8">
                    {{-- Widget 1: Top Thịnh Hành --}}
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 border border-gray-100 shadow-lg relative overflow-hidden">
                        {{-- Decorative --}}
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-orange-100 rounded-full blur-2xl pointer-events-none"></div>
                        
                        <h3 class="font-serif font-bold text-lg text-gray-800 mb-5 flex items-center gap-3 relative">
                            <span class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-fire-alt text-white"></i>
                            </span>
                            <div>
                                <span class="block">Top Thịnh Hành</span>
                                <span class="text-[10px] text-gray-400 font-normal">Được đọc nhiều nhất</span>
                            </div>
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
                                                <span class="text-yellow-500 font-bold flex items-center">
                                                    {{ number_format($book->posts_avg_rating ?? $book->avg_rating ?? 0, 1) }} 
                                                    <i class="fas fa-star text-[10px] ml-0.5"></i>
                                                </span>
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

                    {{-- Widget 2: Thể Loại --}}
                    <div class="bg-brand-beige/30 rounded-xl p-6 border border-brand-beige">
                        <h3 class="font-serif font-bold text-lg text-brand-green mb-4 flex items-center gap-2"><i class="fas fa-tags text-brand-accent"></i> Thể Loại</h3>
                        <div class="flex flex-wrap gap-2">
                            @if(isset($categories) && $categories->count() > 0)
                                @foreach($categories as $category)
                                    <a href="{{ route('books.list', ['categories' => [$category->name]]) }}" class="group flex items-center gap-2 bg-white text-gray-600 px-3 py-1.5 rounded-full text-xs font-bold border border-gray-100 hover:border-brand-accent hover:text-brand-accent hover:shadow-md transition-all duration-300">
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
                                <a href="{{ route('books.list') }}" class="text-xs text-brand-green font-bold hover:underline">Xem tất cả thể loại</a>
                            </div>
                        @endif
                    </div>

                    {{-- Widget 3: Liên Kết Mua Sách --}}
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

{{-- BỎ MODAL POPUP CŨ --}}
@endsection

@push('scripts')
<script>
    // --- BIẾN TOÀN CỤC ---
    const currentUserId = "{{ Auth::id() }}";

    // --- 1. KHỞI TẠO KHI TRANG LOAD ---
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Slider
        const sliderWrapper = document.getElementById('sliderWrapper');
        const dots = document.querySelectorAll('.indicator-dot');
        const prevBtn = document.getElementById('heroPrevBtn');
        const nextBtn = document.getElementById('heroNextBtn');
        const totalSlides = {{ isset($heroSlides) ? count($heroSlides) : 0 }};
        let currentSlide = 0;
        let slideInterval;

        if (totalSlides > 1) {
            function updateSlider() {
                if (!sliderWrapper) return;
                sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
                dots.forEach((dot, index) => {
                    dot.classList.toggle('bg-brand-accent', index === currentSlide);
                    dot.classList.toggle('w-8', index === currentSlide);
                    dot.classList.toggle('bg-white/30', index !== currentSlide);
                });
            }
            function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; updateSlider(); resetTimer(); }
            function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; updateSlider(); resetTimer(); }
            function startTimer() { slideInterval = setInterval(nextSlide, 5000); }
            function resetTimer() { clearInterval(slideInterval); startTimer(); }
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            dots.forEach((dot) => {
                dot.addEventListener('click', function() {
                    currentSlide = parseInt(this.getAttribute('data-index'));
                    updateSlider(); resetTimer();
                });
            });
            startTimer();
        }

        // New Books Slider
        const sliderNewBooks = document.getElementById('sliderNewBooks');
        const btnPrevNew = document.getElementById('btnPrevNewBooks');
        const btnNextNew = document.getElementById('btnNextNewBooks');
        if(sliderNewBooks && btnPrevNew && btnNextNew) {
            btnNextNew.addEventListener('click', () => sliderNewBooks.scrollBy({ left: 220, behavior: 'smooth' }));
            btnPrevNew.addEventListener('click', () => sliderNewBooks.scrollBy({ left: -220, behavior: 'smooth' }));
        }

        attachPaginationEvents();
        const initialSort = new URLSearchParams(window.location.search).get('sort_review') || 'latest';
        updateTabUI(initialSort);
    });

    // --- 2. HÀM ĐIỀU KHIỂN GIAO DIỆN (TOGGLE) ---

    // Mở khung bình luận của Post và focus ô nhập
    function togglePostComments(postId) {
        const list = document.getElementById(`comments-list-${postId}`);
        const chevron = document.getElementById(`chevron-${postId}`);
        const input = document.getElementById(`post-comment-input-${postId}`);
        
        if (list) {
            const isHidden = list.classList.contains('hidden');
            list.classList.toggle('hidden');
            if(chevron) chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            if(isHidden && input) input.focus();
        }
    }

    // Mở khung trả lời của từng Comment
    function toggleReplySection(commentId) {
        const section = document.getElementById(`reply-section-${commentId}`);
        const input = document.getElementById(`reply-input-${commentId}`);
        
        if (section) {
            const isHidden = section.classList.contains('hidden');
            // Đóng các khung reply khác
            document.querySelectorAll('[id^="reply-section-"]').forEach(el => el.classList.add('hidden'));
            
            section.classList.toggle('hidden');
            if(!isHidden) section.classList.add('hidden'); // Nếu đang hiện thì ẩn
            else if(input) input.focus();
        }
    }

    // Tự động giãn ô textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // --- 3. HÀM XỬ LÝ DỮ LIỆU (AJAX & FETCH) ---

    function loadComments(urlOrSortType) {
        let url = urlOrSortType.includes('http') ? urlOrSortType : `/?sort_review=${urlOrSortType}`;
        const spinner = document.getElementById('loading-spinner');
        const contentWrapper = document.getElementById('comments-content-wrapper');
        
        if(spinner) spinner.classList.remove('hidden');
        if(contentWrapper) contentWrapper.style.opacity = '0.5';

        fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
        .then(response => response.text())
        .then(html => {
            if(contentWrapper) {
                contentWrapper.innerHTML = html;
                contentWrapper.style.opacity = '1';
                attachPaginationEvents();
            }
        })
        .finally(() => { if(spinner) spinner.classList.add('hidden'); });
        
        if (!urlOrSortType.includes('http')) updateTabUI(urlOrSortType);
    }

    // 1. Sửa định nghĩa hàm, thêm tham số 'e'
    // Thêm tham số 'btnElement' để xác định trực tiếp nút được bấm
    function submitComment(postId, parentId = null, event) {
    if (event) event.preventDefault();
    
    const targetId = parentId ? `reply-input-${parentId}` : `post-comment-input-${postId}`;
    const elementBox = document.getElementById(targetId);
    
    if (!elementBox) return;

    const valueContent = elementBox.value.trim();
    if (!valueContent) {
        alert("Vui lòng nhập nội dung!");
        return;
    }

    const btnAction = event.currentTarget || event.target.closest('button');
    const oldHtml = btnAction ? btnAction.innerHTML : '';
    if (btnAction) {
        btnAction.disabled = true;
        btnAction.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }

    fetch(`/post/${postId}/comment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ content: valueContent, parent_id: parentId })
    })
    .then(async r => {
        const d = await r.json();
        if (!r.ok) throw new Error(d.message || "Lỗi server");
        return d;
    })
    .then(data => {
        if (data.success) {
            elementBox.value = '';
            elementBox.style.height = 'auto';

            // 1. Cập nhật số lượng bình luận ngay lập tức
            const countLabels = document.querySelectorAll(`.comment-count-${postId}`);
            countLabels.forEach(el => {
                el.innerText = `Bình luận (${data.new_count})`;
            });

            // 2. Tạo HTML bình luận mới để chèn vào giao diện
            const newCommentHtml = `
    <div class="flex gap-3 animate-fade-in mb-6">
        <img src="${data.comment.user_avatar}" class="w-9 h-9 rounded-full border border-white shadow-sm flex-shrink-0">
        <div class="flex-1">
            <div class="bg-white p-3 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-1">
                    <h5 class="font-bold text-xs text-gray-800">${data.comment.user_name}</h5>
                    <span class="text-[10px] text-gray-400">${data.comment.created_at}</span>
                </div>
                <p class="text-xs text-gray-600">${data.comment.content}</p>
            </div>

            ${!parentId ? `
                <div class="flex gap-3 mt-1 ml-2">
                    <button onclick="handleLike(${data.comment.id}, 'comment')" 
                            id="like-btn-comment-${data.comment.id}"
                            class="text-[10px] font-bold flex items-center gap-1 text-gray-400 hover:text-red-500">
                        <i id="like-icon-comment-${data.comment.id}" class="far fa-heart text-xs"></i>
                        <span id="like-count-comment-${data.comment.id}">0</span>
                    </button>

                    <button onclick="toggleReplySection(${data.comment.id})" class="text-[10px] font-bold text-gray-400 hover:text-blue-500 transition">
                        Trả lời (0)
                    </button>
                </div>
                
                <div id="reply-section-${data.comment.id}" class="hidden mt-3 space-y-4 border-l-2 border-gray-100 pl-4 animate-fade-in">
                    <div class="flex gap-2 relative mt-2">
                        <textarea id="reply-input-${data.comment.id}" rows="1" 
                                  class="w-full text-xs p-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green resize-none shadow-sm" 
                                  placeholder="Nhập câu trả lời..."></textarea>
                        <button type="button" onclick="submitComment(${postId}, ${data.comment.id}, event)" 
                                class="text-brand-green px-3 py-1 bg-brand-green/10 rounded-lg text-xs font-bold hover:bg-brand-green hover:text-white transition">Gửi</button>
                    </div>
                </div>
            ` : `
                <button onclick="handleLike(${data.comment.id}, 'comment')" 
                        id="like-btn-comment-${data.comment.id}"
                        class="text-[9px] font-bold ml-2 mt-1 flex items-center gap-1 text-gray-400">
                    <i id="like-icon-comment-${data.comment.id}" class="far fa-heart"></i>
                    <span id="like-count-comment-${data.comment.id}">0</span>
                </button>
            `}
        </div>
    </div>`;
            // 3. Chèn vào đúng vị trí (Reply hoặc Comment chính)
            if (parentId) {
                const replySection = document.getElementById(`reply-section-${parentId}`);
                replySection.classList.remove('hidden');
                // Chèn vào trước ô nhập reply
                replySection.insertAdjacentHTML('beforeend', newCommentHtml);
            } else {
                const list = document.querySelector(`#comments-list-${postId} .space-y-6`);
                // Xóa dòng "Chưa có bình luận" nếu tồn tại
                const emptyMsg = list.querySelector('p.italic');
                if (emptyMsg) emptyMsg.remove();
                
                // Chèn lên đầu danh sách bình luận mới nhất
                list.insertAdjacentHTML('afterbegin', newCommentHtml);
            }

            if (btnAction) {
                btnAction.disabled = false;
                btnAction.innerHTML = oldHtml;
            }
        }
    })
    .catch(e => {
        alert("Lỗi: " + e.message);
        if (btnAction) {
            btnAction.disabled = false;
            btnAction.innerHTML = oldHtml;
        }
    });
}       

// Hàm hỗ trợ reset nút khi lỗi
    function resetBtn(btn, html) {
    if (btn) {
        btn.innerHTML = html;
        btn.disabled = false;
    }
    }

    function handleLike(id, type) {
        if (!currentUserId) { alert("Vui lòng đăng nhập!"); window.location.href = "/login"; return; }
        const btn = document.getElementById(`like-btn-${type}-${id}`);
        const icon = document.getElementById(`like-icon-${type}-${id}`);
        const countSpan = document.getElementById(`like-count-${type}-${id}`);
        if (!btn || !icon || !countSpan) return;

        const isLiked = icon.classList.contains('fas');
        fetch('/like', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ id: id, type: type })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                icon.classList.toggle('fas', data.liked);
                icon.classList.toggle('far', !data.liked);
                icon.classList.toggle('text-red-500', data.liked);
                btn.classList.toggle('text-red-500', data.liked);
                countSpan.innerText = data.count;
            }
        });
    }

    function attachPaginationEvents() {
        document.querySelectorAll('.ajax-pagination-link').forEach(link => {
            link.onclick = function(e) { e.preventDefault(); loadComments(this.getAttribute('href')); };
        });
    }

    function updateTabUI(sortType) {
        const tabLatest = document.getElementById('tab-latest');
        const tabPopular = document.getElementById('tab-popular');
        if (!tabLatest || !tabPopular) return;
        const active = ['bg-white', 'text-brand-green', 'shadow-sm'];
        const inactive = ['text-gray-500', 'hover:text-gray-700'];
        
        tabLatest.classList.remove(...(sortType === 'latest' ? inactive : active));
        tabLatest.classList.add(...(sortType === 'latest' ? active : inactive));
        tabPopular.classList.remove(...(sortType === 'popular' ? inactive : active));
        tabPopular.classList.add(...(sortType === 'popular' ? active : inactive));
    }
</script>
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush