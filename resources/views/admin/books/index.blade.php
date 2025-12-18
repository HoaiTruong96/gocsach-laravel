@extends('layouts.admin')
@section('title', 'Quản lý Sách')
@section('header', 'Danh sách đầu sách')

@section('content')
{{-- Thêm style đổ bóng mềm mại ngay tại đây --}}
<style>
    .shadow-soft {
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 0 3px rgba(0,0,0,0.02);
    }
    .shadow-soft:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 0 5px rgba(0,0,0,0.02);
    }
</style>

{{-- FIX: Thêm h-[calc(100vh-120px)] để trang luôn full chiều cao, tránh lỗi sidebar bên trái bị ngắn/hụt --}}
<div class="flex flex-col h-[calc(100vh-120px)] gap-4">
    
    {{-- Header Toolbar: Đã thay shadow-sm thành shadow-soft --}}
    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-soft border border-gray-100 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4 flex-none z-50 transition-colors duration-300">
        
        <h2 class="text-lg font-bold text-gray-700 dark:text-white whitespace-nowrap flex items-center gap-2">
            Kho sách <span class="px-2 py-0.5 bg-gray-100 dark:bg-slate-600 text-gray-600 dark:text-slate-200 rounded-full text-xs border border-gray-300 dark:border-slate-500">{{ $books->total() }}</span>
        </h2>

        <div class="flex items-center gap-2 w-full md:w-auto">
            
            <form action="{{ route('admin.books.index') }}" method="GET" class="flex items-center gap-2">

                <div class="relative group">
                    
                    <div class="h-10 w-48 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-200 text-sm rounded-lg flex items-center justify-between px-3 cursor-pointer hover:border-blue-500 hover:text-blue-600 transition shadow-sm select-none relative z-10">
                        <span class="truncate font-medium flex items-center gap-2">
                            <i class="fas fa-filter text-xs text-gray-400"></i>
                            @if(request('category_id') && request('category_id') != 'all')
                                {{ $categories->firstWhere('id', request('category_id'))->name ?? 'Tất cả' }}
                            @else
                                Tất cả thể loại
                            @endif
                        </span>
                        <i class="fas fa-caret-down text-gray-400 group-hover:text-blue-500 transition-transform group-hover:rotate-180"></i>
                    </div>

                    {{-- Dropdown Menu: Đã thêm shadow-soft --}}
                    <div class="absolute top-full left-0 pt-2 w-[400px] hidden group-hover:block z-50">
                        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-soft overflow-hidden">
                            <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 text-[11px] font-bold text-gray-500 dark:text-slate-300 uppercase tracking-wider border-b border-gray-100 dark:border-slate-600 flex justify-between items-center">
                                <span>Chọn thể loại</span>
                                <span class="text-blue-600 dark:text-blue-400 text-[10px] bg-blue-50 dark:bg-blue-900/50 px-2 py-0.5 rounded-full border border-blue-100 dark:border-blue-800">A-Z</span>
                            </div>

                            <div class="p-3 grid grid-cols-2 gap-2 max-h-[300px] overflow-y-auto custom-scrollbar bg-white dark:bg-slate-800">
                                <label class="cursor-pointer group/item">
                                    <input type="radio" name="category_id" value="all" onchange="this.form.submit()" class="hidden peer"
                                        {{ !request('category_id') || request('category_id') == 'all' ? 'checked' : '' }}>
                                    <div class="px-3 py-2 rounded-lg border border-transparent text-sm text-gray-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-200 hover:bg-gray-50 hover:text-gray-900 transition flex items-center gap-2">
                                        <div class="w-1 h-4 bg-gray-300 rounded-full group-hover/item:bg-blue-400 peer-checked:bg-blue-600 transition-colors"></div>
                                        Tất cả
                                    </div>
                                </label>

                                @foreach($categories as $cat)
                                <label class="cursor-pointer group/item">
                                    <input type="radio" name="category_id" value="{{ $cat->id }}" onchange="this.form.submit()" class="hidden peer"
                                        {{ request('category_id') == $cat->id ? 'checked' : '' }}>
                                    
                                    <div class="px-3 py-2 rounded-lg border border-transparent text-sm text-gray-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:font-bold peer-checked:border-blue-200 hover:bg-gray-50 hover:text-gray-900 transition truncate flex items-center gap-2">
                                        <div class="w-1 h-4 bg-gray-200 rounded-full group-hover/item:bg-blue-300 peer-checked:bg-blue-600 transition-colors"></div>
                                        {{ $cat->name }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-slate-700 border-t border-gray-100 dark:border-slate-600 p-2 text-center text-[10px] text-gray-400 dark:text-slate-400">
                                Nhấn vào để lọc ngay
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative w-40 md:w-60 group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-xs group-focus-within:text-blue-500 transition"></i>
                    </div>
                    
                    <input type="text" name="keyword" placeholder="Tên sách, tác giả..." value="{{ request('keyword') }}"
                        class="h-10 w-full pl-9 pr-10 border border-gray-300 dark:border-slate-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition shadow-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-white dark:placeholder-slate-400">
                    
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-r-lg transition cursor-pointer" title="Tìm kiếm">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                @if(request('keyword') || (request('category_id') && request('category_id') != 'all') || request('per_page') != '10' && request('per_page'))
                <a href="{{ route('admin.books.index') }}" class="h-10 w-10 bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 rounded-lg text-sm transition flex items-center justify-center shadow-sm" title="Xóa bộ lọc">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>

            <div class="h-8 w-px bg-gray-300 mx-1"></div>

            {{-- Nút thêm mới: Thêm shadow-soft --}}
            <a href="{{ route('admin.books.create') }}" class="h-10 bg-blue-600 text-white px-4 rounded-lg text-sm hover:bg-blue-700 flex items-center justify-center shadow-soft hover:shadow-lg transition transform hover:scale-105 whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Thêm mới
            </a>
        </div>
    </div>

    {{-- Table Container: Đã thay shadow-sm thành shadow-soft --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-soft border border-gray-100 dark:border-slate-700 flex-1 flex flex-col z-0 transition-colors duration-300">
        
        <div class="flex-1 overflow-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-300 text-xs uppercase sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-slate-700">Sách</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-slate-700">Tác giả</th>
                        <th class="px-6 py-3 w-64 bg-gray-50 dark:bg-slate-700">Danh mục</th>
                        {{-- FIX: Thêm class w-32 để cố định chiều rộng cột Trạng thái --}}
                        <th class="px-6 py-3 text-center bg-gray-50 dark:bg-slate-700 w-32">Trạng thái</th>
                        <th class="px-6 py-3 text-right bg-gray-50 dark:bg-slate-700">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($books as $book)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 group transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="relative w-10 h-14 flex-shrink-0">
                                    {{-- FIX: Logic xử lý hiển thị ảnh cover --}}
                                    @php
                                        $coverImage = $book->cover_image;
                                        // Kiểm tra nếu là URL online (bắt đầu bằng http) thì giữ nguyên
                                        // Nếu không thì mới dùng Storage::url
                                        if ($coverImage && !str_starts_with($coverImage, 'http')) {
                                            $coverImage = Storage::url($coverImage);
                                        }
                                        // Nếu không có ảnh thì dùng placeholder
                                        $coverSrc = $coverImage ?: 'https://placehold.co/50';
                                    @endphp
                                    <img src="{{ $coverSrc }}"
                                         class="w-full h-full object-cover rounded border border-gray-200 dark:border-slate-600 bg-gray-100 dark:bg-slate-600 shadow-sm"
                                         alt="{{ $book->title }}"
                                         onerror="this.onerror=null; this.src='https://placehold.co/50?text=No+Img';">
                                </div>
                                <div>
                                    <span class="font-bold text-gray-800 dark:text-white block text-sm leading-tight mb-1" title="{{ $book->title }}">
                                        {{ Str::limit($book->title, 35) }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 dark:text-slate-500 flex items-center gap-1">
                                        <i class="far fa-eye"></i> {{ number_format($book->view_count) }} lượt xem
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-600 dark:text-slate-300 text-sm font-medium">
                            {{ $book->author_name }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($book->categories as $cat)
                                <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 rounded-md text-[10px] font-bold border border-blue-100 dark:border-blue-800 whitespace-nowrap">
                                    {{ $cat->name }}
                                </span>
                                @empty
                                <span class="text-gray-400 dark:text-slate-500 text-xs italic">Chưa phân loại</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($book->is_approved)
                            {{-- FIX: Thêm justify-center, w-24 để đồng bộ kích thước --}}
                            <span class="inline-flex items-center justify-center gap-1 text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900/50 px-2 py-1 rounded-full text-[10px] font-bold border border-green-200 dark:border-green-800 w-24 whitespace-nowrap">
                                <i class="fas fa-check-circle"></i> Đã duyệt
                            </span>
                            @else
                            {{-- FIX: Thêm justify-center, w-24 để đồng bộ kích thước --}}
                            <span class="inline-flex items-center justify-center gap-1 text-yellow-700 dark:text-yellow-300 bg-yellow-100 dark:bg-yellow-900/50 px-2 py-1 rounded-full text-[10px] font-bold border border-yellow-200 dark:border-yellow-800 w-24 whitespace-nowrap">
                                <i class="fas fa-clock"></i> Chờ duyệt
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                {{-- Nút Duyệt (chỉ hiện khi chưa được duyệt) --}}
                                @if(!$book->is_approved)
                                <form action="{{ route('admin.books.approve', $book) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="h-8 px-3 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 hover:bg-green-500 hover:text-white transition text-xs font-bold gap-1" title="Duyệt sách này">
                                        <i class="fas fa-check"></i> Duyệt
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('admin.books.edit', $book) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-300 hover:bg-blue-100 dark:hover:bg-blue-900/50 hover:text-blue-600 dark:hover:text-blue-400 transition" title="Chỉnh sửa">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cuốn sách này không?');">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-300 hover:bg-red-100 dark:hover:bg-red-900/50 hover:text-red-500 dark:hover:text-red-400 transition" title="Xóa">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500 dark:text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-search text-4xl text-gray-300 dark:text-slate-600 mb-3"></i>
                                <p>Không tìm thấy cuốn sách nào phù hợp.</p>
                                @if(request('keyword') || request('category_id'))
                                <a href="{{ route('admin.books.index') }}" class="text-blue-600 dark:text-blue-400 text-sm hover:underline mt-1 font-medium">Xóa bộ lọc</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-center flex-none">
            {{ $books->links('vendor.pagination.admin') }}
        </div>
        @endif
    </div>

</div>
@endsection