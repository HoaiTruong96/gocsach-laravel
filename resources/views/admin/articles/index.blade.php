@extends('layouts.admin')
@section('title', 'Quản lý Tạp Chí Đọc')
@section('header', 'Danh sách Bài viết')

@section('content')
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-white text-lg">Quản lý Tạp Chí Đọc</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Các bài viết trong mục Tạp Chí Đọc trên trang chủ</p>
            </div>
            {{-- Có thể thêm nút tạo mới sau --}}
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-300 font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-4 w-16">ID</th>
                        <th class="px-6 py-4">Hình ảnh</th>
                        <th class="px-6 py-4">Tiêu đề</th>
                        <th class="px-6 py-4 w-32">Tag</th>
                        <th class="px-6 py-4 w-28 text-center">Nổi bật</th>
                        <th class="px-6 py-4 w-40">Ngày tạo</th>
                        <th class="px-6 py-4 w-28 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-slate-400">#{{ $article->id }}</td>
                            <td class="px-6 py-4">
                                @if($article->thumbnail)
                                    @php
                                        $imgUrl = str_starts_with($article->thumbnail, 'http') 
                                            ? $article->thumbnail 
                                            : asset('storage/' . $article->thumbnail);
                                    @endphp
                                    <img src="{{ $imgUrl }}" alt="{{ $article->title }}" class="w-16 h-12 object-cover rounded-lg shadow-sm">
                                @else
                                    <div class="w-16 h-12 bg-gray-100 dark:bg-slate-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 dark:text-white line-clamp-2">{{ $article->title }}</div>
                                @if($article->excerpt)
                                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-1 line-clamp-1">{{ $article->excerpt }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($article->tag)
                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full">
                                        {{ $article->tag }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($article->is_featured)
                                    <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 text-xs font-bold rounded-full">
                                        <i class="fas fa-star mr-1"></i> Nổi bật
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-slate-400 text-xs">
                                {{ $article->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition"
                                        title="Sửa">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    {{-- Thêm nút xóa nếu cần --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400 dark:text-slate-500 italic">
                                <i class="fas fa-newspaper text-4xl mb-3 block opacity-30"></i>
                                Chưa có bài viết nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse z-50">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
@endsection
