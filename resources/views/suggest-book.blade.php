@extends('layouts.app')

@section('title', 'Đề Xuất Sách Mới')

@section('content')
    {{-- BREADCRUMB --}}
    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('profile', Auth::id()) }}" class="hover:text-brand-green transition">Hồ Sơ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Đề Xuất Sách</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow min-h-screen">
        
        {{-- THÔNG BÁO LỖI --}}
        <div class="max-w-2xl mx-auto">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                    <div class="flex items-center gap-2 mb-2 font-bold text-red-800">
                        <i class="fas fa-exclamation-triangle"></i> Không thể gửi đề xuất:
                    </div>
                    <ul class="list-disc list-inside text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
                {{-- HEADER --}}
                <div class="p-6 sm:p-8 border-b border-gray-100 bg-gradient-to-r from-brand-green/5 to-brand-accent/5">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-brand-accent/10 rounded-xl flex items-center justify-center text-brand-accent">
                            <i class="fas fa-book-medical text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 font-serif">Đề Xuất Sách Mới</h1>
                            <p class="text-gray-500 text-sm mt-1">Giới thiệu một cuốn sách hay cho cộng đồng Góc Sách</p>
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                <form action="{{ route('books.suggest.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    {{-- TÊN SÁCH --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Tên sách
                        </label>
                        <input type="text" name="title" id="title" required
                            value="{{ old('title') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-green/20 focus:border-brand-green transition font-medium text-gray-800 placeholder-gray-400" 
                            placeholder="Ví dụ: Rừng Na Uy">
                    </div>

                    {{-- TÁC GIẢ --}}
                    <div>
                        <label for="author_name" class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Tên tác giả
                        </label>
                        <input type="text" name="author_name" id="author_name" required
                            value="{{ old('author_name') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-green/20 focus:border-brand-green transition font-medium text-gray-800 placeholder-gray-400" 
                            placeholder="Ví dụ: Haruki Murakami">
                    </div>

                    {{-- ẢNH BÌA --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Ảnh bìa sách <span class="text-gray-400 font-normal">(Tùy chọn)</span>
                        </label>
                        <div class="flex items-start gap-4">
                            {{-- Preview Area --}}
                            <div class="relative w-24 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden group" id="cover-preview-container">
                                <img id="cover-preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                <div id="cover-placeholder" class="text-center">
                                    <i class="fas fa-image text-2xl text-gray-400"></i>
                                    <p class="text-[10px] text-gray-400 mt-1">150×225</p>
                                </div>
                            </div>
                            
                            {{-- Upload Button --}}
                            <div class="flex-1">
                                <label for="cover-upload" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2. 5 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition text-sm font-medium text-gray-600">
                                    <i class="fas fa-cloud-upload-alt"></i> Chọn ảnh bìa
                                </label>
                                <input id="cover-upload" name="cover_image" type="file" class="hidden" accept="image/*" onchange="previewCover(event)">
                                <p class="text-xs text-gray-400 mt-2">PNG, JPG, WEBP (Tối đa 2MB)</p>
                                
                                {{-- Nút xóa ảnh --}}
                                <button type="button" id="remove-cover" onclick="removeCover()" class="hidden text-xs text-red-500 hover:underline mt-2">
                                    <i class="fas fa-times mr-1"></i> Xóa ảnh
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- MÔ TẢ --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                            Mô tả ngắn <span class="text-gray-400 font-normal">(Tùy chọn)</span>
                        </label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-green/20 focus:border-brand-green transition text-gray-800 placeholder-gray-400 resize-none" 
                            placeholder="Viết vài dòng giới thiệu về cuốn sách này...">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Tối đa 2000 ký tự</p>
                    </div>

                    {{-- THÔNG TIN BỔ SUNG --}}
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="text-blue-500 mt-0.5">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="text-sm text-blue-700">
                                <p class="font-bold mb-1">Lưu ý:</p>
                                <ul class="list-disc list-inside space-y-1 text-blue-600">
                                    <li>Đề xuất của bạn sẽ được Admin xem xét và phê duyệt</li>
                                    <li>Sau khi được duyệt, sách sẽ xuất hiện trên hệ thống</li>
                                    <li>Bạn có thể theo dõi trạng thái đề xuất trong trang Hồ Sơ</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- NÚT BẤM --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('profile', Auth::id()) }}" class="px-5 py-2.5 rounded-lg font-bold text-gray-500 hover:bg-gray-100 transition">
                            <i class="fas fa-arrow-left mr-1"></i> Quay lại
                        </a>
                        <button type="submit" class="px-8 py-2.5 rounded-lg font-bold bg-brand-accent text-white shadow-md hover:bg-[#c29263] hover:-translate-y-0.5 transform transition flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i> Gửi Đề Xuất
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    {{-- JavaScript Preview Ảnh --}}
    <script>
        function previewCover(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cover-preview').src = e.target.result;
                    document.getElementById('cover-preview').classList.remove('hidden');
                    document.getElementById('cover-placeholder').classList.add('hidden');
                    document.getElementById('remove-cover').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function removeCover() {
            document.getElementById('cover-upload').value = '';
            document.getElementById('cover-preview').src = '';
            document.getElementById('cover-preview').classList.add('hidden');
            document.getElementById('cover-placeholder').classList.remove('hidden');
            document.getElementById('remove-cover').classList.add('hidden');
        }
    </script>
@endsection
