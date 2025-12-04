{{-- [FIX] Tạo dữ liệu giả cho biến $book để test giao diện khi chưa có Controller --}}
@php
    // Giả lập đối tượng sách (Mock Data)
    $book = new stdClass();
    $book->id = 1;
    $book->title = 'Cây Cam Ngọt Của Tôi';
    $book->cover_image = 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=800';
    $book->view_count = 1250;
    $book->description = "Một ngày nọ, tôi phát hiện ra một điều đau lòng: mình đã lớn. Không phải vì tôi cao thêm, hay vì tôi biết nhiều chữ hơn. Mà là vì tôi đã mất đi khả năng nói chuyện với cây cối... \n\nZezé, cậu bé 5 tuổi tinh nghịch và đáng yêu trong 'Cây Cam Ngọt Của Tôi', đã chạm đến trái tim của hàng triệu độc giả trên toàn thế giới. Sinh ra trong một gia đình nghèo đông con, Zezé sớm phải nếm trải những cay đắng của cuộc sống. Nhưng em vẫn giữ được tâm hồn trong sáng và trí tưởng tượng phong phú. Người bạn thân nhất của em là Minguinho - một cây cam ngọt sau vườn nhà. Em chia sẻ với nó mọi niềm vui, nỗi buồn và những bí mật thầm kín nhất.";
    $book->short_description = "Câu chuyện cảm động về cậu bé Zezé và người bạn cây cam ngọt, một tác phẩm kinh điển lấy đi nước mắt của hàng triệu độc giả.";
    $book->publisher = 'Hội Nhà Văn';
    $book->publish_year = 2023;
    $book->pages = 244;
    
    // Giả lập quan hệ category và author
    $book->category = new stdClass();
    $book->category->name = 'Văn Học Kinh Điển';
    
    $book->author = new stdClass();
    $book->author->name = 'José Mauro de Vasconcelos';
    
    // Giả lập created_at (Carbon object mock)
    $book->created_at = now();
@endphp

{{-- 1. Kế thừa khung giao diện chính (đã có Header & Footer) --}}
@extends('layouts.app')

{{-- 2. Đặt tiêu đề động theo tên sách --}}
@section('title', 'Chi tiết: ' . $book->title . ' - Góc Sách')

