@extends('layouts.admin')
@section('title', 'Sửa Banner')
@section('header', 'Cập nhật Banner')

@section('content')
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 max-w-4xl mx-auto transition-colors duration-300">
        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Cột Trái --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Tiêu đề chính <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Tag nhỏ</label>
                        <input type="text" name="tag" value="{{ old('tag', $banner->tag) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Mô tả</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">{{ old('description', $banner->description) }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Đánh giá</label>
                            <input type="text" name="rating" value="{{ old('rating', $banner->rating) }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Thứ tự</label>
                            <input type="number" name="order" value="{{ old('order', $banner->order) }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                        </div>
                    </div>
                </div>

                {{-- Cột Phải --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Hình ảnh hiện
                            tại</label>
                        <div
                            class="mb-3 rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 w-full h-48 bg-gray-50 dark:bg-slate-700 flex items-center justify-center">
                            <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}"
                                class="h-full w-full object-cover">
                        </div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Chọn ảnh mới (Nếu muốn
                            thay đổi)</label>
                        <input type="file" name="image"
                            class="w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/70">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Đường dẫn</label>
                        <input type="text" name="link" value="{{ old('link', $banner->link) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">
                    </div>
                    <div class="pt-4">
                        <label
                            class="flex items-center gap-3 p-4 border dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                            <input type="checkbox" name="is_active" {{ $banner->is_active ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded">
                            <span class="font-medium text-gray-700 dark:text-slate-300">Đang hiển thị (Active)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.banners.index') }}"
                    class="px-6 py-2.5 rounded-lg text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 font-bold transition">Hủy</a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg transition">Cập
                    Nhật Banner</button>
            </div>
        </form>
    </div>
@endsection