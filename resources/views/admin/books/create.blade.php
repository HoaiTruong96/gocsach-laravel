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
                
                {{-- [CHỈNH SỬA] Phần Upload Ảnh có Preview --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh bìa</label>
                    
                    <div class="flex gap-4 items-start">
                        <!-- Khu vực Preview Ảnh -->
                        <div class="w-24 h-36 flex-shrink-0 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white flex items-center justify-center relative">
                            <img id="preview-image" src="https://placehold.co/100x150?text=Preview" class="w-full h-full object-cover hidden">
                            <div id="preview-placeholder" class="text-center text-gray-400 p-2">
                                <i class="fas fa-image text-2xl mb-1"></i>
                                <span class="text-[10px] block">Chưa có ảnh</span>
                            </div>
                        </div>

                        <div class="flex-1">
                            <!-- Cách 1: Upload File -->
                            <div class="mb-2">
                                <input type="file" name="cover_image" id="file-input" onchange="previewFile()"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-lg">
                            </div>

                            <!-- Phân cách -->
                            <div class="text-center text-xs text-gray-400 my-2 font-bold uppercase">--- Hoặc ---</div>

                            <!-- Cách 2: Nhập URL -->
                            <div>
                                <input type="url" name="cover_image_url" id="url-input" oninput="previewUrl()" value="{{ old('cover_image_url') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none" 
                                    placeholder="Dán đường dẫn ảnh (URL)...">
                            </div>
                        </div>
                    </div>

                    @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('cover_image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

<!-- Script xử lý xem trước ảnh -->
<script>
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const fileInput = document.getElementById('file-input');
    const urlInput = document.getElementById('url-input');

    // Hàm hiển thị ảnh
    function showImage(src) {
        previewImage.src = src;
        previewImage.classList.remove('hidden');
        previewPlaceholder.classList.add('hidden');
    }

    // Xử lý khi chọn file từ máy
    function previewFile() {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showImage(e.target.result);
                urlInput.value = ''; // Xóa URL nếu chọn file để tránh nhầm lẫn
            }
            reader.readAsDataURL(file);
        }
    }

    // Xử lý khi nhập URL
    function previewUrl() {
        const url = urlInput.value;
        if (url) {
            showImage(url);
            fileInput.value = ''; // Xóa file nếu nhập URL
        }
    }
</script>
@endsection