@extends('layouts.admin')
@section('title', 'Thêm Banner')
@section('header', 'Tạo Banner Mới')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl mx-auto">
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Cột Trái --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tiêu đề chính <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required placeholder="VD: Nhà Giả Kim">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tag nhỏ (Góc trên)</label>
                    <input type="text" name="tag" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="VD: Sách Bán Chạy">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Mô tả / Trích dẫn</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Một câu quote hay..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Đánh giá</label>
                        <input type="text" name="rating" class="w-full px-4 py-2 border rounded-lg outline-none" placeholder="VD: 4.8/5.0">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Thứ tự hiển thị</label>
                        <input type="number" name="order" value="0" class="w-full px-4 py-2 border rounded-lg outline-none">
                    </div>
                </div>
            </div>

            {{-- Cột Phải --}}
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hình ảnh (Banner) <span class="text-red-500">*</span></label>
                    <input type="file" name="image" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Nên dùng ảnh ngang, kích thước khoảng 800x600px.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Đường dẫn khi bấm vào</label>
                    <input type="text" name="link" class="w-full px-4 py-2 border rounded-lg outline-none" placeholder="VD: https://gocsach.vn/chi-tiet/nha-gia-kim">
                </div>
                <div class="pt-4">
                    <label class="flex items-center gap-3 p-4 border rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" name="is_active" checked class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                        <span class="font-medium text-gray-700">Hiển thị ngay trên trang chủ</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('admin.banners.index') }}" class="px-6 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-bold transition">Hủy</a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg transition transform hover:-translate-y-0.5">
                <i class="fas fa-save mr-2"></i> Lưu Banner
            </button>
        </div>
    </form>
</div>
@endsection