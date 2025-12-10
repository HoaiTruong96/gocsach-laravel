{{-- 1. Kế thừa khung giao diện chính (đã có Header & Footer) --}}
@extends('layouts.app')

{{-- 2. Đặt tiêu đề động theo tên sách --}}
@section('title', 'Chi tiết: ' . $book->title . ' - Góc Sách')

{{-- 3. Nội dung chính --}}
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        
        <!-- Breadcrumb (Đường dẫn) -->
        <nav class="flex text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-brand-green">Trang chủ</a>
            <span class="mx-2">/</span>
            <a href="{{ route('list') }}" class="hover:text-brand-green">Sách</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-bold truncate">{{ $book->title }}</span>
        </nav>

        <!-- Thông báo thành công -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center shadow-sm animate-fade-in-down">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Thông báo lỗi -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 shadow-sm">
                <strong class="font-bold flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> Có lỗi xảy ra:</strong>
                <ul class="list-disc list-inside mt-1 ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Chi tiết Sách -->
        <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6 mb-8 flex flex-col md:flex-row gap-8">
            <!-- Ảnh bìa -->
            <div class="flex-shrink-0 mx-auto md:mx-0 w-48 lg:w-64">
                <div class="relative rounded-lg shadow-lg overflow-hidden group">
                    <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-auto object-cover transform transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                </div>
                
                <!-- Nút thao tác nhanh dưới ảnh -->
                <div class="mt-4 flex gap-2">
                    <button class="flex-1 bg-brand-green text-white py-2 rounded-lg font-bold text-sm hover:bg-brand-green-light transition shadow-md">
                        <i class="fas fa-cart-plus mr-1"></i> Mua Ngay
                    </button>
                    <button class="w-10 bg-gray-100 text-gray-500 py-2 rounded-lg hover:text-red-500 hover:bg-red-50 transition">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Thông tin sách -->
            <div class="flex-grow">
                <h1 class="text-3xl lg:text-4xl font-bold font-serif text-gray-900 mb-2 leading-tight">{{ $book->title }}</h1>
                
                <!-- Meta data -->
                <div class="flex flex-wrap gap-3 text-sm text-gray-600 mb-6 border-b border-gray-100 pb-6 mt-4">
                    <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full font-bold">
                        <i class="fas fa-user-edit mr-1.5"></i> {{ $book->author->name ?? 'Không rõ' }}
                    </span>
                    <span class="bg-brand-green/10 text-brand-green px-3 py-1.5 rounded-full font-bold">
                        <i class="fas fa-tag mr-1.5"></i> {{ $book->category->name ?? 'Không rõ' }}
                    </span>
                    <span class="flex items-center text-gray-500 ml-auto font-medium">
                        <i class="fas fa-eye mr-1.5"></i> {{ number_format($book->view_count ?? 0) }} lượt xem
                    </span>
                </div>

                <!-- Mô tả -->
                <div class="prose prose-sm sm:prose max-w-none text-gray-600">
                    <h3 class="font-bold text-gray-800 text-lg mb-2 font-serif border-l-4 border-brand-accent pl-3">Giới thiệu nội dung</h3>
                    <p class="leading-relaxed text-justify">
                        {{ $book->description ?? 'Đang cập nhật mô tả cho cuốn sách này...' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Đánh Giá -->
        <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6 md:p-8 relative overflow-hidden">
            <!-- Trang trí -->
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-brand-green to-brand-accent"></div>
            
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center font-serif">
                <span class="bg-yellow-100 text-yellow-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">
                    <i class="fas fa-star"></i>
                </span>
                Viết Đánh Giá Của Bạn
            </h2>

            <!-- Kiểm tra đăng nhập trước khi cho đánh giá -->
            @auth
                <form action="{{ route('post.store') }}" method="POST" id="postForm">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <!-- Chọn sao -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-dashed border-gray-200">
                        <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide text-center">
                            Bạn chấm cuốn này mấy điểm?
                        </label>
                        
                        <div class="flex justify-center items-center space-x-2" id="star-container">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-4xl text-gray-300 cursor-pointer transition-all duration-200 hover:scale-110 hover:text-yellow-400" 
                                   data-value="{{ $i }}"></i>
                            @endfor
                        </div>

                        <input type="hidden" name="rating" id="rating-input" value="0">
                        
                        <p class="text-red-500 text-sm mt-3 hidden font-bold flex items-center justify-center animate-pulse" id="rating-error">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Vui lòng chọn số sao trước khi gửi!
                        </p>
                    </div>

                    <!-- Nội dung -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                            Nội dung chi tiết
                        </label>
                        <textarea 
                            name="content" 
                            rows="4" 
                            class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-green/20 focus:border-brand-green outline-none transition text-gray-700 resize-none"
                            placeholder="Hãy chia sẻ cảm nhận chân thực nhất của bạn về cuốn sách này (tối thiểu 10 ký tự)..."
                            required
                        ></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-brand-green hover:bg-brand-green-light text-white px-8 py-3 rounded-lg font-bold shadow-lg transform transition hover:-translate-y-1 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Gửi Đánh Giá
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500 mb-4">Vui lòng đăng nhập để viết đánh giá cho cuốn sách này.</p>
                    <a href="{{ route('login') }}" class="inline-block bg-brand-green text-white px-6 py-2 rounded-lg font-bold hover:bg-brand-green-light transition shadow-md">
                        Đăng Nhập Ngay
                    </a>
                </div>
            @endauth
        </div>

    </div>
@endsection

{{-- 4. Chèn Script xử lý riêng cho trang này vào Stack 'scripts' của Layout --}}
@push('scripts')
<script>
    const stars = document.querySelectorAll('#star-container i');
    const ratingInput = document.getElementById('rating-input');
    const errorMsg = document.getElementById('rating-error');
    const form = document.getElementById('postForm');
    // Cấu hình CSRF Token cho Ajax (Bắt buộc trong Laravel)
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

    // 1. Xử lý Like
    function toggleLike(postId) {
        fetch(`/post/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Lấy token từ Blade
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'error') {
                alert(data.message); // Báo lỗi nếu chưa đăng nhập
                window.location.href = '/login';
                return;
            }

            // Cập nhật giao diện ngay lập tức (Real-time feel)
            const icon = document.getElementById(`icon-like-${postId}`);
            const count = document.getElementById(`count-like-${postId}`);

            // Cập nhật số lượng
            count.innerText = data.count;

            // Cập nhật icon (Đỏ/Trắng)
            if (data.liked) {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500');
            } else {
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // 2. Xử lý Comment
    function sendComment(postId) {
        const input = document.getElementById(`input-comment-${postId}`);
        const content = input.value;

        if (!content.trim()) return; // Không gửi nếu rỗng

        fetch(`/post/${postId}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'error') {
                alert(data.message);
                return;
            }

            // Xóa ô nhập
            input.value = '';

            // Vẽ comment mới vào danh sách (Append HTML)
            const list = document.getElementById(`comment-list-${postId}`);
            const newCommentHTML = `
                <div class="flex gap-2 animate-fade-in-up"> <img src="${data.user_avatar}" class="w-8 h-8 rounded-full">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <strong class="text-sm block">${data.user_name}</strong>
                        <span class="text-sm text-gray-800">${data.content}</span>
                    </div>
                </div>
            `;
            // Chèn vào cuối danh sách
            list.insertAdjacentHTML('beforeend', newCommentHTML);
        })
        .catch(error => console.error('Error:', error));
    }
    // --- XỬ LÝ HIỆU ỨNG SAO ---
    if(stars.length > 0) {
        stars.forEach(star => {
            // 1. Khi chuột RÊ VÀO: Sáng màu vàng
            star.addEventListener('mouseenter', () => {
                const val = star.getAttribute('data-value');
                highlight(val);
            });

            // 2. Khi chuột RỜI RA: Trả về trạng thái đã chọn
            star.addEventListener('mouseleave', () => {
                highlight(ratingInput.value);
            });

            // 3. Khi CLICK CHỌN
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

    // Hàm tô màu sao
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

    // --- CHẶN GỬI NẾU QUÊN CHỌN SAO ---
    if(form) {
        form.addEventListener('submit', (e) => {
            if (ratingInput.value == 0) {
                e.preventDefault();
                if(errorMsg) errorMsg.classList.remove('hidden');
                
                // Rung nhẹ chỗ sao
                const container = document.getElementById('star-container');
                container.classList.add('animate-pulse');
                setTimeout(() => container.classList.remove('animate-pulse'), 1000);
            }
        });
    }
</script>
@endpush