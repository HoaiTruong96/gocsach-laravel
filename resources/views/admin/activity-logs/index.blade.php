@extends('layouts.admin')
@section('title', 'Lịch Sử Hoạt Động')
@section('header', 'Lịch Sử Hoạt Động Admin')

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
        <!-- Header với thống kê nhanh -->
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-history text-indigo-500"></i>
                        Theo dõi hoạt động Admin
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Xem lịch sử tất cả các hành động của các quản trị viên</p>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border">
                        <span class="text-gray-500">Hôm nay:</span>
                        <span
                            class="font-bold text-indigo-600">{{ \App\Models\AdminActivityLog::whereDate('created_at', today())->count() }}</span>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border">
                        <span class="text-gray-500">Tuần này:</span>
                        <span
                            class="font-bold text-green-600">{{ \App\Models\AdminActivityLog::where('created_at', '>=', now()->startOfWeek())->count() }}</span>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border">
                        <span class="text-gray-500">Tổng:</span>
                        <span class="font-bold text-gray-700">{{ \App\Models\AdminActivityLog::count() }}</span>
                    </div>
                    <a href="{{ route('admin.activity-logs.trash') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition shadow-sm border border-red-200">
                        <i class="fas fa-trash"></i>
                        <span>Thùng rác</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bộ lọc -->
        <div class="p-4 bg-gray-50 border-b border-gray-100">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Admin</label>
                    <select name="admin_id"
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="">Tất cả admin</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Loại hành động</label>
                    <select name="action"
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="">Tất cả</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Từ ngày</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mô tả..."
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-search mr-1"></i> Lọc
                </button>
                <a href="{{ route('admin.activity-logs.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-times mr-1"></i> Xóa lọc
                </a>
            </form>
        </div>

        <!-- Danh sách logs -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 font-medium">
                    <tr>
                        <th class="px-4 py-3">Thời gian</th>
                        <th class="px-4 py-3">Admin</th>
                        <th class="px-4 py-3">Hành động</th>
                        <th class="px-4 py-3">Mô tả</th>
                        <th class="px-4 py-3">IP Address</th>
                        <th class="px-4 py-3 text-center">Chi tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-gray-800 font-medium">{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $log->admin->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($log->admin->name) . '&background=random' }}"
                                        class="w-8 h-8 rounded-full object-cover border-2 border-gray-100">
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $log->admin->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $log->admin->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold {{ $log->action_color }}">
                                    <i class="fas {{ $log->action_icon }}"></i>
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-700 max-w-xs truncate" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </div>
                                @if($log->model_type)
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs font-mono">
                                {{ $log->ip_address }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.activity-logs.show', $log) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                <p>Chưa có lịch sử hoạt động nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="p-4 bg-gray-50 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- Cleanup section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h4 class="font-bold text-gray-700 mb-3">
            <i class="fas fa-broom text-orange-500 mr-2"></i>
            Dọn dẹp Log cũ
        </h4>
        <p class="text-sm text-gray-500 mb-4">Xóa các log cũ để giảm tải database. Hành động này không thể hoàn tác.</p>
        <form method="POST" action="{{ route('admin.activity-logs.cleanup') }}" class="flex items-center gap-3"
            onsubmit="return confirm('Bạn có chắc muốn xóa các log cũ?')">
            @csrf
            <select name="days"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 outline-none bg-gray-50">
                <option value="30">Cũ hơn 30 ngày</option>
                <option value="60">Cũ hơn 60 ngày</option>
                <option value="90" selected>Cũ hơn 90 ngày</option>
                <option value="180">Cũ hơn 180 ngày</option>
                <option value="365">Cũ hơn 1 năm</option>
            </select>
            <button type="submit"
                class="px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition">
                <i class="fas fa-trash-alt mr-1"></i> Dọn dẹp
            </button>
        </form>
    </div>
@endsection