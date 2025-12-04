@extends('layouts.app')

@section('title', 'Tìm Sách - Góc Sách')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Tìm Kiếm</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow min-h-screen">
        
        <!-- Header Tìm Kiếm -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-brand-green font-serif mb-3">Tìm Sách Để Review</h1>
            <p class="text-gray-500 text-lg">Chọn một cuốn sách bạn muốn chia sẻ cảm nhận với cộng đồng</p>
        </div>

        <!-- Form Tìm Kiếm -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="bg-white p-2 rounded-full shadow-card border border-gray-200 transition-all focus-within:border-brand-green focus-within:ring-4 focus-within:ring-brand-green/10">
                <form action="{{ route('books.search') }}" method="GET" class="flex items-center">
                    <div class="pl-4 pr-2 text-gray-400">
                        <i class="fas fa-search text-lg"></i>
                    </div>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" 
                           class="flex-grow p-3 bg-transparent outline-none text-gray-700 placeholder-gray-400 w-full"
                           placeholder="Nhập tên sách, tác giả hoặc thể loại..." autofocus>
                    <button type="submit" class="bg-brand-green hover:bg-brand-green-light text-white px-8 py-3 rounded-full font-bold transition transform hover:scale-105 shadow-md">
                        Tìm Kiếm
                    </button>
                </form>
            </div>
            
            <!-- Gợi ý từ khóa (Optional) -->
            <div class="mt-4 text-center text-sm text-gray-500">
                <span class="mr-2">Gợi ý:</span>
                <a href="{{ route('books.search', ['keyword' => 'Tiểu thuyết']) }}" class="hover:text-brand-green hover:underline mr-2">Tiểu thuyết</a>
                <a href="{{ route('books.search', ['keyword' => 'Kinh tế']) }}" class="hover:text-brand-green hover:underline mr-2">Kinh tế</a>
                <a href="{{ route('books.search', ['keyword' => 'Tâm lý']) }}" class="hover:text-brand-green hover:underline">Tâm lý</a>
            </div>
        </div>

        <!-- Kết Quả Tìm Kiếm -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @forelse($books as $book)
                <div class="group bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                    
                    <!-- Ảnh Bìa -->
                    <div class="relative w-full aspect-[2/3] bg-gray-100 overflow-hidden">
                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                             onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                        
                        <!-- Overlay nút Review -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[1px]">
                            <a href="{{ url('/book/' . $book->id) }}" class="bg-yellow-400 text-brand-green px-5 py-2.5 rounded-full font-bold shadow-xl hover:scale-105 transform transition flex items-center gap-2">
                                <i class="fas fa-pen"></i> Viết Review
                            </a>
                        </div>
                    </div>

                    <!-- Thông Tin -->
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-serif font-bold text-gray-800 text-base leading-snug mb-1 line-clamp-2 group-hover:text-brand-green transition h-10" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h3>
                        
                        <p class="text-xs text-gray-500 mb-3 font-medium truncate">
                            {{ is_string($book->author) ? $book->author : ($book->author->name ?? 'Tác giả ẩn danh') }}
                        </p>

                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <a href="{{ url('/book/' . $book->id) }}" class="block w-full text-center bg-brand-green/5 border border-brand-green/20 text-brand-green py-2 rounded-lg text-xs font-bold hover:bg-brand-green hover:text-white transition">
                                Chọn Sách Này
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300 animate-pulse">
                        <i class="fas fa-search text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Không tìm thấy kết quả nào</h3>
                    <p class="text-gray-500 mb-6">Hãy thử tìm với từ khóa khác hoặc kiểm tra lại chính tả nhé.</p>
                    <a href="{{ route('home') }}" class="text-brand-green font-bold hover:underline">Quay về trang chủ</a>
                </div>
            @endforelse
        </div>

        <!-- Phân trang (Nếu có) -->
        @if(method_exists($books, 'links'))
            <div class="mt-12 flex justify-center">
                {{ $books->withQueryString()->links() }} 
                {{-- Lưu ý: Nếu chưa publish vendor pagination view, dòng này có thể ra style mặc định. 
                     Bạn có thể dùng lại block HTML phân trang custom ở file index.blade.php nếu muốn đồng bộ --}}
            </div>
        @endif

    </main>
@endsection