@extends('layouts.admin')
@section('title', 'Nhật Ký Hoạt Động')
@section('header', 'Nhật Ký Hoạt Động')

@section('content')
    @php
        $todayCount = \App\Models\AdminActivityLog::whereDate('created_at', today())->count();
        $weekCount = \App\Models\AdminActivityLog::where('created_at', '>=', now()->startOfWeek())->count();
        $totalCount = \App\Models\AdminActivityLog::count();
    @endphp

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        {{-- Header với stats --}}
        <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-gray-700 dark:text-slate-200 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-blue-500"></i>Theo dõi hoạt động Admin
                    </span>
                    <div class="flex gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-full font-bold whitespace-nowrap">
                            <i class="fas fa-calendar-day"></i>{{ $todayCount }} hôm nay
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 rounded-full font-bold whitespace-nowrap">
                            <i class="fas fa-calendar-week"></i>{{ $weekCount }} tuần
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 dark:bg-slate-600 text-gray-600 dark:text-slate-300 rounded-full font-bold whitespace-nowrap">
                            <i class="fas fa-database"></i>{{ $totalCount }} tổng
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.activity-logs.trash') }}"
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 font-medium text-sm rounded-lg hover:bg-red-200 dark:hover:bg-red-900/60 transition">
                    <i class="fas fa-trash text-xs"></i>Thùng rác
                </a>
            </div>
        </div>

        {{-- Bộ lọc --}}
        <div class="p-4 bg-white dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs text-gray-500 dark:text-slate-400 mb-1 font-medium">Admin</label>
                    <select name="admin_id"
                        class="border dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 dark:bg-slate-700 dark:text-white min-w-[140px]">
                        <option value="">Tất cả</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 dark:text-slate-400 mb-1 font-medium">Hành động</label>
                    <select name="action"
                        class="border dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 dark:bg-slate-700 dark:text-white min-w-[120px]">
                        <option value="">Tất cả</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 dark:text-slate-400 mb-1 font-medium">Từ ngày</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="border dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 dark:text-slate-400 mb-1 font-medium">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="border dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 dark:text-slate-400 mb-1 font-medium">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mô tả..."
                        class="border dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 dark:bg-slate-700 dark:text-white placeholder:italic placeholder:text-gray-400 dark:placeholder:text-slate-500 w-40">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search mr-1"></i>Lọc
                    </button>
                    @if(request()->hasAny(['admin_id', 'action', 'date_from', 'date_to', 'search']))
                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 text-sm font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-slate-500 transition">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Bảng --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-800 text-gray-500 dark:text-slate-400 text-xs uppercase border-b dark:border-slate-700">
                    <tr>
                        <th class="px-4 py-3 w-28 whitespace-nowrap">Thời gian</th>
                        <th class="px-4 py-3 w-48">Admin</th>
                        <th class="px-4 py-3 w-24 whitespace-nowrap">Hành động</th>
                        <th class="px-4 py-3">Mô tả</th>
                        <th class="px-4 py-3 w-28 whitespace-nowrap">IP</th>
                        <th class="px-4 py-3 w-16 text-center"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 group transition">
                            <td class="px-4 py-3 whitespace-nowrap align-top">
                                <div class="text-sm text-gray-800 dark:text-white font-medium">{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-400 dark:text-slate-500 italic">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $log->admin->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($log->admin->name) }}"
                                        class="w-8 h-8 rounded-full border dark:border-slate-600">
                                    <div class="min-w-0">
                                        <div class="text-sm font-bold text-gray-800 dark:text-white truncate">{{ $log->admin->name }}</div>
                                        <div class="text-xs text-gray-400 dark:text-slate-500 truncate">{{ $log->admin->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap {{ $log->action_color }}">
                                    <i class="fas {{ $log->action_icon }}"></i>{{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="text-sm text-gray-700 dark:text-slate-300 line-clamp-1" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </div>
                                @if($log->model_type)
                                    <div class="text-xs text-gray-400 dark:text-slate-500 italic mt-0.5">
                                        {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top">
                                <span class="text-xs text-gray-500 dark:text-slate-400 font-mono bg-gray-100 dark:bg-slate-700 px-2 py-0.5 rounded">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center align-top">
                                <a href="{{ route('admin.activity-logs.show', $log) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 hover:bg-blue-500 dark:hover:bg-blue-600 hover:text-white transition opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-400 dark:text-slate-500">
                                <i class="fas fa-clipboard-list text-4xl mb-3"></i>
                                <p>Chưa có nhật ký hoạt động nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700">
                {{ $logs->links('vendor.pagination.admin') }}
            </div>
        @endif
    </div>

    {{-- Cleanup section --}}
    <div class="mt-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-gray-700 dark:text-white flex items-center gap-2">
                    <i class="fas fa-broom text-orange-500"></i>Dọn dẹp Log cũ
                </h4>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Xóa các log cũ để giảm tải database. Không thể hoàn tác.</p>
            </div>
            <form method="POST" action="{{ route('admin.activity-logs.cleanup') }}" class="flex items-center gap-2"
                onsubmit="return confirm('Bạn có chắc muốn xóa các log cũ?')">
                @csrf
                <select name="days"
                    class="border dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 outline-none bg-gray-50 dark:bg-slate-700 dark:text-white">
                    <option value="30">Cũ hơn 30 ngày</option>
                    <option value="60">Cũ hơn 60 ngày</option>
                    <option value="90" selected>Cũ hơn 90 ngày</option>
                    <option value="180">Cũ hơn 180 ngày</option>
                    <option value="365">Cũ hơn 1 năm</option>
                </select>
                <button type="submit"
                    class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition">
                    <i class="fas fa-trash-alt mr-1"></i>Dọn dẹp
                </button>
            </form>
        </div>
    </div>
@endsection