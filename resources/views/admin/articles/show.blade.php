@extends('layouts.app')

@section('title', $article->title ?? 'Tạp Chí Góc Sách')

@section('content')
    {{-- CSS riêng cho bài viết --}}
    <style>
        .article-content h2 { font-size: 1.5rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 0.5rem; color: #111827; }
        .article-content h3 { font-size: 1.25rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 0.5rem; color: #374151; }
        .article-content p { margin-bottom: 1rem; line-height: 1.8; color: #4B5563; }
        .article-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1rem; }
        .article-content img { border-radius: 0.75rem; margin: 1.5rem 0; width: 100%; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .article-content blockquote { border-left: 4px solid #10B981; padding-left: 1rem; font-style: italic; color: #6B7280; background: #F9FAFB; padding: 1rem; border-radius: 0 0.5rem 0.5rem 0; }
    </style>

    {{-- [BREADCRUMB] --}}
    <div class="bg-gray-50 border-b border-gray-200 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex text-sm font-medium text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2">/</span>
                <span class="text-brand-green font-bold truncate max-w-[300px]">{{ $article->title }}</span>
            </nav>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- [CỘT TRÁI - 8 PHẦN] NỘI DUNG BÀI VIẾT --}}
            <div class="lg:col-span-8">
                <article class="bg-white rounded-2xl p-0 md:p-8">
                    
                    {{-- 1. Header Bài Viết --}}
                    <header class="mb-8">
                        <div class="flex items-center gap-3 text-sm text-gray-500 mb-4">
                            <span class="bg-brand-green/10 text-brand-green px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                {{ $article->tag ?? 'Góc Nhìn' }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1"><i class="far fa-calendar-alt"></i> {{ $article->created_at->format('d/m/Y') }}</span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif leading-tight mb-6">
                            {{ $article->title }}
                        </h1>

                        <div class="flex items-center justify-between border-y border-gray-100 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'A') }}&background=random" 
                                     class="w-10 h-10 rounded-full border border-gray-100">
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $article->user->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">Tác giả</p>
                                </div>
                            </div>
                            
                            {{-- Social Share (Demo) --}}
                            <div class="flex gap-2">
                                <button class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f"></i></button>
                                <button class="w-8 h-8 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition"><i class="fab fa-twitter"></i></button>
                                <button class="w-8 h-8 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-gray-600 hover:text-white transition"><i class="fas fa-link"></i></button>
                            </div>
                        </div>
                    </header>

                    {{-- 2. Ảnh Cover Lớn --}}
                    @if($article->thumbnail)
                        <div class="mb-10 rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ Str::startsWith($article->thumbnail, 'http') ? $article->thumbnail : asset('storage/' . $article->thumbnail) }}" 
                                 class="w-full h-auto object-cover" 
                                 alt="{{ $article->title }}">
                        </div>
                    @endif

                    {{-- 3. Nội Dung Chính --}}
                    <div class="article-content text-lg text-gray-700 text-justify">
                        {{-- Hiển thị mô tả ngắn (Sapo) --}}
                        @if($article->excerpt)
                            <p class="font-bold text-gray-800 italic mb-6 text-xl border-l-4 border-brand-accent pl-4">
                                {{ $article->excerpt }}
                            </p>
                        @endif

                        {{-- Nội dung HTML từ CKEditor --}}
                        {!! $article->content !!}
                    </div>

                    {{-- 4. Footer Bài Viết --}}
                    <div class="mt-12 pt-8 border-t border-gray-100">
                        <h4 class="font-bold text-gray-800 mb-4">Bài viết liên quan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Placeholder cho bài liên quan --}}
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 flex gap-3 items-center cursor-pointer hover:bg-gray-100 transition">
                                <div class="w-16 h-16 bg-gray-200 rounded-md overflow-hidden flex-shrink-0">
                                    <img src="https://source.unsplash.com/random/100x100?book" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="text-[10px] text-brand-green font-bold uppercase">Mẹo đọc</span>
                                    <h5 class="text-sm font-bold text-gray-800 line-clamp-2">Làm sao để đọc sách hiệu quả hơn mỗi ngày?</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </article>
            </div>

            {{-- [CỘT PHẢI - 4 PHẦN] SIDEBAR --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- Widget: Giới thiệu --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="font-serif font-bold text-lg text-gray-800 mb-4">Về Tạp Chí</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Góc Sách Magazine là nơi chia sẻ những câu chuyện thú vị xoay quanh văn hóa đọc, phỏng vấn tác giả và những tips hay ho cho mọt sách.
                    </p>
                    <a href="{{ route('home') }}" class="text-brand-green text-sm font-bold hover:underline">Xem thêm bài viết &rarr;</a>
                </div>

                {{-- Widget: Mua Sách (Tái sử dụng từ Home) --}}
                <div class="bg-brand-beige/20 p-6 rounded-xl border border-brand-beige sticky top-24">
                    <h3 class="font-serif font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                        <span class="text-brand-accent">🛒</span> Mua Sách Online
                    </h3>
                    <div class="space-y-3">
                        <a href="#" class="block bg-white p-3 rounded-lg text-sm font-bold text-gray-700 hover:text-blue-600 hover:shadow-md transition text-center border border-gray-200">
                            Mua trên Tiki
                        </a>
                        <a href="#" class="block bg-white p-3 rounded-lg text-sm font-bold text-gray-700 hover:text-orange-600 hover:shadow-md transition text-center border border-gray-200">
                            Mua trên Shopee
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection