@extends('layouts.admin')
@section('title', 'Cập nhật Sách')
@section('header', 'Cập nhật: ' . $book->title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên sách</label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" class="w-full px-4 py-2 border rounded-lg outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tác giả</label>
                    <input type="text" name="author_name" value="{{ old('author_name', $book->author_name) }}" class="w-full px-4 py-2 border rounded-lg outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục</label>
                    <div class="h-48 overflow-y-auto border rounded-lg p-3 bg-gray-50 grid grid-cols-2 gap-2">
                        @foreach($categories as $cat)
                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-1 rounded">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                {{-- Logic check: Nếu ID nằm trong danh sách cũ HOẶC danh sách submit lỗi --}}
                                {{ in_array($cat->id, old('category_ids', $currentCategoryIds ?? [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa hiện tại</label>
                    @if($book->cover_image)
                    <img src="{{ Storage::url($book->cover_image) }}" class="h-32 rounded border object-cover">
                    @else
                    <span class="text-gray-400 italic text-sm border p-2 rounded block bg-gray-50">Chưa có ảnh</span>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thay ảnh mới</label>
                    <input type="file" name="cover_image" class="w-full text-sm text-gray-500">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $book->description) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.books.index') }}" class="px-6 py-2 border rounded-lg text-gray-600">Hủy</a>
            <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Cập nhật</button>
        </div>
    </form>
</div>
@endsection