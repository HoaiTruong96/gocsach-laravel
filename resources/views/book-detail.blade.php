@extends('layouts.app')

{{-- Đặt tiêu đề trang --}}
@section('title', 'Chi Tiết Sách - ' . ($book->title ?? 'Góc Sách'))

@section('content')
    {{-- Style riêng cho trang này --}}
    <style>
        html { scroll-behavior: smooth; }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    {{-- [BREADCRUMB] Thanh điều hướng --}}
    <div class="bg-brand-beige/40 py-4 border-b border-brand-beige/50">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('list') }}" class="hover:text-brand-green transition">
                    @if(isset($book->categories) && $book->categories->isNotEmpty())
                        {{ $book->categories->first()->name }}
                    @else
                        Sách
                    @endif
                </a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold truncate max-w-[200px]">{{ $book->title ?? 'Chi tiết sách' }}</span>
            </div>
        </div>
    </div>

    {{-- [MAIN CONTENT] --}}
    <main class="container mx-auto px-4 py-12 flex-grow">
        
        {{-- Flash Message (Thông báo thành công) --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <span class="font-medium ml-2">{{ session('success') }}</span>
            </div>
        @endif

        {{-- 1. BOOK HERO SECTION (Thông tin sách) --}}
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-soft border border-gray-100 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-green/5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 relative z-10">
                
                {{-- Ảnh Bìa --}}
                <div class="md:col-span-4 lg:col-span-3">
                    <div class="relative w-full aspect-[2/3] rounded-r-lg rounded-l-sm shadow-book transform hover:scale-[1.02] transition duration-500 cursor-pointer group">
                        <img src="{{ !empty($book->cover_image) ? $book->cover_image : 'https://via.placeholder.com/300x450?text=No+Image' }}" 
                             alt="{{ $book->title ?? 'Book Cover' }}" 
                             class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-gray-200"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    </div>
                </div>

                {{-- Thông Tin Chi Tiết --}}
                <div class="md:col-span-8 lg:col-span-9 flex flex-col justify-center">
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-brand-accent/10 text-brand-accent text-xs font-bold uppercase tracking-wider mb-3 border border-brand-accent/20">
                            @if(isset($book->categories) && $book->categories->isNotEmpty())
                                {{ $book->categories->first()->name }}
                            @else
                                Văn Học
                            @endif
                        </span>
                        <h1 class="text-3xl md:text-5xl font-bold text-brand-green font-serif mt-1 mb-3 leading-tight">
                            {{ $book->title ?? 'Tiêu đề sách' }}
                        </h1>
                        <div class="flex items-center gap-4 text-sm font-medium">
                            <span class="text-gray-500">Tác giả: 
                                <span class="text-brand-green font-bold">
                                    {{ $book->author_name ?? 'Đang cập nhật' }}
                                </span>
                            </span>
                            <span class="text-gray-300">|</span>
                            <a href="#reviews" class="flex items-center text-yellow-400 hover:opacity-80 transition cursor-pointer">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-500 ml-2 text-xs">({{ $book->avg_rating ?? '0' }}/5 từ cộng đồng)</span>
                            </a>
                        </div>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-8 text-lg font-light italic line-clamp-3">
                        {{ $book->description ?? 'Chưa có mô tả cho cuốn sách này.' }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-sm">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Nhà xuất bản</p>
                            <p class="font-bold text-brand-green">{{ $book->publisher ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Năm xuất bản</p>
                            <p class="font-bold text-brand-green">{{ $book->published_year ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Lượt xem</p>
                            <p class="font-bold text-brand-green">{{ number_format($book->view_count) }}</p>
                        </div>
                    </div>

                    <div class="mt-auto flex flex-col sm:flex-row gap-4 items-center">
                        <a href="#reviews" class="group flex items-center justify-center gap-2 px-8 py-3.5 rounded-full border-2 border-brand-green text-brand-green font-bold hover:bg-brand-green hover:text-white transition-all duration-300 min-w-[200px] shadow-sm hover:shadow-lg">
                            <i class="far fa-comments text-lg"></i>
                            <span>Đọc Review</span>
                        </a>
                        <a href="#" class="flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-brand-accent text-white font-bold shadow-lg hover:bg-[#c29263] hover:-translate-y-1 transition-all duration-300 min-w-[200px]">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Mua Sách Ngay</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- 2. CỘT TRÁI (Nội dung & Review) --}}
            <div class="lg:col-span-8 space-y-10">
                {{-- Giới Thiệu --}}
                <div class="bg-white rounded-2xl p-8 shadow-soft border border-gray-100">
                    <h2 class="text-2xl font-bold text-brand-green font-serif mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <span class="w-8 h-8 rounded-full bg-brand-green/10 flex items-center justify-center text-brand-green text-sm"><i class="fas fa-align-left"></i></span>
                        Giới Thiệu Sách
                    </h2>
                    <div class="prose prose-stone max-w-none text-gray-600 leading-8 text-justify">
                        {!! nl2br(e($book->description)) !!}
                    </div>
                </div>

                {{-- Đánh Giá Nổi Bật --}}
                <div id="reviews" class="bg-white rounded-2xl p-8 shadow-soft border border-gray-100 scroll-mt-24">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <h2 class="text-2xl font-bold text-brand-green font-serif flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-sm"><i class="fas fa-star"></i></span>
                            Đánh Giá Nổi Bật
                        </h2>
                        
                        @auth
                        <button class="text-sm font-bold text-brand-accent hover:text-brand-brown transition">
                            <i class="fas fa-pen mr-1"></i> Viết đánh giá
                        </button>
                        @endauth
                    </div>

                    {{-- Logic lấy 2 bài review nhiều view nhất --}}
                    @php
                        $topReviews = $book->posts->where('status', 'published')->sortByDesc('view_count')->take(2);
                    @endphp

                    @if($topReviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($topReviews as $review)
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 transition hover:shadow-md cursor-pointer"
                                     onclick="window.location.href='#'"> {{-- Link tới chi tiết review sau này --}}
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random&size=48" 
                                                 class="w-10 h-10 rounded-full border border-white shadow-sm">
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center mb-1">
                                                <h4 class="font-bold text-gray-800 text-sm">{{ $review->user->name }}</h4>
                                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            
                                            <div class="flex text-yellow-400 text-xs mb-2">
                                                @for($i=0; $i < round($review->rating); $i++) <i class="fas fa-star"></i> @endfor
                                                @for($i=0; $i < 5 - round($review->rating); $i++) <i class="far fa-star text-gray-300"></i> @endfor
                                            </div>

                                            <h5 class="font-bold text-brand-green mb-1 text-sm">"{{ $review->title }}"</h5>
                                            <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed mb-3">
                                                {{ Str::limit(strip_tags($review->content), 200) }}
                                            </p>
                                            
                                            <div class="flex gap-4 text-xs text-gray-400 border-t border-gray-200 pt-2">
                                                <span class="flex items-center"><i class="far fa-eye mr-1"></i> {{ $review->view_count }} lượt xem</span>
                                                <span class="flex items-center cursor-pointer hover:text-red-500 transition"><i class="far fa-heart mr-1"></i> Thích</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 text-center">
                            <a href="{{ route('book.reviews', $book->slug) }}" class="inline-block px-8 py-3 rounded-full border border-brand-green text-brand-green font-bold text-sm hover:bg-brand-green hover:text-white transition shadow-sm">
    Xem tất cả đánh giá
</a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i class="far fa-comment-dots text-2xl"></i>
                            </div>
                            <p class="text-gray-500 mb-4">Chưa có bài đánh giá nào nổi bật.</p>
                            @auth
                                <button class="bg-brand-green text-white px-6 py-2 rounded-lg font-bold shadow-sm hover:bg-brand-green-light">
                                    Hãy là người đầu tiên review
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="text-brand-green font-bold hover:underline">Đăng nhập để viết review</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

            {{-- 3. CỘT PHẢI (Sidebar) --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100">
                    <h3 class="font-serif font-bold text-lg text-brand-green mb-6 pb-2 border-b border-gray-100">Thông Tin Tác Giả</h3>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-brand-beige mb-4 shadow-md">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($book->author_name ?? 'TG') }}&background=random&size=128" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-bold text-xl text-gray-800 font-serif mb-1">{{ $book->author_name ?? 'N/A' }}</h4>
                        <span class="text-xs text-brand-accent font-bold uppercase tracking-wide mb-4">Tác giả</span>
                        <button class="w-full text-brand-green text-sm font-bold border border-brand-green rounded-full px-4 py-2.5 hover:bg-brand-green hover:text-white transition">Xem thêm tác phẩm</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection