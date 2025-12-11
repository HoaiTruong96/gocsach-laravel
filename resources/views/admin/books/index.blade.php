@extends('layouts.admin')
@section('title', 'Quản lý Sách')
@section('header', 'Danh sách đầu sách')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-lg font-semibold text-gray-700">Kho sách ({{ $books->total() }})</h2>

        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <form action="{{ route('admin.books.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">

                <select name="category_id" onchange="this.form.submit()" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white cursor-pointer hover:border-blue-400 transition">
                    <option value="all">-- Tất cả danh mục --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>

                <div class="relative w-full md:w-64">
                    <input type="text" name="keyword" placeholder="Tên sách, tác giả..." value="{{ request('keyword') }}"
                        class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                </div>

                <button type="submit" class="hidden">Tìm</button>

                @if(request('keyword') || request('category_id') && request('category_id') != 'all')
                <a href="{{ route('admin.books.index') }}" class="px-3 py-2 text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition text-center" title="Xóa bộ lọc">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>

            <a href="{{ route('admin.books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center justify-center shadow-sm transition transform hover:scale-105">
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
                @forelse($books as $book)
                <tr class="hover:bg-gray-50 group transition duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="relative w-10 h-14 flex-shrink-0">
                                <img src="{{ $book->cover_image ? Storage::url($book->cover_image) : 'https://placehold.co/50' }}"
                                    class="w-full h-full object-cover rounded border border-gray-200 bg-gray-100 shadow-sm"
                                    alt="{{ $book->title }}">
                            </div>
                            <div>
                                <span class="font-bold text-gray-800 block text-sm leading-tight mb-1" title="{{ $book->title }}">
                                    {{ Str::limit($book->title, 35) }}
                                </span>
                                <span class="text-[10px] text-gray-400 flex items-center gap-1">
                                    <i class="far fa-eye"></i> {{ number_format($book->view_count) }} lượt xem
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-gray-600 text-sm font-medium">
                        {{ $book->author_name }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($book->categories as $cat)
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-[10px] font-bold border border-blue-100 whitespace-nowrap">
                                {{ $cat->name }}
                            </span>
                            @empty
                            <span class="text-gray-400 text-xs italic">Chưa phân loại</span>
                            @endforelse
                        </div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($book->is_approved)
                        <span class="inline-flex items-center gap-1 text-green-700 bg-green-100 px-2 py-1 rounded-full text-[10px] font-bold border border-green-200">
                            <i class="fas fa-check-circle"></i> Đã duyệt
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full text-[10px] font-bold border border-yellow-200">
                            <i class="fas fa-clock"></i> Chờ duyệt
                        </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end items-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.books.edit', $book) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-blue-100 hover:text-blue-600 transition" title="Chỉnh sửa">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cuốn sách này không?');">
                                @csrf @method('DELETE')
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition" title="Xóa">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                            <p>Không tìm thấy cuốn sách nào phù hợp.</p>
                            @if(request('keyword') || request('category_id'))
                            <a href="{{ route('admin.books.index') }}" class="text-blue-600 text-sm hover:underline mt-1 font-medium">Xóa bộ lọc</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-center">
        {{ $books->links() }}
    </div>
    @endif
</div>
@endsection