@extends('layouts.admin')
@section('title', 'Quản lý Banner')
@section('header', 'Danh sách Banner')

@section('content')
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
            <h2 class="font-bold text-gray-800 dark:text-white">Danh sách Slider Trang chủ</h2>
            <a href="{{ route('admin.banners.create') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm shadow-sm transition">
                <i class="fas fa-plus mr-2"></i> Thêm Banner Mới
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-300 font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-4 w-20">TT</th>
                        <th class="px-6 py-4 w-32">Hình ảnh</th>
                        <th class="px-6 py-4">Tiêu đề / Mô tả</th>
                        <th class="px-6 py-4 w-32 text-center">Trạng thái</th>
                        <th class="px-6 py-4 w-32 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-slate-400">#{{ $banner->order }}</td>
                            <td class="px-6 py-4">
                                <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}"
                                    class="h-16 w-24 object-cover rounded-lg border border-gray-200 dark:border-slate-600 shadow-sm"
                                    alt="Banner Img">
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 dark:text-white text-base mb-1">{{ $banner->title }}</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400 line-clamp-1">{{ $banner->description }}
                                </div>
                                @if($banner->tag)
                                    <span
                                        class="inline-block mt-2 px-2 py-0.5 bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 text-[10px] font-bold rounded uppercase">{{ $banner->tag }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($banner->is_active)
                                    <span
                                        class="px-2 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-xs font-bold rounded-full">Hiển
                                        thị</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-300 text-xs font-bold rounded-full">Đang
                                        ẩn</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition"
                                        title="Sửa">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-600 hover:text-white transition"
                                            title="Xóa">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 dark:text-slate-500 italic">Chưa có
                                banner nào. Hãy thêm mới!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection