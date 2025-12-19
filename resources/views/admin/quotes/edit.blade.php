@extends('layouts.admin')
@section('title', 'Sửa Châm Ngôn')
@section('header', 'Chỉnh Sửa Châm Ngôn')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                <h2 class="font-bold text-gray-800 dark:text-white text-lg flex items-center gap-2">
                    <i class="fas fa-edit text-amber-500"></i>
                    Chỉnh Sửa Châm Ngôn
                </h2>
            </div>

            <form action="{{ route('admin.quotes.update', $quote->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Nội dung --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">
                        Nội dung châm ngôn <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" rows="4" required
                        class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-700 dark:text-white transition"
                        placeholder="Nhập nội dung câu châm ngôn...">{{ old('content', $quote->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tác giả --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">
                        Tác giả <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author" value="{{ old('author', $quote->author) }}" required
                        class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-700 dark:text-white transition"
                        placeholder="Ví dụ: Albert Einstein">
                    @error('author')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nguồn (optional) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">
                        Nguồn <span class="text-gray-400 font-normal">(Tùy chọn)</span>
                    </label>
                    <input type="text" name="source" value="{{ old('source', $quote->source) }}"
                        class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-700 dark:text-white transition"
                        placeholder="Ví dụ: Tên sách, bài viết...">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    {{-- Thứ tự --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">
                            Thứ tự hiển thị
                        </label>
                        <input type="number" name="order" value="{{ old('order', $quote->order) }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full px-4 py-3 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-700 dark:text-white transition">
                    </div>

                    {{-- Trạng thái --}}
                    <div class="flex items-center pt-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ $quote->is_active ? 'checked' : '' }}
                                class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">Hiển thị</span>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('admin.quotes.index') }}"
                        class="px-5 py-2.5 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-slate-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-slate-500 transition">
                        Hủy
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium shadow-sm transition flex items-center gap-2">
                        <i class="fas fa-save"></i> Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection