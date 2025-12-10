@extends('layouts.admin')
@section('title', 'Thêm Sách Mới')
@section('header', 'Thêm sách mới')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên sách <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nhập tên sách...">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tác giả <span class="text-red-500">*</span></label>
                    <input type="text" name="author_name" value="{{ old('author_name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nhập tên tác giả...">
                    @error('author_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục (Chọn nhiều) <span class="text-red-500">*</span></label>
                    <div class="h-48 overflow-y-auto border rounded-lg p-3 bg-gray-50 grid grid-cols-2 gap-2">
                        @foreach($categories as $cat)
                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-1 rounded">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('category_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhà xuất bản</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="VD: NXB Trẻ">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Năm xuất bản</label>
                    <input type="number" name="published_year" value="{{ old('published_year') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="2024">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa</label>
                    <input type="file" name="cover_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả nội dung</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.books.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Hủy</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Thêm sách</button>
        </div>
    </form>
</div>
@endsection