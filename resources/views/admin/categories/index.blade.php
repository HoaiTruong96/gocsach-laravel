@extends('layouts.admin')
@section('title', 'Danh Mục Sách')
@section('header', 'Quản lý Thể loại sách')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <h3 class="font-bold text-gray-800 mb-4 text-lg">Thêm danh mục</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="VD: Trinh thám">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Mô tả ngắn..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-plus mr-1"></i> Tạo mới
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <span class="font-semibold text-gray-700">Tất cả danh mục ({{ $categories->total() }})</span>
            </div>
            <table class="w-full text-left">
                <thead class="text-xs text-gray-500 uppercase bg-white border-b">
                    <tr>
                        <th class="px-6 py-3">Tên</th>
                        <th class="px-6 py-3">Slug</th>
                        <th class="px-6 py-3 text-center">Số sách</th>
                        <th class="px-6 py-3 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $cat)
                    <tr class="hover:bg-gray-50 group">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $cat->name }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $cat->slug }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold">
                                {{ $cat->books_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này?');">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection