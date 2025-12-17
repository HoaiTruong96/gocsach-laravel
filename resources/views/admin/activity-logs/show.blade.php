@extends('layouts.admin')
@section('title', 'Chi tiết Log #' . $activityLog->id)
@section('header', 'Chi tiết Hoạt động')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.activity-logs.index') }}"
            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Thông tin chính -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-gray-800">
                            <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                            Thông tin hành động
                        </h3>
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold {{ $activityLog->action_color }}">
                            <i class="fas {{ $activityLog->action_icon }}"></i>
                            {{ ucfirst($activityLog->action) }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 sm:w-32">Mô tả:</dt>
                            <dd class="text-sm text-gray-800">{{ $activityLog->description }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 sm:w-32">Thời gian:</dt>
                            <dd class="text-sm text-gray-800">
                                {{ $activityLog->created_at->format('d/m/Y H:i:s') }}
                                <span class="text-gray-400">({{ $activityLog->created_at->diffForHumans() }})</span>
                            </dd>
                        </div>
                        @if($activityLog->model_type)
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 sm:w-32">Đối tượng:</dt>
                                <dd class="text-sm text-gray-800">
                                    {{ class_basename($activityLog->model_type) }} #{{ $activityLog->model_id }}
                                </dd>
                            </div>
                        @endif
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 sm:w-32">Địa chỉ IP:</dt>
                            <dd class="text-sm font-mono text-gray-800">{{ $activityLog->ip_address ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 sm:w-32">Trình duyệt:</dt>
                            <dd class="text-sm text-gray-600 break-all">{{ $activityLog->user_agent ?? 'N/A' }}</dd>
                        </div>
                    </dl>

                    {{-- Nút Khôi phục nếu là action delete --}}
                    @if($activityLog->action === 'delete' && $activityLog->old_values)
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <form method="POST" action="{{ route('admin.activity-logs.restore', $activityLog) }}"
                                onsubmit="return confirm('Bạn có chắc muốn khôi phục mục này?')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg shadow hover:from-green-600 hover:to-emerald-700 transition-all">
                                    <i class="fas fa-undo"></i>
                                    Khôi phục mục này
                                </button>
                            </form>
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Hệ thống sẽ cố gắng khôi phục dữ liệu từ log đã lưu.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Giá trị cũ -->
            @if($activityLog->old_values)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-red-50">
                        <h3 class="font-bold text-red-700">
                            <i class="fas fa-minus-circle mr-2"></i>
                            Giá trị cũ (Trước)
                        </h3>
                    </div>
                    <div class="p-4">
                        <pre
                            class="bg-gray-900 text-green-400 p-4 rounded-lg text-sm overflow-x-auto">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif

            <!-- Giá trị mới -->
            @if($activityLog->new_values)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-green-50">
                        <h3 class="font-bold text-green-700">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Giá trị mới (Sau)
                        </h3>
                    </div>
                    <div class="p-4">
                        <pre
                            class="bg-gray-900 text-green-400 p-4 rounded-lg text-sm overflow-x-auto">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar - Thông tin Admin -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-800">
                        <i class="fas fa-user-shield text-indigo-500 mr-2"></i>
                        Thực hiện bởi
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <img src="{{ $activityLog->admin->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($activityLog->admin->name) . '&background=random&size=128' }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 mx-auto mb-4">
                    <h4 class="font-bold text-gray-800 text-lg">{{ $activityLog->admin->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $activityLog->admin->email }}</p>
                    <div class="mt-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                            <i class="fas fa-crown mr-1"></i>
                            Admin
                        </span>
                    </div>
                </div>
            </div>

            <!-- Hoạt động gần đây của admin này -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-800 text-sm">
                        <i class="fas fa-clock text-gray-500 mr-2"></i>
                        Hoạt động gần đây
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach(\App\Models\AdminActivityLog::where('admin_id', $activityLog->admin_id)->where('id', '!=', $activityLog->id)->latest()->take(5)->get() as $recentLog)
                        <a href="{{ route('admin.activity-logs.show', $recentLog) }}"
                            class="block p-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs {{ $recentLog->action_color }}">
                                    <i class="fas {{ $recentLog->action_icon }}"></i>
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-700 truncate">{{ $recentLog->description }}</p>
                                    <p class="text-xs text-gray-400">{{ $recentLog->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection