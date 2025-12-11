<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Góc Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: #1e293b;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>

<body class="bg-gray-50 text-slate-800">
    <div class="flex min-h-screen">

        <aside
            class="w-72 bg-slate-900 text-slate-300 flex-shrink-0 hidden lg:flex flex-col sticky top-0 h-screen shadow-xl z-50">

            {{-- 1. Brand Logo --}}
            <div
                class="h-16 flex items-center gap-3 px-6 border-b border-slate-800 bg-slate-950/50 backdrop-blur-sm sticky top-0 z-10">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <i class="fas fa-shield-alt text-sm"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-white tracking-tight">Admin Panel</h1>
                    <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Quản trị hệ thống</p>
                </div>
            </div>

            {{-- 2. Navigation Menu (Scrollable) --}}
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 px-4 space-y-8">

                {{-- Group: Tổng Quan --}}
                <div>
                    <p class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tổng Quan</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
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
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.banners.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-images w-5 text-center {{ request()->routeIs('admin.banners.*') ? 'text-white' : 'text-slate-400 group-hover:text-pink-400' }}"></i>
                        <span class="font-medium text-sm">Quản lý Banner</span>
                    </a>

                    {{-- [MỚI] Quản lý Tạp chí (Article) - Thêm luôn để tiện --}}
                    <a href="{{ route('admin.articles.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-newspaper w-5 text-center {{ request()->routeIs('admin.articles.*') ? 'text-white' : 'text-slate-400 group-hover:text-teal-400' }}"></i>
                        <span class="font-medium text-sm">Tạp Chí Đọc</span>
                    </a>

                    <a href="{{ route('admin.books.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-book w-5 text-center {{ request()->routeIs('admin.books.*') ? 'text-white' : 'text-slate-400 group-hover:text-emerald-400' }}"></i>
                        <span class="font-medium text-sm">Quản lý Sách</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-tags w-5 text-center {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400 group-hover:text-orange-400' }}"></i>
                        <span class="font-medium text-sm">Danh Mục</span>
                    </a>

                    <a href="{{ route('admin.posts.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-star w-5 text-center {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-400 group-hover:text-yellow-400' }}"></i>
                        <span class="font-medium text-sm">Kiểm Duyệt Bài</span>
                        {{-- Badge thông báo (Demo) --}}
                        <span
                            class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md">New</span>
                    </a>
                </div>

                {{-- Group: Người Dùng & Hệ Thống --}}
                <div class="space-y-1">
                    <p class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hệ Thống</p>

                    <a href="{{ route('admin.users.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-users w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}"></i>
                        <span class="font-medium text-sm">Thành Viên</span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fas fa-history w-5 text-center {{ request()->routeIs('admin.activity-logs.*') ? 'text-white' : 'text-slate-400 group-hover:text-purple-400' }}"></i>
                        <span class="font-medium text-sm">Lịch Sử Hoạt Động</span>
                    </a>
                </div>
            </nav>

            {{-- 3. Footer Actions --}}
            <div class="p-4 border-t border-slate-800 bg-slate-950/30">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition-all mb-2 group">
                    <i class="fas fa-external-link-alt w-5 text-center group-hover:text-blue-400"></i>
                    <span class="text-sm">Xem Trang Chủ</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 text-slate-400 hover:bg-red-500/10 hover:text-red-400 rounded-lg transition-all text-left group">
                        <i class="fas fa-sign-out-alt w-5 text-center group-hover:text-red-500"></i>
                        <span class="text-sm font-medium">Đăng Xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-gray-50"> {{-- min-w-0 fixes flex issues --}}

            <div
                class="bg-white border-b border-gray-200 p-4 lg:hidden sticky top-0 z-20 flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-2 font-bold text-slate-800">
                    <i class="fas fa-shield-alt text-blue-600"></i> Admin Panel
                </div>
                <button class="text-slate-500 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <main class="p-6 lg:p-8 flex-1 overflow-y-auto">
                <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">@yield('header')</h1>
                        <p class="text-slate-500 text-sm mt-1">Quản lý hệ thống Góc Sách</p>
                    </div>
                    <div
                        class="flex items-center gap-2 text-sm text-slate-500 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-sm">
                        <i class="far fa-calendar-alt text-blue-500"></i>
                        <span>{{ date('d/m/Y') }}</span>
                    </div>
                </div>

                @if(session('success'))
                    <div
                        class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3 shadow-sm animate-fade-in-down">
                        <i class="fas fa-check-circle text-xl"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>

            {{-- Footer Admin (Optional) --}}
            <footer class="p-6 text-center text-xs text-slate-400 border-t border-gray-200">
                &copy; {{ date('Y') }} Góc Sách Admin Panel. All rights reserved.
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>

</html>