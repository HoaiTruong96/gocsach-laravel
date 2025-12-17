@extends('layouts.admin')
@section('title', 'Thử Thách & Danh Hiệu')
@section('header', 'Quản lý Thử Thách & Danh Hiệu')

@section('content')
    <div class="space-y-6">
        {{-- Tab Navigation --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-1 inline-flex transition-colors duration-300">
            <button onclick="showTab('badges')" id="tab-badges"
                class="tab-btn px-6 py-2 rounded-lg font-medium transition-all bg-blue-600 text-white">
                <i class="fas fa-medal mr-2"></i>Danh Hiệu
            </button>
            <button onclick="showTab('challenges')" id="tab-challenges"
                class="tab-btn px-6 py-2 rounded-lg font-medium transition-all text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                <i class="fas fa-trophy mr-2"></i>Thử Thách
            </button>
        </div>

        {{-- BADGES SECTION --}}
        <div id="section-badges" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Form thêm badge --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sticky top-6 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4 text-lg">
                            <i class="fas fa-plus-circle text-blue-500 mr-2"></i>Thêm Danh Hiệu
                        </h3>
                        <form action="{{ route('admin.badges.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên danh
                                        hiệu <span class="text-red-500">*</span></label>
                                    <input type="text" name="name"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="VD: Mọt Sách Mùa Đông">
                                    @error('name') <p class="error-message text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mô
                                        tả</label>
                                    <textarea name="description" rows="2"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="Mô tả danh hiệu..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Icon
                                        (emoji hoặc
                                        URL)</label>
                                    <input type="text" name="icon"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="🏆 hoặc URL hình ảnh">
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="badge_active" checked
                                        class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                    <label for="badge_active" class="ml-2 text-sm text-gray-700 dark:text-slate-300">Kích
                                        hoạt</label>
                                </div>
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                    <i class="fas fa-plus mr-1"></i> Tạo danh hiệu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Danh sách badges --}}
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                        <div
                            class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-white">
                                <i class="fas fa-medal text-yellow-500 mr-2"></i>Tất cả danh hiệu ({{ $badges->total() }})
                            </span>
                        </div>
                        <table class="w-full text-left">
                            <thead
                                class="text-xs text-gray-500 dark:text-slate-400 uppercase bg-white dark:bg-slate-800 border-b dark:border-slate-700">
                                <tr>
                                    <th class="px-6 py-3">Danh hiệu</th>
                                    <th class="px-6 py-3 text-center">Thử thách</th>
                                    <th class="px-6 py-3 text-center">Người nhận</th>
                                    <th class="px-6 py-3 text-center">Trạng thái</th>
                                    <th class="px-6 py-3 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                                @forelse($badges as $badge)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <span class="text-2xl mr-3">{{ $badge->icon ?? '🏅' }}</span>
                                                <div>
                                                    <p class="font-medium text-gray-800 dark:text-white">{{ $badge->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-slate-400">
                                                        {{ Str::limit($badge->description, 50) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-300 px-2 py-1 rounded text-xs font-bold">
                                                {{ $badge->challenges_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300 px-2 py-1 rounded text-xs font-bold">
                                                {{ $badge->user_badges_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($badge->is_active)
                                                <span
                                                    class="bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300 px-2 py-1 rounded text-xs font-bold">Hoạt
                                                    động</span>
                                            @else
                                                <span
                                                    class="bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-400 px-2 py-1 rounded text-xs font-bold">Tắt</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div
                                                class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.badges.edit', $badge) }}"
                                                    class="text-blue-400 hover:text-blue-600">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.badges.destroy', $badge) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Xóa danh hiệu này?');">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-400 hover:text-red-600">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                            <i class="fas fa-medal text-4xl text-gray-300 dark:text-slate-600 mb-2"></i>
                                            <p>Chưa có danh hiệu nào</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($badges->hasPages())
                            <div class="p-4 border-t dark:border-slate-700">
                                {{ $badges->links('vendor.pagination.admin') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- CHALLENGES SECTION --}}
        <div id="section-challenges" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Form thêm challenge --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sticky top-6 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4 text-lg">
                            <i class="fas fa-plus-circle text-green-500 mr-2"></i>Thêm Thử Thách
                        </h3>
                        <form action="{{ route('admin.challenges.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên thử
                                        thách <span class="text-red-500">*</span></label>
                                    <input type="text" name="name"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="VD: Season Mùa Đông 2025">
                                    @error('name') <p class="error-message text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Danh
                                        hiệu nhận được <span class="text-red-500">*</span></label>
                                    <select name="badge_id"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                                        <option value="">-- Chọn danh hiệu --</option>
                                        @foreach($badges as $badge)
                                            <option value="{{ $badge->id }}">{{ $badge->icon ?? '🏅' }} {{ $badge->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('badge_id') <p class="error-message text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Số bài
                                        review cần viết <span class="text-red-500">*</span></label>
                                    <input type="number" name="target_count" min="1"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="VD: 5">
                                    @error('target_count') <p class="error-message text-red-500 text-xs mt-1">{{ $message }}
                                    </p> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Bắt
                                            đầu <span class="text-red-500">*</span></label>
                                        <input type="date" name="start_date"
                                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                                        @error('start_date') <p class="error-message text-red-500 text-xs mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kết
                                            thúc <span class="text-red-500">*</span></label>
                                        <input type="date" name="end_date"
                                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                                        @error('end_date') <p class="error-message text-red-500 text-xs mt-1">{{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mô
                                        tả</label>
                                    <textarea name="description" rows="2"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="Mô tả thử thách..."></textarea>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="challenge_active" checked
                                        class="w-4 h-4 text-green-600 rounded focus:ring-green-500">
                                    <label for="challenge_active"
                                        class="ml-2 text-sm text-gray-700 dark:text-slate-300">Kích hoạt</label>
                                </div>
                                <button type="submit"
                                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-medium transition-colors">
                                    <i class="fas fa-plus mr-1"></i> Tạo thử thách
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Danh sách challenges --}}
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                        <div
                            class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-white">
                                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Tất cả thử thách
                                ({{ $challenges->total() }})
                            </span>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse($challenges as $challenge)
                                <div class="p-4 hover:bg-gray-50 dark:hover:bg-slate-700 group">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-semibold text-gray-800 dark:text-white">{{ $challenge->name }}
                                                </h4>
                                                @if($challenge->isOngoing())
                                                    <span
                                                        class="bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300 px-2 py-0.5 rounded text-xs font-bold">Đang
                                                        diễn ra</span>
                                                @elseif($challenge->end_date < now())
                                                    <span
                                                        class="bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-400 px-2 py-0.5 rounded text-xs font-bold">Đã
                                                        kết thúc</span>
                                                @else
                                                    <span
                                                        class="bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 px-2 py-0.5 rounded text-xs font-bold">Sắp
                                                        diễn ra</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-slate-400 mb-2">
                                                {{ $challenge->description }}</p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="text-gray-600 dark:text-slate-300">
                                                    <i class="fas fa-medal text-yellow-500 mr-1"></i>
                                                    {{ $challenge->badge->icon ?? '🏅' }} {{ $challenge->badge->name }}
                                                </span>
                                                <span class="text-gray-600 dark:text-slate-300">
                                                    <i class="fas fa-pen mr-1"></i>{{ $challenge->target_count }} reviews
                                                </span>
                                                <span class="text-gray-600 dark:text-slate-300">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $challenge->start_date->format('d/m') }} -
                                                    {{ $challenge->end_date->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-4 mt-2 text-sm">
                                                <span class="text-purple-600 dark:text-purple-400">
                                                    <i class="fas fa-users mr-1"></i>{{ $challenge->user_challenges_count }}
                                                    người tham gia
                                                </span>
                                                <span class="text-green-600 dark:text-green-400">
                                                    <i class="fas fa-check-circle mr-1"></i>{{ $challenge->completed_count }}
                                                    hoàn thành
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.challenges.show', $challenge) }}"
                                                class="text-blue-400 hover:text-blue-600" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.challenges.edit', $challenge) }}"
                                                class="text-yellow-400 hover:text-yellow-600" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.challenges.destroy', $challenge) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Xóa thử thách này?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-400 hover:text-red-600" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                    <i class="fas fa-trophy text-4xl text-gray-300 dark:text-slate-600 mb-2"></i>
                                    <p>Chưa có thử thách nào</p>
                                </div>
                            @endforelse
                        </div>
                        @if($challenges->hasPages())
                            <div class="p-4 border-t dark:border-slate-700">
                                {{ $challenges->links('vendor.pagination.admin') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showTab(tab) {
                // Hide all sections
                document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
                // Remove active from all tabs
                document.querySelectorAll('.tab-btn').forEach(el => {
                    el.classList.remove('bg-blue-600', 'text-white');
                    el.classList.add('text-gray-600', 'hover:bg-gray-100');
                });

                // Show selected section
                document.getElementById('section-' + tab).classList.remove('hidden');
                // Activate selected tab
                const activeTab = document.getElementById('tab-' + tab);
                activeTab.classList.add('bg-blue-600', 'text-white');
                activeTab.classList.remove('text-gray-600', 'hover:bg-gray-100');

                // Xóa tất cả thông báo lỗi khi chuyển tab
                document.querySelectorAll('.error-message').forEach(el => el.remove());
            }

            // Tự động ẩn thông báo lỗi sau 5 giây
            document.addEventListener('DOMContentLoaded', function () {
                // Đọc tab parameter từ URL và chuyển đến đúng tab
                const urlParams = new URLSearchParams(window.location.search);
                const activeTab = urlParams.get('tab');
                if (activeTab === 'challenges') {
                    showTab('challenges');
                }

                setTimeout(function () {
                    document.querySelectorAll('.error-message').forEach(el => {
                        el.style.transition = 'opacity 0.5s';
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 500);
                    });
                }, 5000);

                // Tự động ẩn thông báo success sau 3 giây
                const successMsg = document.querySelector('.bg-green-100');
                if (successMsg) {
                    setTimeout(function () {
                        successMsg.style.transition = 'opacity 0.5s';
                        successMsg.style.opacity = '0';
                        setTimeout(() => successMsg.remove(), 500);
                    }, 3000);
                }
            });
        </script>
    @endpush
@endsection