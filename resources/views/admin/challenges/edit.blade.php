@extends('layouts.admin')
@section('title', 'Sửa Thử Thách')
@section('header', 'Sửa Thử Thách: ' . $challenge->name)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors duration-300">
            <form action="{{ route('admin.challenges.update', $challenge) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên thử thách <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $challenge->name) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Danh hiệu nhận được
                            <span class="text-red-500">*</span></label>
                        <select name="badge_id"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                            @foreach($badges as $badge)
                                <option value="{{ $badge->id }}" {{ $challenge->badge_id == $badge->id ? 'selected' : '' }}>
                                    {{ $badge->icon ?? '🏅' }} {{ $badge->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('badge_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Số bài review cần
                            viết <span class="text-red-500">*</span></label>
                        <input type="number" name="target_count" value="{{ old('target_count', $challenge->target_count) }}"
                            min="1"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                        @error('target_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Bắt đầu <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="start_date"
                                value="{{ old('start_date', $challenge->start_date->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                            @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kết thúc <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="end_date"
                                value="{{ old('end_date', $challenge->end_date->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                            @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mô tả</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">{{ old('description', $challenge->description) }}</textarea>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" {{ $challenge->is_active ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 rounded focus:ring-green-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-slate-300">Kích hoạt</label>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-medium transition">
                            <i class="fas fa-save mr-1"></i> Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.game.index', ['tab' => 'challenges']) }}"
                            class="px-6 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 font-medium transition">
                            Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection