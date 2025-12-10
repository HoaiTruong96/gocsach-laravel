@extends('layouts.admin')
@section('title', 'Quản lý Sách')
@section('header', 'Danh sách đầu sách')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-lg font-semibold text-gray-700">Kho sách ({{ $books->total() }})</h2>
        <div class="flex gap-2">
            <form action="{{ route('admin.books.index') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Tìm tên sách..." value="{{ request('q') }}" class="pl-8 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </form>
            <a href="{{ route('admin.books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i> Thêm mới
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Sách</th>
                    <th class="px-6 py-3">Tác giả</th>
                    <th class="px-6 py-3 w-64">Danh mục</th>
                    <th class="px-6 py-3 text-center">Trạng thái</th>
                    <th class="px-6 py-3 text-right">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($books as $book)
                <tr class="hover:bg-gray-50 group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $book->cover_image ? Storage::url($book->cover_image) : 'https://placehold.co/50' }}" class="w-10 h-14 object-cover rounded border bg-gray-100">
                            <div>
                                <span class="font-medium text-gray-800 block">{{ Str::limit($book->title, 30) }}</span>
                                <span class="text-xs text-gray-400">View: {{ number_format($book->view_count) }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $book->author_name }}</td>

                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($book->categories as $cat)
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[10px] font-medium border border-blue-100">
                                {{ $cat->name }}
                            </span>
                            @empty
                            <span class="text-gray-400 text-xs italic">Chưa phân loại</span>
                            @endforelse
                        </div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($book->is_approved)
                        <span class="inline-flex items-center gap-1 text-green-600 bg-green-50 px-2 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle"></i> Đã duyệt
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-clock"></i> Chờ duyệt
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-gray-500 hover:text-blue-600" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Xóa sách này?');">
                                @csrf @method('DELETE')
                                <button class="text-gray-500 hover:text-red-500" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $books->links() }}
    </div>
</div>
@endsection