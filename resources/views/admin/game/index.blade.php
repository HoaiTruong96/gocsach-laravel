@extends('layouts.admin')
@section('title', 'Thử Thách, Danh Hiệu & Khung Avatar')
@section('header', 'Quản lý Game & Phần Thưởng')

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
            <button onclick="showTab('frames')" id="tab-frames"
                class="tab-btn px-6 py-2 rounded-lg font-medium transition-all text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                <i class="fas fa-image mr-2"></i>Khung Avatar
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
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Icon</label>

                                    {{-- Icon Type Selector --}}
                                    <div class="flex gap-2 mb-2">
                                        <button type="button" onclick="setIconType('emoji')" id="btn-emoji-type"
                                            class="icon-type-btn flex-1 px-3 py-1.5 rounded-lg border-2 border-blue-500 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium transition-all">
                                            😀 Emoji
                                        </button>
                                        <button type="button" onclick="setIconType('image')" id="btn-image-type"
                                            class="icon-type-btn flex-1 px-3 py-1.5 rounded-lg border border-gray-300 dark:border-slate-600 text-gray-600 dark:text-slate-400 text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition-all">
                                            🖼️ Hình ảnh
                                        </button>
                                    </div>

                                    {{-- Emoji Picker Section --}}
                                    <div id="emoji-picker-section">
                                        <div
                                            class="grid grid-cols-8 gap-1 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg mb-2 max-h-32 overflow-y-auto">
                                            @php
                                                $emojis = ['🏆', '🥇', '🥈', '🥉', '🏅', '🎖️', '⭐', '🌟', '✨', '💎', '👑', '🔥', '💪', '🎯', '🎪', '🎭', '📚', '📖', '📕', '📗', '📘', '📙', '✍️', '🖊️', '📝', '💡', '🧠', '🌸', '🌺', '🌻', '🌈', '☀️', '🌙', '❄️', '🍂', '🌊', '🦋', '🐝', '🦄', '🐉', '🎨', '🎬', '🎵', '🎸', '🎮', '🚀', '✈️', '🏠', '💝', '💖', '❤️', '🧡', '💛', '💚', '💙', '💜', '🤍', '🖤', '🤎', '💔', '❣️', '💗', '💓', '💕'];
                                            @endphp
                                            @foreach($emojis as $emoji)
                                                <button type="button" onclick="selectEmoji('{{ $emoji }}')"
                                                    class="emoji-btn w-8 h-8 flex items-center justify-center text-xl hover:bg-white dark:hover:bg-slate-600 rounded transition-colors">
                                                    {{ $emoji }}
                                                </button>
                                            @endforeach
                                        </div>
                                        <input type="text" id="icon-input" name="icon"
                                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white text-center text-2xl"
                                            placeholder="Chọn hoặc nhập emoji" oninput="updateIconPreview()">
                                    </div>

                                    {{-- Image URL Section --}}
                                    <div id="image-url-section" class="hidden">
                                        <input type="text" id="icon-url-input"
                                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white text-sm"
                                            placeholder="https://example.com/icon.png hoặc .gif"
                                            oninput="updateImageUrlInput()">
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">
                                            Hỗ trợ: .png, .jpg, .gif, .webp, .svg
                                        </p>
                                    </div>

                                    {{-- Preview --}}
                                    <div id="icon-preview"
                                        class="mt-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg text-center hidden">
                                        <span class="text-xs text-gray-500 dark:text-slate-400 block mb-1">Xem trước:</span>
                                        <div id="preview-content" class="text-4xl"></div>
                                    </div>
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
                                                @if($badge->icon && Str::startsWith($badge->icon, 'http'))
                                                    <img src="{{ $badge->icon }}" alt="{{ $badge->name }}"
                                                        class="w-8 h-8 object-contain mr-3 rounded">
                                                @else
                                                    <span class="text-2xl mr-3">{{ $badge->icon ?? '🏅' }}</span>
                                                @endif
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
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Khung
                                        avatar (tùy chọn)</label>
                                    <select name="avatar_frame_id"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                                        <option value="">-- Không tặng khung --</option>
                                        @foreach($frames as $frame)
                                            <option value="{{ $frame->id }}">🖼️ {{ $frame->name }}</option>
                                        @endforeach
                                    </select>
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
                                                {{ $challenge->description }}
                                            </p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="text-gray-600 dark:text-slate-300">
                                                    <i class="fas fa-medal text-yellow-500 mr-1"></i>
                                                    @if($challenge->badge->icon && Str::startsWith($challenge->badge->icon, 'http'))
                                                        <img src="{{ $challenge->badge->icon }}" alt="{{ $challenge->badge->name }}" class="w-5 h-5 object-contain inline-block rounded">
                                                    @else
                                                                {{ $challenge->badge->icon ?? '🏅' }}
                                                            @endif
                                 {{ $challenge->badge->name }}
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

        {{-- AVATAR FRAMES SECTION --}}
        <div id="section-frames" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Form thêm frame --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sticky top-6 transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4 text-lg">
                            <i class="fas fa-plus-circle text-purple-500 mr-2"></i>Thêm Khung Avatar
                        </h3>
                        <form action="{{ route('admin.avatar-frames.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên khung
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="name"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                                        placeholder="VD: Khung Mùa Đông 2025">
                                    @error('name') <p class="error-message text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mô tả</label>
                                    <textarea name="description" rows="2"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white resize-y min-h-[60px]"
                                        placeholder="Mô tả khung avatar..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Hình ảnh (GIF/PNG) <span class="text-red-500">*</span></label>
                                    <input type="file" name="frame_image" accept=".gif,.png,.jpg,.jpeg,.webp"
                                        class="w-full text-sm text-gray-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 dark:file:bg-purple-900/50 file:text-purple-700 dark:file:text-purple-300 hover:file:bg-purple-100">
                                    <p class="text-xs text-gray-400 mt-1">Hoặc dán URL bên dưới</p>
                                </div>
                                <div>
                                    <input type="url" name="frame_image_url"
                                        class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white text-sm"
                                        placeholder="https://example.com/frame.gif">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Thứ tự</label>
                                        <input type="number" name="order" value="0" min="0"
                                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                                    </div>
                                    <div class="flex items-end">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_active" checked class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500 mr-2">
                                            <span class="text-sm text-gray-700 dark:text-slate-300">Kích hoạt</span>
                                        </label>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 font-medium transition-colors">
                                    <i class="fas fa-plus mr-1"></i> Tạo khung avatar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Danh sách frames --}}
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                        <div
                            class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-white">
                                <i class="fas fa-image text-purple-500 mr-2"></i>Tất cả khung avatar ({{ $frames->total() }})
                            </span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 p-4">
                            @forelse($frames as $frame)
                                <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-3 border border-gray-200 dark:border-slate-600 hover:shadow-md transition-shadow group relative">
                                    {{-- Preview Image --}}
                                    <div class="h-24 w-24 mx-auto mb-2 flex items-center justify-center">
                                        <img src="{{ Str::startsWith($frame->frame_image, 'http') ? $frame->frame_image : asset('storage/' . $frame->frame_image) }}"
                                            alt="{{ $frame->name }}" class="max-h-full max-w-full object-contain rounded">
                                    </div>
                                    {{-- Info --}}
                                    <div class="text-center">
                                        <p class="font-medium text-gray-800 dark:text-white text-sm truncate">{{ $frame->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $frame->user_avatar_frames_count }} người sở hữu</p>
                                        @if($frame->is_active)
                                            <span class="inline-block mt-1 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300 px-2 py-0.5 rounded text-xs">Hoạt động</span>
                                        @else
                                            <span class="inline-block mt-1 bg-gray-200 dark:bg-slate-600 text-gray-500 dark:text-slate-400 px-2 py-0.5 rounded text-xs">Tắt</span>
                                        @endif
                                    </div>
                                    {{-- Actions --}}
                                    <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.avatar-frames.edit', $frame) }}"
                                            class="w-7 h-7 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded flex items-center justify-center hover:bg-blue-200">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.avatar-frames.destroy', $frame) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Xóa khung avatar này?');">
                                            @csrf @method('DELETE')
                                            <button class="w-7 h-7 bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 rounded flex items-center justify-center hover:bg-red-200">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                    <i class="fas fa-image text-4xl text-gray-300 dark:text-slate-600 mb-2"></i>
                                    <p>Chưa có khung avatar nào</p>
                                </div>
                            @endforelse
                        </div>
                        @if($frames->hasPages())
                            <div class="p-4 border-t dark:border-slate-700">
                                {{ $frames->appends(['tab' => 'frames'])->links('vendor.pagination.admin') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ========== TAB FUNCTIONS ==========
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

            // ========== ICON TYPE FUNCTIONS ==========
            let currentIconType = 'emoji';

            function setIconType(type) {
                currentIconType = type;
                const btnEmoji = document.getElementById('btn-emoji-type');
                const btnImage = document.getElementById('btn-image-type');
                const emojiSection = document.getElementById('emoji-picker-section');
                const imageSection = document.getElementById('image-url-section');
                const iconInput = document.getElementById('icon-input');
                const iconUrlInput = document.getElementById('icon-url-input');

                if (type === 'emoji') {
                    // Activate emoji button
                    btnEmoji.classList.add('border-2', 'border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                    btnEmoji.classList.remove('border', 'border-gray-300', 'dark:border-slate-600', 'text-gray-600', 'dark:text-slate-400');
                    // Deactivate image button
                    btnImage.classList.remove('border-2', 'border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                    btnImage.classList.add('border', 'border-gray-300', 'dark:border-slate-600', 'text-gray-600', 'dark:text-slate-400');
                    // Show/hide sections
                    emojiSection.classList.remove('hidden');
                    imageSection.classList.add('hidden');
                    // Clear URL value when switching to emoji - only keep if not a URL
                    if (isImageUrl(iconInput.value)) {
                        iconInput.value = '';
                    }
                    iconUrlInput.value = '';
                    updateIconPreview();
                } else {
                    // Activate image button
                    btnImage.classList.add('border-2', 'border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                    btnImage.classList.remove('border', 'border-gray-300', 'dark:border-slate-600', 'text-gray-600', 'dark:text-slate-400');
                    // Deactivate emoji button
                    btnEmoji.classList.remove('border-2', 'border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                    btnEmoji.classList.add('border', 'border-gray-300', 'dark:border-slate-600', 'text-gray-600', 'dark:text-slate-400');
                    // Show/hide sections
                    emojiSection.classList.add('hidden');
                    imageSection.classList.remove('hidden');
                    // Clear emoji input and update
                    iconInput.value = '';
                    updateImageUrlInput();
                }
            }

            function isImageUrl(str) {
                if (!str) return false;
                const imageExtensions = ['.png', '.jpg', '.jpeg', '.gif', '.webp', '.svg'];
                const lowerStr = str.toLowerCase();
                return lowerStr.startsWith('http') && imageExtensions.some(ext => lowerStr.includes(ext));
            }

            function updateIconPreview() {
                const iconInput = document.getElementById('icon-input');
                const preview = document.getElementById('icon-preview');
                const previewContent = document.getElementById('preview-content');
                const value = iconInput.value.trim();

                if (value) {
                    preview.classList.remove('hidden');
                    previewContent.innerHTML = value;
                } else {
                    preview.classList.add('hidden');
                    previewContent.innerHTML = '';
                }
            }

            function selectEmoji(emoji) {
                const iconInput = document.getElementById('icon-input');
                iconInput.value = emoji;
                updateIconPreview();
            }

            function updateImageUrlInput() {
                const iconUrlInput = document.getElementById('icon-url-input');
                const iconInput = document.getElementById('icon-input');
                const preview = document.getElementById('icon-preview');
                const previewContent = document.getElementById('preview-content');
                const url = iconUrlInput.value.trim();

                // Sync to hidden icon input (so form submits correctly)
                iconInput.value = url;

                if (url && isImageUrl(url)) {
                    preview.classList.remove('hidden');
                    previewContent.innerHTML = `<img src="${url}" alt="Preview" class="w-16 h-16 object-contain mx-auto rounded-lg" onerror="this.parentElement.innerHTML='<span class=\'text-red-500 text-sm\'>Không thể tải ảnh</span>'">`;
                } else if (url) {
                    preview.classList.remove('hidden');
                    previewContent.innerHTML = '<span class="text-yellow-500 text-sm">Vui lòng nhập URL hình ảnh hợp lệ</span>';
                } else {
                    preview.classList.add('hidden');
                    previewContent.innerHTML = '';
                }
            }

            // ========== DOM READY ==========
            document.addEventListener('DOMContentLoaded', function () {
                // Đọc tab parameter từ URL và chuyển đến đúng tab
                const urlParams = new URLSearchParams(window.location.search);
                const activeTab = urlParams.get('tab');
                if (activeTab === 'challenges') {
                    showTab('challenges');
                } else if (activeTab === 'frames') {
                    showTab('frames');
                }

                // Tự động ẩn thông báo lỗi sau 5 giây
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