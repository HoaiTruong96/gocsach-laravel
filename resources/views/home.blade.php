@extends('layouts.app')

@section('title', 'Trang Chủ - Góc Sách')

{{-- [STATIC DATA] Slider --}}
@php
    $heroSlides = [
        [
            'title' => 'Cây Cam Ngọt Của Tôi',
            'tag' => 'Sách Của Tháng 12',
            'desc' => '"Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào của trí tưởng tượng..."',
            'image' => 'https://library.hust.edu.vn/sites/default/files/C%C3%A2y%20cam%20ng%E1%BB%8Dt%20c%E1%BB%A7a%20t%C3%B4i%20-%20%E1%BA%A2nh%20b%C3%ACa.jpg',
            'rating' => '4.9/5.0',
        ],
        [
            'title' => 'Nhà Giả Kim',
            'tag' => 'Bán Chạy Nhất',
            'desc' => '"Khi bạn khao khát một điều gì đó, cả vũ trụ sẽ hợp lực giúp bạn đạt được nó."',
            'image' => 'https://baocantho.com.vn/image/news/2017/20170107/fckimage/40361498129094_102.jpg',
            'rating' => '4.8/5.0',
        ],
        [
            'title' => 'Hoàng Tử Bé',
            'tag' => 'Văn Học Kinh Điển',
            'desc' => '"Người ta chỉ nhìn thấy thật rõ ràng bằng trái tim. Cái cốt yếu thì mắt thường không thấy được."',
            'image' => 'https://product.hstatic.net/200000343865/product/hoang-tu-be---tb-2022_f0f2f9b813c246c4878e7e685f683d50_5b46a794d64c4996a6695f6e9e8d3213.jpg',
            'rating' => '5.0/5.0',
        ]
    ];
@endphp

