@extends('layouts.admin')
@section('title', 'Quản lý Châm Ngôn')
@section('header', 'Danh sách Châm Ngôn')

@section('content')
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-white text-lg">Quản lý Châm Ngôn</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Các câu châm ngôn hiển thị ngẫu nhiên theo ngày trên trang chủ</p>
            </div>
            <a href="{{ route('admin.quotes.create') }}"
                class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium text-sm shadow-sm transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Thêm Châm Ngôn
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-300 font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-4 w-16">TT</th>
                        <th class="px-6 py-4">Nội dung</th>
                        <th class="px-6 py-4 w-48">Tác giả</th>
                        <th class="px-6 py-4 w-32">Nguồn</th>
                        <th class="px-6 py-4 w-28 text-center">Trạng thái</th>
                        <th class="px-6 py-4 w-28 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($quotes as $quote)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-slate-400">#{{ $quote->order }}</td>
                            <td class="px-6 py-4">
                                <div class="text-gray-800 dark:text-white line-clamp-2 italic">
                                    "{{ $quote->content }}"
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 dark:text-white">{{ $quote->author }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-slate-400">
                                {{ $quote->source ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($quote->is_active)
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-xs font-bold rounded-full">
                                        Hiển thị
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-300 text-xs font-bold rounded-full">
                                        Đang ẩn
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.quotes.edit', $quote->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition"
                                        title="Sửa">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa châm ngôn này?');">
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
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 dark:text-slate-500 italic">
                                <i class="fas fa-quote-left text-4xl mb-3 block opacity-30"></i>
                                Chưa có châm ngôn nào. Hãy thêm mới!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($quotes->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                {{ $quotes->links() }}
            </div>
        @endif
    </div>
@endsection
