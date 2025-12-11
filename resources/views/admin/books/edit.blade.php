@extends('layouts.admin')
@section('title', 'Cập nhật Sách')
@section('header', 'Cập nhật: ' . $book->title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- CỘT TRÁI --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên sách <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tác giả <span class="text-red-500">*</span></label>
                    <input type="text" name="author_name" value="{{ old('author_name', $book->author_name) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('author_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục (Chọn nhiều)</label>
                    <div class="h-48 overflow-y-auto border rounded-lg p-3 bg-gray-50 grid grid-cols-2 gap-2">
                        @foreach($categories as $cat)
                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-1 rounded">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                {{-- Kiểm tra ID danh mục có trong mảng danh mục của sách không --}}
                                {{ in_array($cat->id, old('category_ids', $book->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhà xuất bản</label>
                    <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="VD: NXB Trẻ">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Năm xuất bản</label>
                    <input type="number" name="published_year" value="{{ old('published_year', $book->published_year) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="2024">
                </div>
                
                {{-- Phần Upload Ảnh có Preview (Giống trang Create) --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh bìa</label>
                    
                    {{-- Xử lý logic hiển thị ảnh cũ --}}
                    @php
                        $coverImage = $book->cover_image;
                        $isUrl = false;
                        
                        if ($coverImage) {
                            if (str_starts_with($coverImage, 'http')) {
                                $coverSrc = $coverImage;
                                $isUrl = true;
                            } else {
                                $coverSrc = Storage::url($coverImage);
                            }
                        } else {
                            $coverSrc = '';
                        }
                    @endphp

                    <div class="flex gap-4 items-start">
                        <!-- Khu vực Preview Ảnh -->
                        <div class="w-24 h-36 flex-shrink-0 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white flex items-center justify-center relative">
                            <!-- Ảnh preview: Nếu có ảnh cũ thì hiện, không thì ẩn -->
                            <img id="preview-image" src="{{ $coverSrc }}" class="w-full h-full object-cover {{ $coverSrc ? '' : 'hidden' }}" onerror="this.src='https://placehold.co/100x150?text=Err'">
                            
                            <!-- Placeholder: Ngược lại với ảnh -->
                            <div id="preview-placeholder" class="text-center text-gray-400 p-2 {{ $coverSrc ? 'hidden' : '' }}">
                                <i class="fas fa-image text-2xl mb-1"></i>
                                <span class="text-[10px] block">Chưa có ảnh</span>
                            </div>
                        </div>

                        <div class="flex-1">
                            <!-- Cách 1: Upload File -->
                            <div class="mb-2">
                                <label class="text-xs text-gray-500 mb-1 block">Tải ảnh từ máy:</label>
                                <input type="file" name="cover_image" id="file-input" onchange="previewFile()"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-lg">
                            </div>

                            <!-- Phân cách -->
                            <div class="text-center text-xs text-gray-400 my-2 font-bold uppercase">--- Hoặc ---</div>

                            <!-- Cách 2: Nhập URL -->
                            <div>
                                <label class="text-xs text-gray-500 mb-1 block">Hoặc dán link ảnh:</label>
                                {{-- Nếu ảnh cũ là URL thì điền sẵn vào input này --}}
                                <input type="url" name="cover_image_url" id="url-input" oninput="previewUrl()" 
                                    value="{{ old('cover_image_url', $isUrl ? $book->cover_image : '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none" 
                                    placeholder="https://example.com/image.jpg">
                            </div>
                        </div>
                    </div>
                    @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả nội dung</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ old('description', $book->description) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.books.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Hủy</a>
            <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium">Cập nhật sách</button>
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
        } else {
            // Nếu xóa trắng URL và không có file nào được chọn -> quay về trạng thái mặc định hoặc ảnh cũ (tuỳ chọn)
            // Ở đây ta tạm thời để trống nếu user xóa hết
            if (!fileInput.files.length) {
                // Nếu muốn quay lại ảnh cũ từ server thì cần lưu biến PHP vào JS, nhưng đơn giản nhất là để placeholder
                // previewImage.classList.add('hidden');
                // previewPlaceholder.classList.remove('hidden');
            }
        }
    }
</script>
@endsection