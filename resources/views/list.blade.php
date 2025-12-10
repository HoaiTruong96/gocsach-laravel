@extends('layouts.app')

@section('title', 'Tất Cả Sách - Góc Sách')

@section('content')
    {{-- Breadcrumb --}}
    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Danh Sách Sách</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- SIDEBAR: BỘ LỌC --}}
            <aside class="lg:col-span-3 space-y-8">
                {{-- Widget Thể Loại --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">
                        <i class="fas fa-filter mr-2 text-brand-accent"></i> Thể Loại
                    </h3>
                    <div class="space-y-3">
                        @foreach(['Văn Học', 'Kinh Tế', 'Tâm Lý & Kỹ Năng', 'Trinh Thám', 'Thiếu Nhi'] as $cat)
                        <label class="flex items-center space-x-3 cursor-pointer group hover:bg-gray-50 p-2 rounded-lg transition -mx-2">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-brand-green focus:ring-brand-green form-checkbox">
                            <span class="text-gray-600 group-hover:text-brand-green transition text-sm font-medium flex-1">{{ $cat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Widget Đánh Giá --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">
                        <i class="fas fa-star mr-2 text-brand-accent"></i> Đánh Giá
                    </h3>
                    <div class="space-y-2">
                        @for($i = 5; $i >= 3; $i--)
                        <label class="flex items-center space-x-3 cursor-pointer group hover:bg-gray-50 p-2 rounded-lg transition -mx-2">
                            <input type="radio" name="rating" class="text-brand-green focus:ring-brand-green w-4 h-4">
                            <div class="flex items-center text-xs flex-1">
                                <div class="text-yellow-400 flex gap-1 mr-2">
                                    @for($j = 1; $j <= 5; $j++)
                                        @if($j <= $i) <i class="fas fa-star"></i>
@else <i class="far fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-500 font-medium group-hover:text-brand-green">Trở lên</span>
                            </div>
                        </label>
                        @endfor
                    </div>
                </div>
            </aside>

            {{-- MAIN CONTENT: DANH SÁCH SÁCH --}}
            <div class="lg:col-span-9">
                
                {{-- Toolbar: Sắp xếp & Số lượng --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-soft border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-2 sm:mb-0">
                        @if(isset($books) && $books->count() > 0)
                            Hiển thị <span class="font-bold text-brand-green">{{ $books->count() }}</span> kết quả
                        @else
                            Chưa có sách nào
                        @endif
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 font-medium">Sắp xếp:</span>
                        <div class="relative group">
                            <select class="appearance-none bg-gray-50 border border-gray-200 text-sm rounded-lg pl-4 pr-10 py-2 text-gray-700 focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green cursor-pointer hover:bg-white transition shadow-sm w-40">
                                <option>Mới nhất</option>
                                <option>Xem nhiều nhất</option>
                                <option>Đánh giá cao</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400 group-hover:text-brand-green transition">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grid Sách --}}
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @if(isset($books) && $books->count() > 0)
                        @foreach($books as $book)
                            <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                                {{-- Ảnh bìa --}}
                                <div class="relative w-full aspect-[2/3] bg-gray-100 overflow-hidden">
                                    {{-- Sử dụng slug thay vì id cho route --}}
                                    <a href="{{ route('detail', $book->slug ?? $book->id) }}">
                                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                                             alt="{{ $book->title }}"
                                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                                             onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                                    </a>
                                    
                                    {{-- Badge HOT --}}
                                    @if($book->view_count > 1000)
                                        <div class="absolute top-3 left-3 bg-red-500/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md animate-pulse">
                                            HOT
                                        </div>
                                    @endif

                                    {{-- Nút Quick View --}}
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                        <span class="bg-white text-brand-green px-4 py-2 rounded-full font-bold text-xs shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">Xem Chi Tiết</span>
                                    </div>
                                </div>
                                
                                {{-- Nội dung --}}
                                <div class="p-4 flex flex-col flex-1">
                                    <div class="text-[10px] text-brand-accent uppercase font-bold tracking-wider mb-1.5 truncate">
                                        {{-- Logic lấy Category an toàn --}}
                                        @if(isset($book->categories) && $book->categories->isNotEmpty())
                                            {{ $book->categories->first()->name }}
                                        @else
                                            Sách
                                        @endif
                                    </div>
                                    
                                    <h3 class="font-serif font-bold text-gray-800 text-base leading-snug mb-1 line-clamp-2 group-hover:text-brand-green transition h-10" title="{{ $book->title }}">
                                        <a href="{{ route('detail', $book->slug ?? $book->id) }}">
                                            {{ $book->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 mb-3 font-medium truncate">
                                        {{-- Sử dụng author_name thay vì logic phức tạp cũ --}}
                                        {{ $book->author_name ?? 'Tác giả ẩn danh' }}
                                    </p>
                                    
                                    <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                        <div class="flex items-center text-yellow-400 gap-1 bg-yellow-50 px-2 py-0.5 rounded-md">
                                            <i class="fas fa-star"></i> 
                                            <span class="text-gray-600 font-bold">{{ $book->avg_rating ?? '0' }}</span>
                                        </div>
                                        <div class="text-gray-400 flex items-center gap-1" title="Lượt xem">
                                            <i class="far fa-eye"></i> {{ number_format($book->view_count ?? 0) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Empty State --}}
                        <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-book-open text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Chưa có cuốn sách nào trong hệ thống.</p>
                            <a href="{{ route('home') }}" class="inline-block mt-4 text-brand-green font-bold text-sm hover:underline">Quay về trang chủ</a>
                        </div>
                    @endif
                </div>

                {{-- Phân trang (Chỉ hiện nếu biến books là đối tượng phân trang) --}}
                <div class="mt-12 flex justify-center">
                    @if(isset($books) && method_exists($books, 'links'))
                        {{ $books->links() }}
                    @endif
                </div>

            </div>
        </div>
    </main>
@endsection