{{-- 3. Nội dung chính --}}
@section('content')
    <!-- Breadcrumb (Giữ nguyên style của bạn) -->
    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-brand-green">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('list') }}" class="hover:text-brand-green">{{ $book->category->name ?? 'Sách' }}</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold truncate">{{ $book->title }}</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8 flex-grow">
        
        <!-- Thông báo (Success/Error) -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm animate-fade-in-down">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <span class="font-medium ml-2">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                <strong class="font-bold">Lỗi:</strong>
                <ul class="list-disc list-inside mt-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- BOOK INFO CARD -->
        <div class="bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                
                <!-- Cột Ảnh Bìa -->
                <div class="md:col-span-4 lg:col-span-3">
                    <div class="relative rounded-lg overflow-hidden shadow-2xl transform hover:scale-[1.02] transition duration-500 group">
                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                             alt="{{ $book->title }}" 
                             class="w-full object-cover aspect-[2/3]"
                             onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    </div>
                </div>

                <!-- Cột Thông Tin -->
                <div class="md:col-span-8 lg:col-span-9 flex flex-col">
                    <div class="mb-4">
                        <span class="text-brand-accent text-xs font-bold uppercase tracking-wider">
                            {{ $book->category->name ?? 'Văn Học' }}
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold text-brand-green font-serif mt-2 mb-2 leading-tight">
                            {{ $book->title }}
                        </h1>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-gray-500">Tác giả: 
                                <a href="#author" class="text-brand-green font-semibold hover:underline">
                                    {{ $book->author->name ?? 'Đang cập nhật' }}
                                </a>
                            </span>
                            <span class="text-gray-300">|</span>
                            <a href="#reviews" class="flex items-center text-yellow-400 hover:opacity-80 transition cursor-pointer">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-500 ml-1 hover:text-brand-green hover:underline">(4.9/5 từ cộng đồng)</span>
                            </a>
                        </div>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3">
                        {{ $book->short_description ?? Str::limit(strip_tags($book->description), 250) }}
                    </p>

                    <!-- Thông số chi tiết -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 text-sm text-gray-600">
                        <div><p class="text-gray-400 text-xs mb-1">Nhà xuất bản</p><p class="font-semibold">{{ $book->publisher ?? 'Hội Nhà Văn' }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-1">Năm xuất bản</p><p class="font-semibold">{{ $book->publish_year ?? '2024' }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-1">Số trang</p><p class="font-semibold">{{ $book->pages ?? '300' }} trang</p></div>
                        <div><p class="text-gray-400 text-xs mb-1">Hình thức</p><p class="font-semibold">Bìa mềm</p></div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="mt-auto flex flex-col sm:flex-row gap-4 items-center">
                        <a href="#reviews" class="group flex items-center justify-center gap-2 px-8 py-3 rounded-lg border-2 border-brand-green text-brand-green font-bold hover:bg-brand-green hover:text-white transition-all duration-300 min-w-[200px] w-full sm:w-auto">
                            <i class="far fa-comments text-lg"></i>
                            <span>Xem Các Bài Review</span>
                        </a>

                        <a href="#" class="flex items-center justify-center gap-2 px-8 py-3 rounded-lg bg-brand-green text-white font-bold shadow-lg hover:bg-[#2C3E36] hover:-translate-y-0.5 transition-all duration-300 min-w-[200px] w-full sm:w-auto">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Xem Nơi Bán</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- CỘT TRÁI: Nội dung chi tiết & Review -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Section Giới Thiệu -->
                <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-brand-green font-serif mb-6 flex items-center gap-2 pb-3 border-b border-gray-100">
                        <i class="fas fa-align-left"></i> Giới Thiệu Sách
                    </h2>
                    <div class="prose prose-stone max-w-none text-gray-700 leading-7 text-justify">
                        {!! nl2br(e($book->description)) !!}
                    </div>
                </div>

                <!-- Section Form Review (Được tích hợp vào thiết kế mới) -->
                <div id="reviews" class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-gray-100 scroll-mt-24">
                    <h2 class="text-xl font-bold text-brand-green font-serif mb-6 flex items-center gap-2 pb-3 border-b border-gray-100">
                        <i class="fas fa-star text-yellow-400"></i> Viết Đánh Giá Của Bạn
                    </h2>

                    @auth
                        <form action="{{ route('review.store') }}" method="POST" id="reviewForm" class="bg-brand-cream/30 p-6 rounded-xl border border-brand-beige">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">

                            <!-- Chọn Sao -->
                            <div class="mb-6 text-center">
                                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Bạn chấm cuốn này mấy điểm?</label>
                                <div class="flex justify-center items-center space-x-3" id="star-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-3xl text-gray-300 cursor-pointer transition-all duration-200 hover:scale-110 hover:text-yellow-400" 
                                           data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-input" value="0">
                                <p class="text-red-500 text-sm mt-2 hidden font-bold animate-pulse" id="rating-error">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Vui lòng chọn số sao!
                                </p>
                            </div>

                            <!-- Nội dung -->
                            <div class="mb-4">
                                <textarea name="content" rows="4" 
                                    class="w-full p-4 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brand-green/20 focus:border-brand-green outline-none transition text-gray-700 resize-none bg-white"
                                    placeholder="Chia sẻ cảm nhận của bạn về cuốn sách này... (Tối thiểu 10 ký tự)" required></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-brand-green text-white px-6 py-2.5 rounded-lg font-bold shadow-md hover:bg-brand-green-light transition transform hover:-translate-y-0.5">
                                    Gửi Đánh Giá
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Guest Login Prompt -->
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500 mb-4">Đăng nhập để chia sẻ cảm nhận của bạn về cuốn sách này nhé!</p>
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('login') }}" class="bg-brand-green text-white px-6 py-2 rounded-lg font-bold hover:bg-brand-green-light transition shadow-sm">Đăng Nhập</a>
                                <a href="{{ route('register') }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-50 transition">Đăng Ký</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- CỘT PHẢI: Sidebar -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Widget Tác Giả -->
                <div id="author" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">
                        Thông Tin Tác Giả
                    </h3>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-brand-beige mb-4 shadow-sm">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($book->author->name ?? 'TG') }}&background=random&size=128" 
                                 alt="{{ $book->author->name ?? 'Tác giả' }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-bold text-xl text-gray-800 font-serif mb-1">{{ $book->author->name ?? 'Đang cập nhật' }}</h4>
                        <span class="text-xs text-brand-brown font-bold uppercase tracking-wide mb-3">Tác giả nổi bật</span>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4">
                            Tác giả của cuốn sách này và nhiều tác phẩm ăn khách khác.
                        </p>
                        <button class="text-brand-green text-sm font-bold border border-brand-green rounded-full px-4 py-1 hover:bg-brand-green hover:text-white transition">
                            Xem thêm tác phẩm
                        </button>
                    </div>
                </div>

                <!-- Widget Sách Tương Tự -->
                <div>
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4">Có Thể Bạn Thích</h3>
                    <div class="space-y-4">
                        <!-- Loop giả lập (Bạn có thể thay bằng vòng lặp sách thật) -->
                        @foreach(['Hoàng Tử Bé', 'Nhà Giả Kim', 'Mắt Biếc'] as $index => $similarTitle)
                        <a href="#" class="flex gap-3 group bg-white p-3 rounded-lg border border-gray-100 hover:shadow-md transition">
                            <div class="w-16 flex-shrink-0">
                                <img src="https://source.unsplash.com/random/200x300?book,sig={{ $index + 20 }}" class="w-full rounded object-cover aspect-[2/3]">
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm font-serif group-hover:text-brand-green transition line-clamp-2">{{ $similarTitle }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Tác giả nổi tiếng</p>
                                <div class="flex items-center gap-1 text-xs text-yellow-400 mt-2">
                                    <i class="fas fa-star"></i> 4.8
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

