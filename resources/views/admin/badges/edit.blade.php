@extends('layouts.admin')
@section('title', 'Sửa Danh Hiệu')
@section('header', 'Sửa Danh Hiệu: ' . $badge->name)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors duration-300">
            <form action="{{ route('admin.badges.update', $badge) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên danh hiệu <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $badge->name) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mô tả</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">{{ old('description', $badge->description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Icon (emoji hoặc
                            URL)</label>
                        <input type="text" name="icon" value="{{ old('icon', $badge->icon) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" {{ $badge->is_active ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-slate-300">Kích hoạt</label>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium transition">
                            <i class="fas fa-save mr-1"></i> Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.game.index') }}"
                            class="px-6 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 font-medium transition">
                            Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection