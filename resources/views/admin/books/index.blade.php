@extends('layouts.admin')
@section('title', 'Quản lý Sách')
@section('header', 'Danh sách đầu sách')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Kho sách</h2>
        <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Thêm mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Sách</th>
                    <th class="px-6 py-3">Tác giả</th>
                    <th class="px-6 py-3">Danh mục</th>
                    <th class="px-6 py-3 text-center">Trạng thái</th>
                    <th class="px-6 py-3 text-right">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($books as $book)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $book->cover_image ? Storage::url($book->cover_image) : 'https://placehold.co/50' }}" class="w-10 h-14 object-cover rounded border">
                            <span class="font-medium text-gray-800">{{ Str::limit($book->title, 30) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $book->author_name }}</td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs">
                            {{ $book->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($book->is_approved)
                        <span class="text-green-500 text-xs font-bold"><i class="fas fa-check-circle"></i> Đã duyệt</span>
                        @else
                        <span class="text-yellow-500 text-xs font-bold"><i class="fas fa-clock"></i> Chờ duyệt</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('books.edit', $book) }}" class="text-blue-500 hover:underline mr-3">Sửa</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Xóa sách này?');">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $books->links() }}
    </div>
</div>
@endsection