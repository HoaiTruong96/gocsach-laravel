@extends('layouts.app')

@section('title', 'Trang Chủ - Góc Sách')

{{-- [FIX] Định nghĩa biến ở đây để dùng được cho cả @section('content') và @push('scripts') --}}
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
    <section id="hero-carousel" class="relative text-white py-12 lg:py-16 overflow-hidden bg-[#2A483A] group">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/20 to-transparent pointer-events-none"></div>

        <!-- Slider Wrapper -->
        <div class="hero-slider-wrapper flex w-full" id="sliderWrapper">
            @foreach($heroSlides as $index => $slide)
                <div class="w-full flex-shrink-0 px-4 transition-all duration-700">
                    <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 justify-center">
                        <!-- Book Image -->
                        <div class="w-full md:w-5/12 flex justify-center md:justify-end perspective-1000">
                            <div class="relative w-48 h-72 md:w-56 md:h-80 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-r-lg rounded-l-sm transform rotate-y-12 hover:rotate-y-0 hover:scale-105 transition-all duration-700 cursor-pointer group/book">
                                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover/book:opacity-20 transition-opacity z-20"></div>
                                <img src="{{ $slide['image'] }}" class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-white/10">
                                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-r from-white/30 to-transparent z-10"></div>
                            </div>
                        </div>
                        
                        <!-- Content -->
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
                                    <span>Đọc Review</span> <i class="fas fa-arrow-right text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20">
            <i class="fas fa-chevron-left text-xl"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/20 hover:bg-brand-accent/80 text-white flex items-center justify-center backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 hover:scale-110 z-20">
            <i class="fas fa-chevron-right text-xl"></i>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20">
            @foreach($heroSlides as $index => $slide)
                <button onclick="goToSlide({{ $index }})" class="indicator-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-all {{ $index === 0 ? 'bg-brand-accent w-8' : '' }}" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- CỘT TRÁI (Nội dung chính) -->
            <div class="lg:col-span-8 space-y-16">
                
                <!-- SECTION: GÓC NHÌN & SUY NGẪM (Tạp Chí Đọc) -->
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
                        <!-- Bài viết chính -->
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

                        <!-- Danh sách bài phụ -->
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

                <!-- SECTION: REVIEW SÁCH (Compact Grid) -->
                <section>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 font-serif border-l-4 border-brand-accent pl-3">Review Cộng Đồng</h2>
                        <div class="hidden sm:flex gap-2">
                            <button class="text-xs font-bold px-3 py-1 bg-brand-green text-white rounded-full">Mới nhất</button>
                            <button class="text-xs font-bold px-3 py-1 bg-gray-100 text-gray-500 hover:bg-gray-200 rounded-full transition">Đọc nhiều</button>
                            <button class="text-xs font-bold px-3 py-1 bg-gray-100 text-gray-500 hover:bg-gray-200 rounded-full transition">Điểm cao</button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Kiểm tra nếu biến $books tồn tại --}}
                        @if(isset($books))
                            @forelse($books as $book)
                                @php
                                    $authorName = 'Ẩn danh';
                                    if (is_object($book->author)) $authorName = $book->author->name ?? $authorName;
                                    elseif (is_string($book->author)) {
                                        $trimmed = trim($book->author);
                                        $authorName = str_starts_with($trimmed, '{') ? (json_decode($trimmed)->name ?? $book->author) : $book->author;
                                    }

                                    $categoryName = 'Chưa phân loại';
                                    if (isset($book->category)) {
                                        if (is_object($book->category)) $categoryName = $book->category->name ?? $categoryName;
                                        elseif (is_string($book->category)) {
                                            $trimmedCat = trim($book->category);
                                            $categoryName = str_starts_with($trimmedCat, '{') ? (json_decode($trimmedCat)->name ?? $book->category) : $book->category;
                                        }
                                    }
                                @endphp

                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-card transition-all duration-300 group flex flex-col h-full">
                                    <div class="p-4 flex gap-4">
                                        <div class="w-24 h-36 flex-shrink-0 rounded-lg overflow-hidden shadow-md relative">
                                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}" 
                                                 class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110"
                                                 onerror="this.src='https://via.placeholder.com/150x225?text=No+Image'">
                                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                                        </div>

                                        <div class="flex-1 flex flex-col">
                                            <div class="flex justify-between items-start">
                                                <span class="text-[10px] font-bold uppercase text-brand-green bg-brand-green/10 px-2 py-0.5 rounded">{{ $categoryName }}</span>
                                                <div class="flex text-yellow-400 text-xs gap-0.5">
                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                                </div>
                                            </div>

                                            <h3 class="font-serif font-bold text-lg text-gray-800 mt-2 mb-1 leading-tight group-hover:text-brand-accent transition cursor-pointer">
                                                <a href="{{ route('book.show', $book->id) }}">{{ $book->title }}</a>
                                            </h3>
                                            
                                            <p class="text-xs text-gray-500 mb-3">bởi <span class="font-semibold">{{ $authorName }}</span></p>
                                            
                                            <p class="text-xs text-gray-500 line-clamp-2 mb-3 flex-grow">
                                                {{ $book->description ?? 'Chưa có mô tả.' }}
                                            </p>

                                            <div class="flex items-center justify-between border-t border-gray-50 pt-2 mt-auto">
                                                <div class="flex items-center gap-1">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background=random&size=16" class="w-4 h-4 rounded-full">
                                                    <span class="text-[10px] text-gray-400">{{ $book->created_at ? $book->created_at->format('d/m') : 'N/A' }}</span>
                                                </div>
                                                <a href="{{ route('book.show', $book->id) }}" class="text-xs font-bold text-brand-green hover:underline">Chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-10 text-center text-gray-500 bg-white rounded-xl border border-dashed">
                                    Chưa có sách nào.
                                </div>
                            @endforelse
                        @else
                            <div class="col-span-full py-10 text-center text-gray-500 bg-white rounded-xl border border-dashed">
                                Đang cập nhật dữ liệu sách...
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        <nav class="flex items-center gap-2">
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:border-brand-green hover:text-brand-green transition bg-white text-sm"><i class="fas fa-chevron-left"></i></a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg bg-brand-green text-white font-bold text-sm shadow-md">1</a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-brand-cream hover:border-brand-green hover:text-brand-green transition bg-white text-sm">2</a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-brand-cream hover:border-brand-green hover:text-brand-green transition bg-white text-sm">3</a>
                            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:border-brand-green hover:text-brand-green transition bg-white text-sm"><i class="fas fa-chevron-right"></i></a>
                        </nav>
                    </div>
                </section>

                <!-- SECTION: BANNER SỰ KIỆN -->
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

            <!-- RIGHT COLUMN (Sidebar) -->
            <div class="lg:col-span-4">
                <div class="space-y-8">
                    <!-- Widget Trending -->
                    <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-soft">
                        <h3 class="font-serif font-bold text-lg text-gray-800 mb-5 flex items-center gap-2">
                            <span class="text-brand-accent">🔥</span> Top Thịnh Hành
                        </h3>
                        <div class="space-y-4">
                             @foreach(['Cây Cam Ngọt Của Tôi', 'Dế Mèn Phiêu Lưu Ký', 'Hoàng Tử Bé', 'Nhà Giả Kim', 'Mắt Biếc'] as $index => $title)
                                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    <span class="font-bold text-gray-400 w-4 text-center">{{ $index + 1 }}</span>
                                    <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                        <img src="https://source.unsplash.com/random/200x300?book,sig={{ $index }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-800 line-clamp-1">{{ $title }}</h4>
                                        <span class="text-xs text-yellow-500">★★★★★ (4.8)</span>
                                    </div>
                                </div>
                             @endforeach
                        </div>
                    </div>

                    <!-- Widget Categories -->
                    <div class="bg-brand-beige/30 rounded-xl p-6 border border-brand-beige">
                        <h3 class="font-serif font-bold text-lg text-brand-green mb-4">Thể Loại</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Tiểu Thuyết', 'Kinh Tế', 'Tâm Lý', 'Trinh Thám', 'Lịch Sử', 'Khoa Học', 'Thiếu Nhi'] as $tag)
                                <a href="#" class="bg-white text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-100 hover:border-brand-accent hover:text-brand-accent transition shadow-sm">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    // Slider Logic Script
    let currentSlide = 0;
    // [FIX] Bây giờ biến $heroSlides đã được định nghĩa ở phạm vi toàn cục của view, nên count() sẽ hoạt động đúng
    const totalSlides = {{ count($heroSlides) }};
    const sliderWrapper = document.getElementById('sliderWrapper');
    const dots = document.querySelectorAll('.indicator-dot');

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

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
    }

    if (totalSlides > 0) {
        setInterval(nextSlide, 5000);
    }
</script>
@endpush