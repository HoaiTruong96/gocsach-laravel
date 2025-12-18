@extends('layouts.admin')

@section('title', 'Tạo Bài Viết Mới')
@section('header', 'Thêm Bài Tạp Chí Mới')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 max-w-4xl mx-auto transition-colors duration-300">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Cột Trái --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white" 
                           placeholder="VD: 10 cuốn sách nên đọc trong mùa hè"
                           required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Nhãn (Tag)</label>
                    <input type="text" name="tag" value="{{ old('tag') }}" 
                           class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white" 
                           placeholder="VD: Mẹo Đọc, Cảm Hứng, Review">
                    @error('tag') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Mô tả ngắn (Sapo)</label>
                    <textarea name="excerpt" rows="4" 
                              class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white resize-none"
                              placeholder="Mô tả ngắn gọn về bài viết (hiển thị trong danh sách)">{{ old('excerpt') }}</textarea>
                    @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Cột Phải --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Ảnh bìa</label>
                    
                    {{-- Tabs chọn hình thức upload --}}
                    <div class="mb-3">
                        <div class="flex gap-2 mb-2">
                            <button type="button" onclick="showUploadTab('file')" id="tab-file" 
                                    class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 font-bold">
                                <i class="fas fa-upload mr-1"></i> Upload File
                            </button>
                            <button type="button" onclick="showUploadTab('url')" id="tab-url"
                                    class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-bold">
                                <i class="fas fa-link mr-1"></i> Nhập URL
                            </button>
                        </div>
                        
                        <div id="upload-file">
                            <input type="file" name="thumbnail" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        
                        <div id="upload-url" class="hidden">
                            <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url') }}"
                                   class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white text-sm"
                                   placeholder="https://example.com/image.jpg">
                        </div>
                    </div>
                    
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('thumbnail_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                    <input type="checkbox" name="is_featured" id="is_featured" {{ old('is_featured') ? 'checked' : '' }} 
                           class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                    <label for="is_featured" class="font-medium text-gray-700 dark:text-slate-300 select-none cursor-pointer">
                        <i class="fas fa-star text-yellow-500 mr-1"></i> Đây là bài Tiêu Điểm (Hiện to nhất)
                    </label>
                </div>
                
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Bài viết sẽ xuất hiện trên trang chủ trong mục "Tạp Chí Đọc"
                    </p>
                </div>
            </div>
        </div>

        {{-- Nội dung chi tiết (Full width) --}}
        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Nội dung chi tiết <span class="text-red-500">*</span></label>
            <textarea name="content" id="editor" rows="10" 
                      class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white">{{ old('content') }}</textarea>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.articles.index') }}" class="px-6 py-2.5 rounded-lg text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 font-bold transition">
                <i class="fas fa-times mr-1"></i> Hủy
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg transition transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle mr-2"></i> Tạo Bài Viết
            </button>
        </div>
    </form>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
    
    // Tab switching for upload type
    function showUploadTab(type) {
        document.getElementById('upload-file').classList.add('hidden');
        document.getElementById('upload-url').classList.add('hidden');
        document.getElementById('tab-file').classList.remove('bg-blue-100', 'text-blue-600');
        document.getElementById('tab-file').classList.add('bg-gray-100', 'text-gray-600');
        document.getElementById('tab-url').classList.remove('bg-blue-100', 'text-blue-600');
        document.getElementById('tab-url').classList.add('bg-gray-100', 'text-gray-600');
        
        if (type === 'file') {
            document.getElementById('upload-file').classList.remove('hidden');
            document.getElementById('tab-file').classList.remove('bg-gray-100', 'text-gray-600');
            document.getElementById('tab-file').classList.add('bg-blue-100', 'text-blue-600');
        } else {
            document.getElementById('upload-url').classList.remove('hidden');
            document.getElementById('tab-url').classList.remove('bg-gray-100', 'text-gray-600');
            document.getElementById('tab-url').classList.add('bg-blue-100', 'text-blue-600');
        }
    }
</script>
@endsection
