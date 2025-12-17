<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Góc Sách - Mạng Xã Hội Đọc Sách')</title>

    {{-- [MỚI] THÊM FAVICON --}}
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300&family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2A483A',
                        'brand-green-light': '#3E5F4E',
                        'brand-cream': '#FDFBF7',
                        'brand-beige': '#F2E8DC',
                        'brand-brown': '#8C6B4B',
                        'brand-accent': '#D4A373',
                    },
                    fontFamily: {
                        sans: ['Nunito Sans', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025)',
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #FAF9F6; color: #333; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 20px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #3E5F4E; }
        .hero-slider-wrapper { transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen selection:bg-brand-green selection:text-white">

    @include('partials.header')

    <div class="flex-grow">
        @yield('content')
    </div>

    @include('partials.footer')

    @stack('scripts')

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                alert('Tính năng menu mobile sẽ được cập nhật!');
            });
        }

        // ==========================================
        // [MỚI] SCRIPT TÌM KIẾM AJAX (LIVE SEARCH)
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('header-search-input');
            const resultsBox = document.getElementById('header-search-results');
            let timeout = null;

            if (searchInput && resultsBox) {
                // 1. Khi người dùng gõ phím
                searchInput.addEventListener('input', function() {
                    const keyword = this.value.trim();
                    clearTimeout(timeout);

                    if (keyword.length < 2) { 
                        resultsBox.classList.add('hidden');
                        resultsBox.innerHTML = '';
                        return;
                    }

                    // Debounce 300ms
                    timeout = setTimeout(() => {
                        fetchResults(keyword);
                    }, 300);
                });

                // 2. Gửi Ajax lên Server
                function fetchResults(keyword) {
                    // Lưu ý: Bạn phải tạo route /ajax-search trong web.php rồi nhé
                    fetch(`/ajax-search?keyword=${encodeURIComponent(keyword)}`)
                        .then(response => response.json())
                        .then(data => {
                            renderResults(data);
                        })
                        .catch(error => console.error('Error:', error));
                }

                // 3. Hiển thị kết quả
                function renderResults(books) {
    if (books.length > 0) {
        let html = '<ul class="divide-y divide-gray-100">';
        
        books.forEach(book => {
            // Ảnh đã được xử lý từ Controller nên dùng trực tiếp
            let imgUrl = book.image_url; 
            
            // [ĐÃ SỬA] Dùng link chuẩn từ Controller gửi xuống
            let detailUrl = book.url; 

            html += `
                <li>
                    <a href="${detailUrl}" class="flex items-center gap-3 p-3 hover:bg-gray-50 transition cursor-pointer text-left">
                        <img src="${imgUrl}" class="w-10 h-14 object-cover rounded shadow-sm border border-gray-200">
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 line-clamp-1">${book.title}</h4>
                            <p class="text-xs text-gray-500">${book.author_name}</p>
                        </div>
                    </a>
                </li>
            `;
        });
        
        // Link xem tất cả
        let keyword = document.getElementById('header-search-input').value;
        html += `
            <li class="bg-gray-50 text-center p-2">
                <button onclick="window.location.href='/danh-sach-sach?keyword=' + encodeURIComponent('${keyword}')" class="text-xs font-bold text-brand-green hover:underline">
                    Xem tất cả kết quả
                </button>
            </li>
        `;

        html += '</ul>';
                        resultsBox.innerHTML = html;
                        resultsBox.classList.remove('hidden');
                    } else {
                        resultsBox.innerHTML = '<div class="p-4 text-center text-sm text-gray-400">Không tìm thấy sách nào.</div>';
                        resultsBox.classList.remove('hidden');
                    }
                }

                // 4. Click ra ngoài thì ẩn
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                        resultsBox.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>