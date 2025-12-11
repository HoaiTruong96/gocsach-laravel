@extends('layouts.app')

@section('title', 'Chi Tiết Sách - ' . ($book->title ?? 'Góc Sách'))

@section('content')
    <style>
        html { scroll-behavior: smooth; }
        .text-justify-last-left { text-align: justify; text-align-last: left; }
    </style>

    {{-- [BREADCRUMB] --}}
    <div class="bg-brand-beige/40 py-4 border-b border-brand-beige/50">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('list') }}" class="hover:text-brand-green transition">
                    {{ isset($book->categories) && $book->categories->isNotEmpty() ? $book->categories->first()->name : 'Sách' }}
                </a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold truncate max-w-[200px]">{{ $book->title ?? 'Chi tiết sách' }}</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow">
        
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm max-w-4xl mx-auto">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <span class="font-medium ml-2">{{ session('success') }}</span>
            </div>
        @endif

        {{-- 1. HERO SECTION (Giữ nguyên) --}}
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-soft border border-gray-100 mb-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-green/5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 relative z-10">
                {{-- Ảnh Bìa --}}
                <div class="md:col-span-4 lg:col-span-3">
                    <div class="relative w-full aspect-[2/3] rounded-r-lg rounded-l-sm shadow-book transform hover:scale-[1.02] transition duration-500 cursor-pointer group">
                        <img src="{{ !empty($book->cover_image) ? $book->cover_image : 'https://via.placeholder.com/300x450?text=No+Image' }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-gray-200"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    </div>
                </div>

                {{-- Thông Tin Chi Tiết --}}
                <div class="md:col-span-8 lg:col-span-9 flex flex-col justify-center">
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-brand-accent/10 text-brand-accent text-xs font-bold uppercase tracking-wider mb-3 border border-brand-accent/20">
                            {{ $book->categories->isNotEmpty() ? $book->categories->first()->name : 'Văn Học' }}
                        </span>
                        <h1 class="text-3xl md:text-5xl font-bold text-brand-green font-serif mt-1 mb-3 leading-tight">
                            {{ $book->title ?? 'Tiêu đề sách' }}
                        </h1>
                        <div class="flex items-center gap-4 text-sm font-medium">
                            <span class="text-gray-500">Tác giả: 
                                <span class="text-brand-green font-bold">{{ $book->author_name ?? 'Đang cập nhật' }}</span>
                            </span>
                            <span class="text-gray-300">|</span>
                            <a href="#reviews" class="flex items-center text-yellow-400 hover:opacity-80 transition cursor-pointer">
                                <i class="fas fa-star"></i><span class="text-gray-500 ml-2 text-xs">({{ $book->avg_rating ?? '0' }}/5)</span>
                            </a>
                        </div>
                    </div>

                    {{-- Mô tả ngắn --}}
                    <p class="text-gray-600 leading-relaxed mb-8 text-lg font-light italic line-clamp-3">
                        {{ $book->description ?? 'Chưa có mô tả ngắn.' }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-sm">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Nhà xuất bản</p>
                            <p class="font-bold text-brand-green">{{ $book->publisher ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Năm</p>
                            <p class="font-bold text-brand-green">{{ $book->published_year ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Lượt xem</p>
                            <p class="font-bold text-brand-green">{{ number_format($book->view_count) }}</p>
                        </div>
                    </div>

                    <div class="mt-auto flex flex-col sm:flex-row gap-4 items-center">
                        <a href="#main-content" class="group flex items-center justify-center gap-2 px-8 py-3.5 rounded-full border-2 border-brand-green text-brand-green font-bold hover:bg-brand-green hover:text-white transition-all duration-300 min-w-[200px] shadow-sm hover:shadow-lg">
                            <i class="fas fa-book-open text-lg"></i>
                            <span>Đọc Nội Dung</span>
                        </a>
                        <a href="#" class="flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-brand-accent text-white font-bold shadow-lg hover:bg-[#c29263] hover:-translate-y-1 transition-all duration-300 min-w-[200px]">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Mua Sách Ngay</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. LAYOUT GIỮA (SINGLE COLUMN) --}}
        <div id="main-content" class="max-w-4xl mx-auto space-y-12">
            
            {{-- A. GIỚI THIỆU NỘI DUNG (LẤY TỪ BẢNG POSTS) --}}
            <section>
                <div class="flex items-center gap-4 mb-8 border-b border-gray-100 pb-4">
                    <span class="w-10 h-10 rounded-full bg-brand-green/10 flex items-center justify-center text-brand-green">
                        <i class="fas fa-align-left"></i>
                    </span>
                    <h2 class="text-2xl font-bold text-gray-800 font-serif">Nội Dung Chi Tiết</h2>
                </div>

                @php
                    // Lấy bài viết published mới nhất của sách này
                    $mainPost = $book->posts->where('status', 'published')->sortByDesc('created_at')->first();
                @endphp

                @if($mainPost)
                    <article class="bg-white rounded-2xl p-0 md:p-2">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4 font-serif">{{ $mainPost->title }}</h1>
                        
                        <div class="flex items-center gap-3 text-sm text-gray-500 mb-6">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mainPost->user->name ?? 'Admin') }}&background=random&size=32" class="w-8 h-8 rounded-full">
                            <span class="font-medium text-gray-700">{{ $mainPost->user->name ?? 'Quản trị viên' }}</span>
                            <span>•</span>
                            <span>{{ $mainPost->created_at->format('d/m/Y') }}</span>
                        </div>

                        @if(!empty($mainPost->thumbnail))
                            <div class="mb-8 rounded-2xl overflow-hidden shadow-sm aspect-[21/9]">
                                <img src="{{ Str::startsWith($mainPost->thumbnail, 'http') ? $mainPost->thumbnail : asset($mainPost->thumbnail) }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="prose prose-stone prose-lg max-w-none text-gray-700 text-justify-last-left">
                            {!! $mainPost->content !!}
                        </div>
                    </article>
                @else
                    <div class="bg-gray-50 p-8 rounded-2xl text-center border border-dashed border-gray-300">
                        <p class="text-gray-500 italic">Nội dung chi tiết đang được cập nhật...</p>
                        @if(!empty($book->description))
                            <div class="mt-4 text-justify text-gray-600">{!! nl2br(e($book->description)) !!}</div>
                        @endif
                    </div>
                @endif
            </section>

            {{-- B. THÔNG TIN TÁC GIẢ --}}
            <section class="bg-stone-50 rounded-2xl p-8 border border-stone-200/60 flex flex-col md:flex-row items-center md:items-start gap-8">
                <div class="flex-shrink-0 relative">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($book->author_name ?? 'TG') }}&background=random&size=128" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute bottom-0 right-0 bg-brand-green text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white">TG</div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="font-serif font-bold text-xl text-gray-900 mb-2">{{ $book->author_name ?? 'Tác giả' }}</h3>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                        Theo dõi tác giả để nhận thông báo về những tác phẩm mới nhất.
                    </p>
                    <button class="px-6 py-2 bg-white border border-gray-300 text-gray-700 font-bold rounded-full text-sm hover:border-brand-green hover:text-brand-green transition shadow-sm">
                        Xem tác phẩm khác
                    </button>
                </div>
            </section>

            {{-- C. BÌNH LUẬN VÀ ĐÁNH GIÁ (SỬA LẠI LOGIC LẤY COMMENT) --}}
            <section id="reviews" class="scroll-mt-24 pt-4">
                {{-- [QUAN TRỌNG] Logic lấy comments gián tiếp: Book -> Posts -> Comments --}}
                @php
                    // Lấy danh sách comments từ tất cả bài post của sách này
                    $comments = collect();
                    if($book->posts->isNotEmpty()) {
                        foreach($book->posts as $post) {
                            if($post->comments->isNotEmpty()) {
                                $comments = $comments->merge($post->comments);
                            }
                        }
                    }
                    // Sắp xếp comment mới nhất lên đầu
                    $comments = $comments->sortByDesc('created_at');
                @endphp

                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <span class="w-1 h-8 bg-yellow-400 rounded-full"></span>
                        <h2 class="text-2xl font-bold text-gray-800 font-serif">Bình Luận & Đánh Giá</h2>
                        
                        {{-- Hiển thị số lượng comment --}}
                        <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-1 rounded-md ml-2">
                            {{ $comments->count() }}
                        </span>
                    </div>
                    
                    @auth
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-black text-white text-sm font-bold rounded-full hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            <i class="fas fa-pen"></i> Viết đánh giá
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="text-brand-green font-bold text-sm hover:underline">Đăng nhập để bình luận</a>
                    @endauth
                </div>

                <div class="space-y-8">
                    @if($comments->count() > 0)
                        @foreach($comments as $comment)
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                                <div class="flex items-start gap-4">
                                    {{-- Avatar User --}}
                                    <div class="flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'U') }}&background=random&size=48" 
                                             class="w-12 h-12 rounded-full border border-gray-100">
                                    </div>
                                    
                                    {{-- Nội dung Comment --}}
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm">{{ $comment->user->name ?? 'Người dùng' }}</h4>
                                                <div class="flex items-center gap-2 mt-1">
                                                    {{-- Hiển thị sao đánh giá (nếu có) --}}
                                                    @if(isset($comment->rating))
                                                        <div class="flex text-yellow-400 text-xs">
                                                            @for($i=0; $i < $comment->rating; $i++) <i class="fas fa-star"></i> @endfor
                                                            @for($i=0; $i < 5 - $comment->rating; $i++) <i class="far fa-star text-gray-300"></i> @endfor
                                                        </div>
                                                        <span class="text-gray-300 text-xs">•</span>
                                                    @endif
                                                    <span class="text-xs text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                                            {{ $comment->content }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 bg-stone-50 rounded-2xl border border-dashed border-stone-300">
                            <i class="far fa-comments text-4xl text-gray-300 mb-3 block"></i>
                            <p class="text-gray-500">Chưa có bình luận nào. Hãy là người đầu tiên đánh giá!</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
@endsection