{{-- Script xử lý sao đánh giá --}}
@push('scripts')
<script>
    const stars = document.querySelectorAll('#star-container i');
    const ratingInput = document.getElementById('rating-input');
    const errorMsg = document.getElementById('rating-error');
    const form = document.getElementById('reviewForm');

    // --- XỬ LÝ HIỆU ỨNG SAO ---
    if(stars.length > 0) {
        stars.forEach(star => {
            star.addEventListener('mouseenter', () => highlight(star.getAttribute('data-value')));
            star.addEventListener('mouseleave', () => highlight(ratingInput.value));
            star.addEventListener('click', () => {
                const val = star.getAttribute('data-value');
                ratingInput.value = val;
                highlight(val);
                if(errorMsg) errorMsg.classList.add('hidden');
                
                // Hiệu ứng nhún
                star.style.transform = "scale(1.4)";
                setTimeout(() => star.style.transform = "scale(1)", 200);
            });
        });
    }

    function highlight(value) {
        stars.forEach(s => {
            const sVal = s.getAttribute('data-value');
            if (sVal <= value) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }
        });
    }

    if(form) {
        form.addEventListener('submit', (e) => {
            if (ratingInput.value == 0) {
                e.preventDefault();
                if(errorMsg) errorMsg.classList.remove('hidden');
                const container = document.getElementById('star-container');
                container.classList.add('animate-pulse');
                setTimeout(() => container.classList.remove('animate-pulse'), 1000);
            }
        });
    }
</script>
@endpush