@extends('layouts.app')

@section('title', 'Trang Cá Nhân - ' . $user->name)

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Hồ Sơ Của Tôi</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- CỘT TRÁI: THÔNG TIN USER -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-soft p-6 text-center border border-gray-100 sticky top-24">
                    
                    <!-- Avatar -->
                    <div class="relative w-32 h-32 mx-auto mb-4 group">
                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3E5F4E&color=fff&size=128' }}" 
                             class="rounded-full border-4 border-brand-beige shadow-md object-cover w-full h-full group-hover:border-brand-green transition duration-300">
                        @if(Auth::id() == $user->id)
                            <button class="absolute bottom-0 right-0 bg-white border border-gray-200 p-1.5 rounded-full text-gray-500 hover:text-brand-green hover:border-brand-green shadow-sm transition" title="Đổi ảnh đại diện">
                                <i class="fas fa-camera text-xs"></i>
                            </button>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-gray-800 font-serif">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm mb-3">{{ $user->email }}</p>
                    
                    <p class="text-gray-600 text-sm italic mb-4 px-2 bg-gray-50 py-2 rounded-lg border border-gray-100 relative">
                        <i class="fas fa-quote-left text-gray-300 absolute top-1 left-1 text-xs"></i>
                        {{ $user->bio ?? 'Thành viên tích cực của Góc Sách.' }}
                    </p>

                    <!-- Badges -->
                    <div class="flex justify-center gap-2 mb-6 flex-wrap">
                        @if($user->role == 'admin')
                            <span class="px-3 py-1 bg-red-50 text-red-600 text-xs rounded-full font-bold border border-red-100 flex items-center gap-1">
                                <i class="fas fa-shield-alt"></i> Quản trị viên
                            </span>
                        @else
                            <span class="px-3 py-1 bg-brand-green/10 text-brand-green text-xs rounded-full font-bold border border-brand-green/20">
                                Thành viên
                            </span>
                        @endif

                        <span class="px-3 py-1 bg-green-50 text-green-600 text-xs rounded-full font-medium border border-green-100 flex items-center">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span> Hoạt động
                        </span>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 mb-6 border-t border-b border-gray-100 py-4">
                        <div class="text-center">
                            <span class="block font-bold text-xl text-brand-green">{{ $totalBooks ?? 0 }}</span>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tủ sách</span>
                        </div>
                        <div class="text-center border-l border-gray-100">
                            <span class="block font-bold text-xl text-brand-accent">{{ $totalReviews ?? 0 }}</span>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Bài viết</span>
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-400 space-y-1.5 mb-6 text-left pl-2">
                        <p><i class="far fa-calendar-alt mr-2 w-4 text-center"></i> Tham gia: <span class="text-gray-600">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</span></p>
                        <p><i class="fas fa-sync-alt mr-2 w-4 text-center"></i> Cập nhật: <span class="text-gray-600">{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : 'N/A' }}</span></p>
                    </div>

                    @if(Auth::id() == $user->id)
                        <div class="space-y-2">
                            <a href="#" class="block w-full border border-brand-green text-brand-green py-2 rounded-lg font-bold text-sm hover:bg-brand-green hover:text-white transition">
                                <i class="fas fa-edit mr-1"></i> Chỉnh sửa hồ sơ
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block w-full border border-red-200 text-red-500 py-2 rounded-lg font-bold text-sm hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CỘT PHẢI: TỦ SÁCH -->
            <div class="lg:col-span-3">
                <!-- Filter Bar -->
                <div class="bg-white rounded-xl shadow-soft p-4 mb-8 border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-brand-green font-serif border-l-4 border-brand-accent pl-3">
                        Tủ Sách Của Tôi
                    </h3>
                    
                    <div class="flex bg-gray-100 p-1 rounded-lg">
                        <a href="{{ route('profile') }}" 
                           class="px-4 py-1.5 rounded-md text-sm font-medium transition {{ $currentFilter == 'all' ? 'bg-white text-brand-green shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                           Tất cả
                        </a>
                        <a href="{{ route('profile', ['status' => 'reading']) }}" 
                           class="px-4 py-1.5 rounded-md text-sm font-medium transition {{ $currentFilter == 'reading' ? 'bg-white text-brand-green shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                           Đang đọc
                        </a>
                        <a href="{{ route('profile', ['status' => 'favorites']) }}" 
                           class="px-4 py-1.5 rounded-md text-sm font-medium transition {{ $currentFilter == 'favorites' ? 'bg-white text-brand-green shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                           Yêu thích
                        </a>
                        <a href="{{ route('profile', ['status' => 'completed']) }}" 
                           class="px-4 py-1.5 rounded-md text-sm font-medium transition {{ $currentFilter == 'completed' ? 'bg-white text-brand-green shadow-sm font-bold' : 'text-gray-500 hover:text-gray-700' }}">
                           Đã đọc
                        </a>
                    </div>
                </div>

                <!-- Grid Sách -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- [FIX] Thêm kiểm tra isset để tránh lỗi nếu biến chưa được truyền --}}
                    @if(isset($myBooks) && count($myBooks) > 0)
                        @foreach($myBooks as $book)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-row h-40 relative group">
                            
                            <!-- Trạng thái (Badge) -->
                            <div class="absolute top-2 right-2 z-10">
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-500';
                                    $statusText = 'Sách';
                                    if(isset($book->pivot->status)) {
                                        switch($book->pivot->status) {
                                            case 'reading': $statusClass = 'bg-blue-50 text-blue-600 border border-blue-100'; $statusText = 'ĐANG ĐỌC'; break;
                                            case 'wishlist': $statusClass = 'bg-pink-50 text-pink-600 border border-pink-100'; $statusText = 'YÊU THÍCH'; break;
                                            case 'completed': $statusClass = 'bg-green-50 text-green-600 border border-green-100'; $statusText = 'ĐÃ ĐỌC'; break;
                                        }
                                    }
                                @endphp
                                <span class="{{ $statusClass }} text-[10px] font-bold px-2 py-1 rounded shadow-sm">{{ $statusText }}</span>
                            </div>

                            <!-- Ảnh nhỏ -->
                            <div class="w-28 relative flex-shrink-0 bg-gray-200">
                                <a href="{{ route('detail', $book->id) }}">
                                    <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/150x225?text=No+Image' }}" 
                                         class="w-full h-full object-cover transition group-hover:opacity-90"
                                         onerror="this.src='https://via.placeholder.com/150x225?text=Error'">
                                </a>
                            </div>

                            <!-- Thông tin -->
                            <div class="p-4 flex flex-col justify-between flex-grow min-w-0">
                                <div>
                                    <h4 class="font-bold font-serif text-gray-800 text-sm mb-1 leading-tight line-clamp-2" title="{{ $book->title }}">
                                        <a href="{{ route('detail', $book->id) }}" class="hover:text-brand-green transition">{{ $book->title }}</a>
                                    </h4>
                                    <p class="text-xs text-gray-500 truncate">
                                        @if(is_object($book->author)) {{ $book->author->name ?? 'N/A' }}
                                        @else {{ $book->author }} @endif
                                    </p>
                                    
                                    {{-- [FIX] Cách 2: Ẩn phần ngày bắt đầu vì DB chưa có cột này --}}
                                    {{-- 
                                    @if(isset($book->pivot->started_at) && $book->pivot->started_at)
                                        <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1">
                                            <i class="far fa-clock"></i> {{ date('d/m/Y', strtotime($book->pivot->started_at)) }}
                                        </p>
                                    @endif
                                    --}}
                                </div>

                                <div class="flex justify-end mt-2">
                                    <a href="{{ route('detail', $book->id) }}" class="text-brand-green border border-brand-green/30 bg-brand-green/5 px-3 py-1 rounded-md text-xs font-bold hover:bg-brand-green hover:text-white transition">
                                        Xem
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-16 bg-white rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                <i class="fas fa-book-open text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium mb-2">Chưa có cuốn sách nào trong mục này.</p>
                            <p class="text-gray-400 text-xs mb-4 max-w-xs">Hãy khám phá thư viện và thêm những cuốn sách bạn yêu thích vào đây nhé.</p>
                            <a href="{{ route('list') }}" class="text-white bg-brand-green px-6 py-2 rounded-lg text-sm font-bold hover:bg-brand-green-light shadow-md transition transform hover:-translate-y-0.5">
                                <i class="fas fa-plus mr-1"></i> Thêm sách ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection