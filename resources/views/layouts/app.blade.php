<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Góc Sách - Mạng Xã Hội Đọc Sách')</title>

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

    <!-- Include Header -->
    @include('partials.header')

    <!-- Main Content Place -->
    <div class="flex-grow">
        @yield('content')
    </div>

    <!-- Include Footer -->
    @include('partials.footer')

    <!-- Script Stack (Cho phép trang con đẩy JS vào) -->
    @stack('scripts')

    <!-- Common Scripts -->
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                alert('Tính năng menu mobile sẽ được cập nhật!');
            });
        }
    </script>
</body>
</html>