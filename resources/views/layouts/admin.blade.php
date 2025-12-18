<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Góc Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Tailwind Config: Enable dark mode with class strategy --}}
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    {{-- Anti-flash: Load theme before render --}}
    <script>
            (function () {
                const theme = localStorage.getItem('admin-theme') || 'light';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            })();
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar cho Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #475569;
        }

        .dark .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Dark mode */
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #334155;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #64748b;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Firefox support */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 #f1f5f9;
        }

        .dark .custom-scrollbar {
            scrollbar-color: #64748b #334155;
        }

        /* Theme toggle button animation */
        #theme-toggle i {
            transition: transform 0.3s ease;
        }

        #theme-toggle:hover i {
            transform: rotate(20deg);
        }

        /* Custom Dropdown Styles */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
            min-width: 120px;
            justify-content: space-between;
        }

        .custom-dropdown-trigger:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .dark .custom-dropdown-trigger:hover {
            background-color: rgba(59, 130, 246, 0.2);
        }

        .custom-dropdown-trigger svg {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .custom-dropdown.open .custom-dropdown-trigger svg {
            transform: rotate(180deg);
        }

        .custom-dropdown-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            min-width: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            overflow: hidden;
        }

        .dark .custom-dropdown-menu {
            background: #1e293b;
            border-color: #475569;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.5);
        }

        .custom-dropdown.open .custom-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .custom-dropdown-menu-inner {
            max-height: 280px;
            overflow-y: auto;
            padding: 0.5rem;
        }

        .custom-dropdown-item {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .custom-dropdown-item:hover {
            background: #f1f5f9;
        }

        .dark .custom-dropdown-item:hover {
            background: #334155;
        }

        .custom-dropdown-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
        }

        .custom-dropdown-item.active:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        /* Scrollbar for dropdown menu */
        .custom-dropdown-menu-inner::-webkit-scrollbar {
            width: 6px;
        }

        .custom-dropdown-menu-inner::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-dropdown-menu-inner::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .custom-dropdown-menu-inner::-webkit-scrollbar-thumb {
            background: #475569;
        }

        /* Year dropdown - grid layout */
        .custom-dropdown-menu.year-menu .custom-dropdown-menu-inner {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.25rem;
            max-height: none;
        }

        /* Month dropdown - grid layout */
        .custom-dropdown-menu.month-menu .custom-dropdown-menu-inner {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.25rem;
            max-height: none;
        }

        .custom-dropdown-menu.month-menu .custom-dropdown-item,
        .custom-dropdown-menu.year-menu .custom-dropdown-item {
            justify-content: center;
            padding: 0.625rem 0.5rem;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 transition-colors duration-300">
    <div class="flex min-h-screen">

        <aside
            class="w-72 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex-shrink-0 hidden lg:flex flex-col sticky top-0 h-screen shadow-xl dark:shadow-none border-r border-gray-200 dark:border-slate-800 z-50 transition-colors duration-300">

            {{-- 1. Brand Logo --}}
            <div
                class="h-16 flex items-center gap-3 px-6 border-b border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-950/50 backdrop-blur-sm sticky top-0 z-10 transition-colors duration-300">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <i class="fas fa-shield-alt text-sm"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-slate-800 dark:text-white tracking-tight">Admin Panel</h1>
                    <p class="text-[12px] text-slate-400 dark:text-slate-500 font-medium uppercase tracking-wider">Quản
                        trị hệ thống</p>
                </div>
            </div>

            {{-- 2. Navigation Menu (Scrollable) --}}
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 px-4 space-y-8">

                {{-- Group: Tổng Quan --}}
                <div>
                    <p class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tổng Quan</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-chart-pie w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                </div>

                {{-- Group: Quản Lý Nội Dung --}}
                <div class="space-y-1">
                    <p class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nội Dung</p>

                    {{-- [MỚI] Quản lý Banner --}}
                    <a href="{{ route('admin.banners.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.banners.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-images w-5 text-center {{ request()->routeIs('admin.banners.*') ? 'text-white' : 'text-slate-400 group-hover:text-pink-400' }}"></i>
                        <span class="font-medium text-sm">Quản Lý Banner</span>
                    </a>

                    {{-- [MỚI] Quản lý Tạp chí (Article) - Thêm luôn để tiện --}}
                    <a href="{{ route('admin.articles.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-newspaper w-5 text-center {{ request()->routeIs('admin.articles.*') ? 'text-white' : 'text-slate-400 group-hover:text-teal-400' }}"></i>
                        <span class="font-medium text-sm">Tạp Chí Đọc</span>
                    </a>

                    {{-- Quản lý Châm Ngôn --}}
                    <a href="{{ route('admin.quotes.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.quotes.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-quote-left w-5 text-center {{ request()->routeIs('admin.quotes.*') ? 'text-white' : 'text-slate-400 group-hover:text-amber-400' }}"></i>
                        <span class="font-medium text-sm">Châm Ngôn</span>
                    </a>

                    <a href="{{ route('admin.books.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-book w-5 text-center {{ request()->routeIs('admin.books.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}"></i>
                        <span class="font-medium text-sm">Quản Lý Sách</span>
                    </a>

                    {{-- Quản lý Tác giả --}}
                    <a href="{{ route('admin.authors.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.authors.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-user-pen w-5 text-center {{ request()->routeIs('admin.authors.*') ? 'text-white' : 'text-slate-400 group-hover:text-cyan-400' }}"></i>
                        <span class="font-medium text-sm">Tác Giả</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-tags w-5 text-center {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400 group-hover:text-orange-400' }}"></i>
                        <span class="font-medium text-sm">Danh Mục</span>
                    </a>

                    <a href="{{ route('admin.posts.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-star w-5 text-center {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-400 group-hover:text-yellow-400' }}"></i>
                        <span class="font-medium text-sm">Kiểm Duyệt Bài</span>
                        {{-- Badge thông báo (Demo) --}}
                        <span
                            class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md">Mới</span>
                    </a>
                </div>

                {{-- Group: Người Dùng & Hệ Thống --}}
                <div class="space-y-1">
                    <p class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hệ Thống</p>

                    <a href="{{ route('admin.users.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-users w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                        <span class="font-medium text-sm">Thành Viên</span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-history w-5 text-center {{ request()->routeIs('admin.activity-logs.*') ? 'text-white' : 'text-slate-400 group-hover:text-purple-400' }}"></i>
                        <span class="font-medium text-sm">Lịch Sử Hoạt Động</span>
                    </a>

                    <a href="{{ route('admin.game.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.game.*') || request()->routeIs('admin.badges.*') || request()->routeIs('admin.challenges.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-trophy w-5 text-center {{ request()->routeIs('admin.game.*') || request()->routeIs('admin.badges.*') || request()->routeIs('admin.challenges.*') ? 'text-white' : 'text-slate-400 group-hover:text-yellow-400' }}"></i>
                        <span class="font-medium text-sm">Thử Thách & Danh Hiệu</span>
                    </a>
                </div>
            </nav>

            {{-- 3. Footer Actions --}}
            <div
                class="p-4 border-t border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-slate-950/30 transition-colors duration-300">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3 py-2 text-slate-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white rounded-lg transition-all mb-2 group">
                    <i class="fas fa-external-link-alt w-5 text-center group-hover:text-blue-400"></i>
                    <span class="text-sm">Xem Trang Chủ</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400 rounded-lg transition-all text-left group">
                        <i class="fas fa-sign-out-alt w-5 text-center group-hover:text-red-500"></i>
                        <span class="text-sm font-medium">Đăng Xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-gray-50 dark:bg-slate-900 transition-colors duration-300">

            {{-- Mobile Header --}}
            <div
                class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 p-4 lg:hidden sticky top-0 z-20 flex justify-between items-center shadow-sm transition-colors duration-300">
                <div class="flex items-center gap-2 font-bold text-slate-800 dark:text-white">
                    <i class="fas fa-shield-alt text-blue-600"></i> Admin Panel
                </div>
                <div class="flex items-center gap-2">
                    {{-- Theme Toggle Mobile --}}
                    <button id="theme-toggle-mobile"
                        class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:inline text-yellow-400"></i>
                    </button>
                    <button class="text-slate-500 dark:text-slate-400 hover:text-blue-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <main class="p-6 lg:p-8 flex-1 overflow-y-auto">
                <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">@yield('header')
                        </h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Quản lý hệ thống Góc Sách</p>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Theme Toggle Button (Desktop) --}}
                        <button id="theme-toggle"
                            class="hidden lg:flex items-center gap-2 px-3 py-1.5 rounded-full border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 shadow-sm transition-all duration-300"
                            title="Chế độ sáng/tối">
                            <i class="fas fa-moon text-indigo-500 dark:hidden"></i>
                            <i class="fas fa-sun text-yellow-400 hidden dark:inline"></i>
                        </button>
                        <div
                            class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 px-3 py-1.5 rounded-full border border-gray-200 dark:border-slate-600 shadow-sm transition-colors duration-300">
                            <i class="far fa-calendar-alt text-blue-500"></i>
                            <span>{{ date('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div id="success-alert"
                        class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-lg mb-6 flex items-center justify-between gap-3 shadow-sm transition-all duration-500"
                        style="opacity: 1;">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="dismissAlert('success-alert')"
                            class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div id="error-alert"
                        class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center justify-between gap-3 shadow-sm transition-all duration-500"
                        style="opacity: 1;">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button onclick="dismissAlert('error-alert')"
                            class="text-red-500 hover:text-red-700 dark:hover:text-red-300 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <script>
                    function dismissAlert(id) {
                        const alert = document.getElementById(id);
                        if (alert) {
                            alert.style.opacity = '0';
                            alert.style.transform = 'translateY(-10px)';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }

                    // Auto dismiss after 5 seconds
                    document.addEventListener('DOMContentLoaded', function () {
                        ['success-alert', 'error-alert'].forEach(id => {
                            const alert = document.getElementById(id);
                            if (alert) {
                                setTimeout(() => dismissAlert(id), 5000);
                            }
                        });
                    });
                </script>

                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>

            {{-- Footer Admin --}}
            <footer
                class="p-6 text-center text-xs text-slate-400 dark:text-slate-500 border-t border-gray-200 dark:border-slate-700 transition-colors duration-300">
                &copy; {{ date('Y') }} Góc Sách Admin Panel. Bản quyền được bảo lưu.
            </footer>
        </div>
    </div>

    {{-- Theme Toggle Script --}}
    <script>
        (function () {
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleMobile = document.getElementById('theme-toggle-mobile');

            function toggleTheme() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
            }

            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }
            if (themeToggleMobile) {
                themeToggleMobile.addEventListener('click', toggleTheme);
            }
        })();
    </script>

    {{-- Global AJAX Pagination Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function bindAjaxPagination() {
                document.querySelectorAll('.ajax-pagination-link').forEach(link => {
                    // Skip if already bound
                    if (link.dataset.ajaxBound) return;

                    // Skip if inside dashboard containers (they have their own handlers)
                    if (link.closest('#reviews-content') || link.closest('#users-content')) return;

                    link.dataset.ajaxBound = 'true';

                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const url = this.href;

                        // Find the closest card/container
                        const container = this.closest('.rounded-xl, .rounded-lg');
                        let overlay = null;

                        if (container) {
                            // Add loading overlay to this container only
                            container.style.position = 'relative';
                            overlay = document.createElement('div');
                            overlay.className = 'absolute inset-0 bg-white/80 dark:bg-slate-800/80 flex items-center justify-center z-10 rounded-xl rounded-lg';
                            overlay.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>';
                            container.appendChild(overlay);
                        }

                        fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const mainContent = document.querySelector('main .animate-fade-in');
                                const newContent = doc.querySelector('main .animate-fade-in');

                                if (mainContent && newContent) {
                                    mainContent.innerHTML = newContent.innerHTML;
                                }

                                window.history.pushState({}, '', url);
                                bindAjaxPagination();
                            })
                            .catch(error => {
                                console.error('Error loading page:', error);
                                if (overlay) overlay.remove();
                                window.location.href = url;
                            });
                    });
                });
            }

            // Handle browser back/forward
            window.addEventListener('popstate', function (e) {
                fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const mainContent = document.querySelector('main .animate-fade-in');
                        const newContent = doc.querySelector('main .animate-fade-in');
                        if (mainContent && newContent) {
                            mainContent.innerHTML = newContent.innerHTML;
                        }
                        bindAjaxPagination();
                    })
                    .catch(() => {
                        window.location.reload();
                    });
            });

            bindAjaxPagination();
        });
    </script>

    @stack('scripts')
</body>

</html>