@section('content')
    {{-- SECTION: HERO SLIDER --}}
    <section id="hero-carousel" class="relative text-white py-12 lg:py-16 overflow-hidden bg-[#2A483A] group">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/20 to-transparent pointer-events-none"></div>

        <div class="hero-slider-wrapper flex w-full" id="sliderWrapper">
            @foreach($heroSlides as $index => $slide)
                <div class="w-full flex-shrink-0 px-4 transition-all duration-700">
                    <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 justify-center">
                        <div class="w-full md:w-5/12 flex justify-center md:justify-end perspective-1000">
                            <div class="relative w-48 h-72 md:w-56 md:h-80 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-r-lg rounded-l-sm transform rotate-y-12 hover:rotate-y-0 hover:scale-105 transition-all duration-700 cursor-pointer group/book">
                                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/book:opacity-20 transition-opacity z-20"></div>
                                <img src="{{ $slide['image'] }}" class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-white/10">
                                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-r from-white/30 to-transparent z-10"></div>
                            </div>
                        </div>
                        <div class="w-full md:w-7/12 text-center md:text-left space-y-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-xs font-bold uppercase tracking-widest text-brand-beige">{{ $slide['tag'] }}</span>
                            </div>
                            <h1 class="text-3xl md:text-5xl font-bold leading-tight font-serif text-brand-beige drop-shadow-md">
                                {{ $slide['title'] }}
                            </h1>
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                <div class="flex text-yellow-400 text-lg">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-white/80 text-sm font-medium px-2 py-0.5 bg-white/10 rounded">{{ $slide['rating'] }}</span>
                            </div>
                            <p class="text-gray-200 text-lg font-light italic max-w-2xl leading-relaxed drop-shadow">
                                {{ $slide['desc'] }}
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-2">
                                <a href="#" class="inline-flex items-center justify-center gap-2 bg-brand-accent text-white font-bold px-6 py-3 rounded-full shadow-lg hover:bg-[#c29263] transition-all transform hover:-translate-y-1">
                                    <span>Đọc review</span> <i class="fas fa-arrow-right text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20"><i class="fas fa-chevron-left text-xl"></i></button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20"><i class="fas fa-chevron-right text-xl"></i></button>
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20">
            @foreach($heroSlides as $index => $slide)
                <button onclick="goToSlide({{ $index }})" class="indicator-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-all {{ $index === 0 ? 'bg-brand-accent w-8' : '' }}" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </section>

    {{-- MAIN LAYOUT --}}
    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- [CỘT TRÁI - 8 PHẦN] NỘI DUNG CHÍNH --}}
            <div class="lg:col-span-8 space-y-16">
                
                {{-- SECTION 1: TẠP CHÍ --}}
                <section>
                    <div class="flex justify-between items-end mb-6 border-b border-gray-200 pb-3">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 font-serif mb-1">Tạp Chí Đọc</h2>
                            <p class="text-sm text-gray-500">Góc nhìn sâu sắc về sách và cuộc sống</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-brand-green hover:text-white rounded-full text-xs font-bold transition">Kỹ Năng</a>
                            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-brand-green hover:text-white rounded-full text-xs font-bold transition">Tản Văn</a>
                            <a href="#" class="text-brand-green text-sm font-bold ml-2 flex items-center">Xem thêm <i class="fas fa-chevron-right text-xs ml-1"></i></a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <article class="md:col-span-3 group cursor-pointer">
                            <div class="relative h-64 md:h-80 rounded-2xl overflow-hidden mb-4 shadow-md">
                                <img src="https://images.unsplash.com/photo-1491841550275-ad7854e35ca6?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <span class="absolute top-4 left-4 bg-brand-accent text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Tiêu Điểm</span>
                                <div class="absolute bottom-4 left-4 right-4 text-white">
                                    <div class="text-xs opacity-80 mb-2"><i class="far fa-calendar-alt mr-1"></i> 04/12/2025 • Bởi Minh Tâm</div>
                                    <h3 class="text-2xl font-bold font-serif leading-tight group-hover:text-brand-beige transition">5 Cuốn sách thay đổi hoàn toàn tư duy của bạn về sự thành công</h3>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
                                Thành công không phải là đích đến, mà là một hành trình. Những cuốn sách này sẽ giúp bạn định hình lại cách nhìn nhận thế giới...
                            </p>
                        </article>
                        <div class="md:col-span-2 flex flex-col gap-6">
                            <article class="flex flex-col group cursor-pointer">
                                <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
                                    <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                </div>
                                <div>
                                    <span class="text-brand-green text-xs font-bold uppercase">Mẹo Đọc</span>
                                    <h3 class="font-serif font-bold text-base text-gray-800 leading-snug group-hover:text-brand-green transition mt-1">
                                        Nghệ thuật đọc sách hiệu quả: Đọc ít hiểu nhiều
                                    </h3>
                                </div>
                            </article>
                            <article class="flex flex-col group cursor-pointer">
                                <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
                                    <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                </div>
                                <div>
                                    <span class="text-brand-green text-xs font-bold uppercase">Cảm Hứng</span>
                                    <h3 class="font-serif font-bold text-base text-gray-800 leading-snug group-hover:text-brand-green transition mt-1">
                                        Tại sao sách giấy vẫn có chỗ đứng trong kỷ nguyên số?
                                    </h3>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>

                {{-- SECTION 2: SÁCH MỚI CẬP NHẬT --}}
                <section id="new-books">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 font-serif border-l-4 border-brand-green pl-3">Sách Mới Cập Nhật</h2>
                        <a href="{{ route('list') }}" class="text-xs font-bold px-3 py-1 bg-gray-100 text-gray-500 hover:bg-brand-green hover:text-white rounded-full transition">Xem kho sách</a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @if(isset($books) && $books->count() > 0)
                            @foreach($books->take(4) as $book)
                                @php
                                    $cover = $book->cover_image;
                                    if (!$cover) { $coverUrl = 'https://via.placeholder.com/150x225?text=No+Image'; }
                                    elseif (str_starts_with($cover, 'http')) { $coverUrl = $cover; }
                                    else { $coverUrl = asset('storage/' . $cover); }
                                @endphp
                                <div class="group relative">
                                    <div class="relative w-full aspect-[2/3] rounded-lg overflow-hidden shadow-md mb-3">
                                        <a href="{{ route('detail', $book->id) }}">
                                            <img src="{{ $coverUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110">
                                        </a>
                                        <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">MỚI</div>
                                    </div>
                                    <h3 class="font-serif font-bold text-base text-gray-800 leading-snug mb-1 line-clamp-2 group-hover:text-brand-green transition">
                                        <a href="{{ route('detail', $book->id) }}">{{ $book->title }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500">{{ $book->author_name ?? 'Ẩn danh' }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-full py-8 text-center text-gray-400 bg-gray-50 rounded-lg">Chưa có sách mới.</div>
                        @endif
                    </div>
                    <div class="mt-8 text-center">
                        <a href="{{ route('list') }}" class="inline-block px-8 py-3 bg-gray-100 hover:bg-brand-green hover:text-white text-gray-600 font-bold rounded-full transition duration-300 shadow-sm border border-gray-200">
                            Xem toàn bộ kho sách <i class="fas fa-angle-right ml-1"></i>
                        </a>
                    </div>
                </section>

                {{-- SECTION 3: REVIEW CỘNG ĐỒNG (CẬP NHẬT AJAX LIKE/COMMENT) --}}
                 <section id="community-posts" class="mb-16">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <h2 class="text-2xl font-bold text-gray-800 font-serif border-l-4 border-brand-accent pl-3">Cộng Đồng Review</h2>
                        <div class="bg-gray-100 p-1 rounded-full flex text-xs font-bold">
                            <a href="{{ route('home', ['filter' => 'latest']) }}#community-posts" class="px-4 py-1.5 rounded-full transition {{ ($currentFilter ?? 'latest') == 'latest' ? 'bg-white text-brand-green shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Mới nhất</a>
                            <a href="{{ route('home', ['filter' => 'liked']) }}#community-posts" class="px-4 py-1.5 rounded-full transition {{ ($currentFilter ?? '') == 'liked' ? 'bg-white text-brand-green shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Nổi bật</a>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @if(isset($latestReviews) && $latestReviews->count() > 0)
                            @foreach($latestReviews as $post)
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition duration-300 flex flex-col group" id="post-{{ $post->id }}">
                                    <!-- User Info -->
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name ?? 'User') }}" class="w-10 h-10 rounded-full border border-gray-100 shadow-sm object-cover">
                                            <div>
                                                <h4 class="font-bold text-sm text-gray-800 line-clamp-1">{{ $post->user->name ?? 'Ẩn danh' }}</h4>
                                                <p class="text-[10px] text-gray-400"><i class="far fa-clock"></i> {{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex text-yellow-400 text-xs bg-yellow-50 px-2 py-1 rounded-full border border-yellow-100">
                                            <span class="font-bold mr-1 text-yellow-600">{{ $post->rating }}.0</span><i class="fas fa-star"></i>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-4 flex-grow border-b border-dashed border-gray-100 pb-3 cursor-pointer" onclick="window.location.href='{{ route('book.show', $post->book_id ?? 0) }}'">
                                        <h5 class="text-xs font-bold text-brand-green uppercase mb-1 line-clamp-1">Review: {{ optional($post->book)->title ?? 'Sách đã xóa' }}</h5>
                                        <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">{{ $post->content }}</p>
                                    </div>

                                    <!-- ACTION BUTTONS (ĐÃ SỬA) -->
                                    <div class="flex items-center justify-between text-gray-500 text-xs mb-3">
                                        <div class="flex gap-4">
                                            
                                            <!-- NÚT LIKE: Icon trên, Số dưới -->
                                            <button id="btn-like-{{ $post->id }}" 
                                                    onclick="toggleLike({{ $post->id }})" 
                                                    class="flex flex-col items-center justify-center gap-0.5 min-w-[40px] transition group/like focus:outline-none hover:bg-gray-50 rounded p-1">
                                                
                                                @auth
                                                    @php $isLiked = $post->likes->contains('user_id', Auth::id()); @endphp
                                                @else
                                                    @php $isLiked = false; @endphp
                                                @endauth
                                                
                                                <i id="icon-like-{{ $post->id }}" 
                                                   class="fas fa-heart text-xl transition-transform duration-200 group-hover/like:scale-110 
                                                          {{ $isLiked ? 'text-red-500' : 'text-gray-300 group-hover/like:text-red-400' }}">
                                                </i>
                                                
                                                <!-- Số lượng Tim -->
                                                <span id="count-like-{{ $post->id }}" 
                                                      class="font-bold text-[10px] {{ $isLiked ? 'text-red-500' : 'text-gray-400' }}">
                                                      {{ $post->likes_count ?? 0 }}
                                                </span>
                                            </button>

                                            <!-- Nút Comment -->
                                            <button onclick="toggleCommentBox({{ $post->id }})" class="flex flex-col items-center justify-center gap-0.5 min-w-[40px] hover:text-blue-500 transition group/comment focus:outline-none hover:bg-gray-50 rounded p-1">
                                                <i class="far fa-comment-dots text-xl"></i>
                                                <span id="count-comment-{{ $post->id }}" class="font-bold text-[10px] text-gray-400 group-hover/comment:text-blue-500">
                                                    {{ $post->commentCount ?? 0 }}
                                                </span>
                                            </button>
                                        </div>
                                        
                                        <a href="{{ route('book.show', $post->book_id ?? 0) }}" class="text-brand-green font-bold hover:underline">Chi tiết &rarr;</a>
                                    </div>

                                    <!-- Khu vực Comment (Ẩn) -->
                                    <div id="comment-box-{{ $post->id }}" class="hidden pt-3 border-t border-gray-50">
                                        <div id="comment-list-{{ $post->id }}" class="space-y-2 mb-3 max-h-40 overflow-y-auto">
                                            @foreach($post->comments->take(2) as $comment)
                                                <div class="flex gap-2">
                                                    <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=U' }}" class="w-6 h-6 rounded-full mt-1">
                                                    <div class="bg-gray-50 p-2 rounded-lg text-xs w-full">
                                                        <span class="font-bold text-gray-800">{{ $comment->user->name }}:</span> {{ $comment->content }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="flex gap-2 relative">
                                            <input type="text" id="input-comment-{{ $post->id }}" class="w-full bg-gray-50 border border-gray-200 rounded-full pl-4 pr-10 py-1.5 text-xs outline-none focus:border-brand-green" placeholder="Viết bình luận..." onkeydown="if(event.key === 'Enter') sendComment({{ $post->id }})">
                                            <button onclick="sendComment({{ $post->id }})" class="absolute right-2 top-1 text-brand-green"><i class="fas fa-paper-plane text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>
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
            </div>

            {{-- [CỘT PHẢI - 4 PHẦN] SIDEBAR --}}
            <div class="lg:col-span-4">
                <div class="space-y-8">
                    {{-- Widget 1: Top Thịnh Hành --}}
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-soft">
                        <h3 class="font-serif font-bold text-lg text-gray-800 mb-5 flex items-center gap-2"><span class="text-brand-accent">🔥</span> Top Thịnh Hành</h3>
                        <div class="space-y-4">
                            @foreach(['Cây Cam Ngọt Của Tôi', 'Dế Mèn Phiêu Lưu Ký', 'Hoàng Tử Bé', 'Nhà Giả Kim', 'Mắt Biếc'] as $index => $title)
                                <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition cursor-pointer group">
                                    <span class="font-bold text-gray-400 w-6 text-center text-lg italic group-hover:text-brand-accent transition">{{ $index + 1 }}</span>
                                    <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0 shadow-sm"><img src="https://source.unsplash.com/random/200x300?book,sig={{ $index }}" class="w-full h-full object-cover"></div>
                                    <div><h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-green transition">{{ $title }}</h4><span class="text-xs text-yellow-500">★★★★★ (4.8)</span></div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    {{-- Widget 2: Thể Loại --}}
                    <div class="bg-brand-beige/30 rounded-xl p-6 border border-brand-beige">
                        <h3 class="font-serif font-bold text-lg text-brand-green mb-4">Thể Loại</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Tiểu Thuyết', 'Kinh Tế', 'Tâm Lý', 'Trinh Thám', 'Lịch Sử', 'Khoa Học', 'Thiếu Nhi'] as $tag)
                                <a href="{{ route('list') }}" class="bg-white text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-100 hover:border-brand-accent hover:text-brand-accent transition shadow-sm">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<style>
    @keyframes pingShort { 0% { transform: scale(1); } 50% { transform: scale(1.3); } 100% { transform: scale(1); } }
    .animate-ping-short { animation: pingShort 0.3s cubic-bezier(0, 0, 0.2, 1); }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #888; }
</style>
<script>
    // Slider Logic
    let currentSlide = 0;
    const totalSlides = {{ count($heroSlides) }};
    const sliderWrapper = document.getElementById('sliderWrapper');
    function updateSlider() { if (!sliderWrapper) return; sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`; }
    function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; updateSlider(); }
    function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; updateSlider(); }
    function goToSlide(index) { currentSlide = index; updateSlider(); }
    if (totalSlides > 0) setInterval(nextSlide, 5000);

    function toggleLike(postId) {
        console.log("Bấm Like ID:", postId); // Kiểm tra xem hàm có chạy không (F12 -> Console)

        const btn = document.getElementById(`btn-like-${postId}`);
        if (!btn) return console.error("Không tìm thấy nút like");
        
        if (btn.classList.contains('pointer-events-none')) return;
        btn.classList.add('pointer-events-none', 'opacity-50'); // Khóa nút

        fetch(`/post/${postId}/like`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            }
        })
        .then(res => {
            if(res.status === 401) {
                alert('Vui lòng đăng nhập!');
                window.location.href = '/login';
                throw new Error('Unauthorized');
            }
            if(!res.ok) throw new Error('Lỗi mạng hoặc Server');
            return res.json();
        })
        .then(data => {
            console.log("Server trả về:", data); // Xem kết quả từ server

            btn.classList.remove('pointer-events-none', 'opacity-50'); // Mở khóa

            if(data.error) { alert(data.error); return; }
            
            const icon = document.getElementById(`icon-like-${postId}`);
            const countSpan = document.getElementById(`count-like-${postId}`);
            
            // Cập nhật số lượng
            if(countSpan) countSpan.innerText = data.count; 
            
            // Cập nhật màu sắc
            if (data.liked) {
                icon.classList.remove('text-gray-300', 'group-hover/like:text-red-400');
                icon.classList.add('text-red-500');
                countSpan.classList.add('text-red-500');
                countSpan.classList.remove('text-gray-400');
            } else {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-300', 'group-hover/like:text-red-400');
                countSpan.classList.remove('text-red-500');
                countSpan.classList.add('text-gray-400');
            }
        })
        .catch(err => {
            console.error('Lỗi Like:', err);
            btn.classList.remove('pointer-events-none', 'opacity-50');
        });
    }

    function toggleCommentBox(postId) {
        document.getElementById(`comment-box-${postId}`).classList.toggle('hidden');
    }

    function sendComment(postId) {
        const input = document.getElementById(`input-comment-${postId}`);
        const content = input.value.trim();
        if (!content) return;

        input.disabled = true;

        fetch(`/post/${postId}/comment`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ content: content })
        })
        .then(res => res.json())
        .then(data => {
            input.disabled = false;
            if(data.error) { alert(data.error); return; }
            input.value = '';
            document.getElementById(`count-comment-${postId}`).innerText = data.count; // Cập nhật số comment
            
            const list = document.getElementById(`comment-list-${postId}`);
            list.insertAdjacentHTML('beforeend', `
                <div class="flex gap-2">
                    <img src="${data.avatar}" class="w-6 h-6 rounded-full mt-1">
                    <div class="bg-gray-50 p-2 rounded-lg text-xs w-full">
                        <span class="font-bold text-gray-800">${data.user_name}:</span> ${data.content}
                    </div>
                </div>`);
        })
        .catch(err => {
            console.error(err);
            input.disabled = false;
        });
    }
</script>
@endpush