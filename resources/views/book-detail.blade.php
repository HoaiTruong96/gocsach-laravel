<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết: {{ $book->title }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        body { font-family: 'Roboto', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="text-gray-800">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-red-700 text-2xl font-bold flex items-center hover:opacity-80 transition">
                <i class="fas fa-book-reader mr-2"></i> Góc Sách
            </a>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500"> Xin chào, <strong>{{ Auth::check() ? Auth::user()->name : 'Khách' }}</strong></span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::check() ? Auth::user()->name : 'Khách') }}&background=0D8ABC&color=fff" class="w-8 h-8 rounded-full border border-gray-200">
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-5xl">
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center shadow-sm">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 flex flex-col md:flex-row gap-8">
            <div class="flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                     alt="{{ $book->title }}" 
                     class="w-48 h-72 object-cover rounded-lg shadow-md hover:shadow-xl transition duration-300">
            </div>
            <div class="flex-grow">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-6 border-b border-gray-100 pb-4">
                    <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-medium">
                        <i class="fas fa-user-edit mr-1"></i> Tác giả: {{ $book->author->name ?? 'Không rõ' }}
                    </span>
                    <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full font-medium">
                        <i class="fas fa-tag mr-1"></i> Thể loại: {{ $book->category->name ?? 'Không rõ' }}
                    </span>
                    <span class="flex items-center text-gray-500">
                        <i class="fas fa-eye mr-1"></i> {{ $book->view_count ?? 0 }} lượt xem
                    </span>
                </div>

                <div class="prose max-w-none text-gray-600">
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Giới thiệu nội dung:</h3>
                    <p class="leading-relaxed text-justify">
                        {{ $book->description ?? 'Đang cập nhật mô tả cho cuốn sách này...' }}
                    </p>
                </div>
            </div>
        </div>
        @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong class="font-bold">Có lỗi xảy ra:</strong>
        <ul class="list-disc list-inside mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
            
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-star text-yellow-400 mr-2 text-2xl"></i> Viết Đánh Giá Của Bạn
            </h2>

            <form action="{{ route('review.store') }}" method="POST" id="reviewForm">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">
                        1. Bạn chấm cuốn này mấy điểm?
                    </label>
                    
                    <div class="flex items-center space-x-2" id="star-container">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-4xl text-gray-300 cursor-pointer transition-transform duration-200 hover:scale-110" 
                               data-value="{{ $i }}"></i>
                        @endfor
                    </div>

                    <input type="hidden" name="rating" id="rating-input" value="0">
                    
                    <p class="text-red-500 text-sm mt-3 hidden font-bold flex items-center animate-pulse" id="rating-error">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Vui lòng chọn số sao trước khi gửi!
                    </p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                        2. Nội dung chi tiết
                    </label>
                    <textarea 
                        name="content" 
                        rows="4" 
                        class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700"
                        placeholder="Hãy chia sẻ cảm nhận chân thực nhất của bạn về cuốn sách này (tối thiểu 10 ký tự)..."
                        required
                    ></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg transform transition hover:-translate-y-1 flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i> Gửi Đánh Giá
                    </button>
                </div>
            </form>
        </div>

    </main>

    <script>
        const stars = document.querySelectorAll('#star-container i');
        const ratingInput = document.getElementById('rating-input');
        const errorMsg = document.getElementById('rating-error');
        const form = document.getElementById('reviewForm');

        // --- XỬ LÝ HIỆU ỨNG SAO ---
        stars.forEach(star => {
            // 1. Khi chuột RÊ VÀO: Sáng màu vàng (dùng class Tailwind)
            star.addEventListener('mouseenter', () => {
                const val = star.getAttribute('data-value');
                highlight(val);
            });

            // 2. Khi chuột RỜI RA: Trả về trạng thái đã chọn (hoặc xám nếu chưa chọn)
            star.addEventListener('mouseleave', () => {
                highlight(ratingInput.value);
            });

            // 3. Khi CLICK CHỌN: Lưu giá trị + Hiệu ứng nhún
            star.addEventListener('click', () => {
                const val = star.getAttribute('data-value');
                ratingInput.value = val;
                highlight(val);
                errorMsg.classList.add('hidden'); // Tắt lỗi
                
                // Hiệu ứng "Nhún" (Scale) để biết đã nhận click
                star.style.transform = "scale(1.4)";
                setTimeout(() => star.style.transform = "scale(1)", 200);
            });
        });

        // Hàm tô màu (Dùng class Tailwind trực tiếp cho chắc chắn)
        function highlight(value) {
            stars.forEach(s => {
                const sVal = s.getAttribute('data-value');
                if (sVal <= value) {
                    // Sao sáng: Xóa màu xám, Thêm màu vàng
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    // Sao tắt: Xóa màu vàng, Thêm màu xám
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        }

        // --- CHẶN GỬI NẾU QUÊN CHỌN ---
        form.addEventListener('submit', (e) => {
            if (ratingInput.value == 0) {
                e.preventDefault(); // Chặn gửi ngay
                errorMsg.classList.remove('hidden'); // Hiện lỗi
                
                // Rung nhẹ chỗ sao để gây chú ý
                const container = document.getElementById('star-container');
                container.classList.add('animate-bounce');
                setTimeout(() => container.classList.remove('animate-bounce'), 1000);
            }
        });
    </script>

</body>
</html>