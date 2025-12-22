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

        /* ===== Year Picker Styles ===== */
        .year-picker-dropdown {
            animation: slideDown 0.2s ease-out;
        }

        .year-picker-dropdown.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .year-grid .year-item {
            padding: 0.5rem;
            text-align: center;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            color: #374151;
        }

        .dark .year-grid .year-item {
            color: #e2e8f0;
        }

        .year-grid .year-item:hover {
            background: #e0e7ff;
            color: #3730a3;
        }

        .dark .year-grid .year-item:hover {
            background: #3730a3;
            color: #e0e7ff;
        }

        .year-grid .year-item.selected {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
        }

        .year-grid .year-item.current-year {
            border: 2px solid #3b82f6;
        }

        /* ===== Scroll Picker Styles ===== */
        .scroll-display-wrapper {
            position: relative;
            touch-action: none;
        }

        .scroll-current-value {
            transition: transform 0.1s ease-out;
        }

        .scroll-btn {
            transition: all 0.2s ease;
        }

        .scroll-btn:active {
            transform: scale(0.95);
        }

        .scroll-btn:disabled {
            cursor: not-allowed;
        }

        /* ===== Rating Picker Styles ===== */
        .rating-star .fa-star {
            transition: all 0.15s ease;
        }

        .rating-star.active .fa-star,
        .rating-star.hovered .fa-star {
            color: #fbbf24;
        }

        .rating-star.active .far.fa-star {
            font-weight: 900;
            font-family: "Font Awesome 6 Free";
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
                        <span class="font-medium text-sm">Quản Lý Châm Ngôn</span>
                    </a>

                    <a href="{{ route('admin.books.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-book w-5 text-center {{ request()->routeIs('admin.books.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}"></i>
                        <span class="font-medium text-sm">Quản Lý Sách</span>
                        {{-- Badge sách chờ duyệt --}}
                        @php
                            $pendingBooksCount = \App\Models\Book::where('is_approved', false)->count();
                        @endphp
                        @if($pendingBooksCount > 0)
                            <span
                                class="ml-auto bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md animate-pulse">
                                {{ $pendingBooksCount }}
                            </span>
                        @endif
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
                        <span class="font-medium text-sm">Kiểm Duyệt Bài Đăng</span>
                        {{-- Badge số lượng bài chờ duyệt --}}
                        @php
                            $pendingPostsCount = \App\Models\Post::where('status', 'pending')->count();
                        @endphp
                        @if($pendingPostsCount > 0)
                            <span
                                class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md animate-pulse">
                                {{ $pendingPostsCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Báo Cáo Bình Luận --}}
                    <a href="{{ route('admin.comment-reports.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.comment-reports.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-flag w-5 text-center {{ request()->routeIs('admin.comment-reports.*') ? 'text-white' : 'text-slate-400 group-hover:text-red-400' }}"></i>
                        <span class="font-medium text-sm">Báo Cáo Bình Luận</span>
                        {{-- Badge số lượng báo cáo chờ xử lý --}}
                        @php
                            $pendingReportsCount = \App\Models\CommentReport::where('status', 'pending')->count();
                        @endphp
                        @if($pendingReportsCount > 0)
                            <span
                                class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md animate-pulse">
                                {{ $pendingReportsCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Báo Cáo Bài Viết --}}
                    <a href="{{ route('admin.post-reports.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.post-reports.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <i
                            class="fas fa-file-exclamation w-5 text-center {{ request()->routeIs('admin.post-reports.*') ? 'text-white' : 'text-slate-400 group-hover:text-purple-400' }}"></i>
                        <span class="font-medium text-sm">Báo Cáo Bài Viết</span>
                        {{-- Badge số lượng báo cáo chờ xử lý --}}
                        @php
                            $pendingPostReportsCount = \App\Models\PostReport::where('status', 'pending')->count();
                        @endphp
                        @if($pendingPostReportsCount > 0)
                            <span
                                class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md animate-pulse">
                                {{ $pendingPostReportsCount }}
                            </span>
                        @endif
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
                            <span id="live-date">{{ date('d/m/Y') }}</span>
                        </div>
                        <script>
                            function updateDate() {
                                const now = new Date();
                                const day = String(now.getDate()).padStart(2, '0');
                                const month = String(now.getMonth() + 1).padStart(2, '0');
                                const year = now.getFullYear();
                                document.getElementById('live-date').textContent = `${day}/${month}/${year}`;
                            }
                            updateDate();
                            setInterval(updateDate, 60000);
                        </script>
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

                @if($errors->any())
                    <div id="validation-alert"
                        class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-400 px-4 py-3 rounded-lg mb-6 shadow-sm transition-all duration-500"
                        style="opacity: 1;">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-xl mt-0.5"></i>
                                <div>
                                    <span class="font-bold block mb-1">Vui lòng kiểm tra lại thông tin:</span>
                                    <ul class="list-disc list-inside text-sm space-y-0.5">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button onclick="dismissAlert('validation-alert')"
                                class="text-amber-500 hover:text-amber-700 dark:hover:text-amber-300 transition flex-shrink-0">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
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

                    // Auto dismiss after 5 seconds (except validation alerts - keep them visible)
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

    {{-- Custom Picker Components Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ===== Year Picker =====
            document.querySelectorAll('.year-picker-container').forEach(container => {
                const trigger = container.querySelector('.year-picker-trigger');
                const dropdown = container.querySelector('.year-picker-dropdown');
                const input = container.querySelector('input[type="hidden"]');
                const display = container.querySelector('.year-picker-display');
                const yearGrid = container.querySelector('.year-grid');
                const rangeDisplay = container.querySelector('.year-range-display');
                const clearBtn = container.querySelector('.year-clear-btn');

                const currentYear = new Date().getFullYear();
                let startYear = currentYear - 10;
                const yearsPerPage = 16;

                function renderYears() {
                    yearGrid.innerHTML = '';
                    const selectedValue = input.value;

                    for (let i = 0; i < yearsPerPage; i++) {
                        const year = startYear + yearsPerPage - 1 - i;
                        if (year < 1800 || year > currentYear + 10) continue;

                        const div = document.createElement('div');
                        div.className = 'year-item';
                        div.textContent = year;
                        div.dataset.year = year;

                        if (year == selectedValue) div.classList.add('selected');
                        if (year == currentYear) div.classList.add('current-year');

                        div.addEventListener('click', () => selectYear(year));
                        yearGrid.insertBefore(div, yearGrid.firstChild);
                    }

                    rangeDisplay.textContent = `${startYear} - ${startYear + yearsPerPage - 1}`;
                }

                function selectYear(year) {
                    input.value = year;
                    display.textContent = year;
                    display.classList.remove('text-gray-400', 'dark:text-slate-500', 'italic');
                    dropdown.classList.add('hidden');
                    dropdown.classList.remove('show');
                    renderYears();
                }

                // Navigation
                container.querySelectorAll('.year-nav-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (btn.dataset.direction === 'prev') {
                            startYear -= yearsPerPage;
                        } else {
                            startYear += yearsPerPage;
                        }
                        renderYears();
                    });
                });

                // Clear button
                if (clearBtn) {
                    clearBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        input.value = '';
                        display.textContent = display.dataset.placeholder || 'Chọn năm...';
                        display.classList.add('text-gray-400', 'dark:text-slate-500', 'italic');
                        dropdown.classList.add('hidden');
                        dropdown.classList.remove('show');
                        renderYears();
                    });
                }

                // Toggle dropdown
                trigger.addEventListener('click', () => {
                    const isHidden = dropdown.classList.contains('hidden');
                    document.querySelectorAll('.year-picker-dropdown').forEach(d => {
                        d.classList.add('hidden');
                        d.classList.remove('show');
                    });
                    if (isHidden) {
                        // Center on selected or current year
                        const selectedYear = parseInt(input.value) || currentYear;
                        startYear = selectedYear - Math.floor(yearsPerPage / 2);
                        renderYears();
                        dropdown.classList.remove('hidden');
                        dropdown.classList.add('show');
                    }
                });

                // Close on click outside
                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target)) {
                        dropdown.classList.add('hidden');
                        dropdown.classList.remove('show');
                    }
                });

                // Initialize
                if (input.value) {
                    display.textContent = input.value;
                    display.classList.remove('text-gray-400', 'dark:text-slate-500', 'italic');
                }
            });

            // ===== Scroll Picker =====
            document.querySelectorAll('.scroll-picker-container').forEach(container => {
                const input = container.querySelector('input[type="hidden"]');
                const wrapper = container.querySelector('.scroll-display-wrapper');
                const decreaseBtn = container.querySelector('.scroll-decrease');
                const increaseBtn = container.querySelector('.scroll-increase');
                const currentValueDisplay = container.querySelector('.scroll-current-value');

                const min = parseInt(container.dataset.min) || 0;
                const max = parseInt(container.dataset.max) || 100;
                const autoText = container.dataset.autoText || '';
                let currentValue = parseInt(input.value) || min;

                function render() {
                    input.value = currentValue;
                    if (currentValueDisplay) {
                        // Show autoText when value is 0 and autoText is set
                        const displayText = (autoText && currentValue === 0) ? autoText : currentValue;
                        currentValueDisplay.textContent = displayText;
                        // Add a subtle scale animation
                        currentValueDisplay.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            currentValueDisplay.style.transform = 'scale(1)';
                        }, 100);
                    }

                    // Update button states
                    if (decreaseBtn) {
                        decreaseBtn.disabled = currentValue <= min;
                        decreaseBtn.style.opacity = currentValue <= min ? '0.5' : '1';
                    }
                    if (increaseBtn) {
                        increaseBtn.disabled = currentValue >= max;
                        increaseBtn.style.opacity = currentValue >= max ? '0.5' : '1';
                    }
                }

                function updateValue(delta) {
                    const newValue = currentValue + delta;
                    if (newValue >= min && newValue <= max) {
                        currentValue = newValue;
                        render();
                    }
                }

                // Button handlers with press-and-hold support
                function setupHoldButton(btn, delta) {
                    if (!btn) return;
                    let holdInterval = null;
                    let holdTimeout = null;
                    let speed = 200; // Initial delay

                    const startHold = () => {
                        updateValue(delta); // Immediate first action
                        speed = 200;
                        holdTimeout = setTimeout(() => {
                            holdInterval = setInterval(() => {
                                updateValue(delta);
                                // Speed up over time (min 50ms)
                                if (speed > 50) {
                                    speed -= 20;
                                    clearInterval(holdInterval);
                                    holdInterval = setInterval(() => updateValue(delta), speed);
                                }
                            }, speed);
                        }, 300); // Wait 300ms before auto-repeat
                    };

                    const stopHold = () => {
                        clearTimeout(holdTimeout);
                        clearInterval(holdInterval);
                        holdInterval = null;
                        holdTimeout = null;
                    };

                    btn.addEventListener('mousedown', startHold);
                    btn.addEventListener('mouseup', stopHold);
                    btn.addEventListener('mouseleave', stopHold);
                    btn.addEventListener('touchstart', (e) => { e.preventDefault(); startHold(); });
                    btn.addEventListener('touchend', stopHold);
                }

                setupHoldButton(decreaseBtn, -1);
                setupHoldButton(increaseBtn, 1);

                // Mouse wheel scroll
                wrapper.addEventListener('wheel', (e) => {
                    e.preventDefault();
                    updateValue(e.deltaY > 0 ? 1 : -1);
                }, { passive: false });

                // Drag scroll
                let isDragging = false;
                let startY = 0;
                let accumulatedDelta = 0;

                wrapper.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    startY = e.clientY;
                    accumulatedDelta = 0;
                    wrapper.style.cursor = 'grabbing';
                });

                document.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    const deltaY = startY - e.clientY;
                    accumulatedDelta += deltaY;
                    startY = e.clientY;

                    // Update value every 20px of drag
                    if (Math.abs(accumulatedDelta) >= 20) {
                        updateValue(accumulatedDelta > 0 ? 1 : -1);
                        accumulatedDelta = 0;
                    }
                });

                document.addEventListener('mouseup', () => {
                    if (isDragging) {
                        isDragging = false;
                        wrapper.style.cursor = 'ns-resize';
                    }
                });

                // Touch support
                wrapper.addEventListener('touchstart', (e) => {
                    isDragging = true;
                    startY = e.touches[0].clientY;
                    accumulatedDelta = 0;
                });

                wrapper.addEventListener('touchmove', (e) => {
                    if (!isDragging) return;
                    e.preventDefault();
                    const deltaY = startY - e.touches[0].clientY;
                    accumulatedDelta += deltaY;
                    startY = e.touches[0].clientY;

                    if (Math.abs(accumulatedDelta) >= 20) {
                        updateValue(accumulatedDelta > 0 ? 1 : -1);
                        accumulatedDelta = 0;
                    }
                }, { passive: false });

                wrapper.addEventListener('touchend', () => {
                    isDragging = false;
                });

                // Initialize
                render();
            });

            // ===== Rating Picker (Interactive Stars 1.0 - 5.0) =====
            document.querySelectorAll('.rating-picker-container').forEach(container => {
                const input = container.querySelector('input[type="hidden"]');
                const starsContainer = container.querySelector('.rating-stars-interactive');
                const starWrappers = container.querySelectorAll('.rating-star-wrapper');

                // Find the inline label value and clear button (in parent div, not inside component)
                const parentDiv = container.closest('div').parentElement;
                const inlineValue = parentDiv ? parentDiv.querySelector('.rating-inline-value') : null;
                const clearBtn = parentDiv ? parentDiv.querySelector('.rating-clear-btn') : null;

                let currentRating = parseFloat(input.value) || 0;
                let hoverRating = 0;
                let isHovering = false;

                function updateStarFills(rating) {
                    starWrappers.forEach((wrapper, index) => {
                        const starIndex = index + 1;
                        const fillEl = wrapper.querySelector('.rating-star-fill');

                        let fillPercent = 0;
                        if (rating >= starIndex) {
                            fillPercent = 100;
                        } else if (rating > starIndex - 1) {
                            fillPercent = (rating - (starIndex - 1)) * 100;
                        }

                        fillEl.style.width = fillPercent + '%';
                    });
                }

                function updateInlineValue(rating, isPreview = false) {
                    if (inlineValue) {
                        if (rating > 0) {
                            // Format: "- ⭐ 4.5" for confirmed, "- 4.5" for preview
                            const starIcon = isPreview ? '' : '⭐ ';
                            inlineValue.textContent = '- ' + starIcon + rating.toFixed(1);
                        } else {
                            inlineValue.textContent = '';
                        }
                    }
                }

                function render() {
                    input.value = currentRating ? currentRating.toFixed(1) : '';
                    updateStarFills(currentRating);
                    updateInlineValue(currentRating, false);

                    // Update clear button visibility
                    if (clearBtn) {
                        if (currentRating > 0) {
                            clearBtn.classList.remove('hidden');
                        } else {
                            clearBtn.classList.add('hidden');
                        }
                    }
                }

                function getDecimalRating(starWrapper, e) {
                    const rect = starWrapper.getBoundingClientRect();
                    const starIndex = parseInt(starWrapper.dataset.star);
                    const x = e.clientX - rect.left;
                    let percent = Math.max(0, Math.min(1, x / rect.width));

                    // Make 5.0 easier to select: if on star 5 and past 70%, snap to 100%
                    if (starIndex === 5 && percent > 0.7) {
                        percent = 1.0;
                    }

                    // Round to nearest 0.1
                    const decimal = Math.round(percent * 10) / 10;
                    return (starIndex - 1) + decimal;
                }

                // Mouse events for each star
                starWrappers.forEach(wrapper => {
                    wrapper.addEventListener('mousemove', (e) => {
                        isHovering = true;
                        hoverRating = getDecimalRating(wrapper, e);
                        // Minimum is 1.0
                        hoverRating = Math.max(1.0, hoverRating);
                        updateStarFills(hoverRating);
                        updateInlineValue(hoverRating, true);
                    });

                    wrapper.addEventListener('click', (e) => {
                        currentRating = getDecimalRating(wrapper, e);
                        currentRating = Math.max(1.0, currentRating);
                        render();
                    });
                });

                // Mouse leave reset to current value
                if (starsContainer) {
                    starsContainer.addEventListener('mouseleave', () => {
                        isHovering = false;
                        hoverRating = 0;
                        render();
                    });
                }

                // Clear button handler
                if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        currentRating = 0;
                        render();
                    });
                }

                // Touch support
                starWrappers.forEach(wrapper => {
                    wrapper.addEventListener('touchstart', (e) => {
                        e.preventDefault();
                        const touch = e.touches[0];
                        const fakeEvent = { clientX: touch.clientX };
                        currentRating = getDecimalRating(wrapper, fakeEvent);
                        currentRating = Math.max(1.0, currentRating);
                        render();
                    });
                });

                // Initialize
                render();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>