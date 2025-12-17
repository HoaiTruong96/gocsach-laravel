@extends('layouts.app')

@section('title', 'Trang Cá Nhân - ' . $user->name)

@section('content')
    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Hồ sơ của {{ $user->name }}</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow min-h-screen">
        {{-- THÔNG BÁO THÀNH CÔNG (NẾU CÓ) --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative shadow-sm flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
                    <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- ============================================================== --}}
            {{-- CỘT TRÁI: SIDEBAR THÔNG TIN USER                               --}}
            {{-- ============================================================== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-soft p-6 text-center border border-gray-100">
                    
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
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span> 
                            {{ $user->is_active ? 'Hoạt động' : 'Đang khóa' }}
                        </span>
                    </div>

                      <div class="grid grid-cols-2 gap-3 mb-6 border-t border-b border-gray-100 py-4">
                        <div class="text-center">
                            <span class="block font-bold text-xl text-brand-green">{{ $totalBooks ?? 0 }}</span>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Sách đề xuất</span>
                        </div>
                        <div class="text-center border-l border-gray-100">
                            <span class="block font-bold text-xl text-brand-accent">{{ $totalReviews ?? 0 }}</span>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Bài viết</span>
                        </div>
                        
                        <div class="text-center mt-2 pt-2 border-t border-gray-50 col-span-2 grid grid-cols-2">
                            <div class="cursor-pointer hover:bg-gray-50 rounded transition p-1" onclick="openFollowModal('following', {{ $user->id }})">
                                <span class="block font-bold text-lg text-gray-800">{{ $totalFollowing ?? 0 }}</span>
                                <span class="text-xs text-gray-400 uppercase hover:text-blue-500 transition">Đang theo dõi</span>
                            </div>
                            <div class="cursor-pointer hover:bg-gray-50 rounded transition p-1" onclick="openFollowModal('followers', {{ $user->id }})">
                                <span class="block font-bold text-lg text-gray-800" id="follower-count">{{ $totalFollowers ?? 0 }}</span>
                                <span class="text-xs text-gray-400 uppercase hover:text-blue-500 transition">Người theo dõi</span>
                            </div>
                        </div>
                    </div>
                    {{-- [MỚI] KHUNG HIỂN THỊ DANH HIỆU (BADGES) --}}
                    @if($user->activeBadges && $user->activeBadges->count() > 0)
                        <div class="mb-6 border-t border-b border-gray-100 py-4">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                                <i class="fas fa-medal mr-1"></i> Danh Hiệu
                            </h4>
                            
                            <div class="flex justify-center flex-wrap gap-3">
                                @foreach($user->activeBadges as $badge)
                                    @php
                                        $icon = $badge->icon;
                                        // Kiểm tra xem icon có phải là URL hay không
                                        $isUrl = $icon && (Str::startsWith($icon, 'http') || Str::startsWith($icon, '/'));
                                        // Nếu là URL thì xử lý đường dẫn
                                        $iconUrl = $isUrl 
                                            ? (Str::startsWith($icon, 'http') ? $icon : asset('storage/' . $icon))
                                            : null;
                                    @endphp
                                    
                                    <div class="group relative cursor-help">
                                        @if($iconUrl)
                                            {{-- Hiển thị ảnh nếu là URL hợp lệ --}}
                                            <img src="{{ $iconUrl }}" 
                                                 alt="{{ $badge->name }}" 
                                                 class="w-12 h-12 object-contain drop-shadow-sm transform group-hover:scale-110 transition duration-300"
                                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md\'>🏆</div>';">
                                        @elseif($icon && mb_strlen($icon) <= 4)
                                            {{-- Hiển thị emoji nếu icon là emoji (ký tự ngắn) --}}
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-2xl shadow-md transform group-hover:scale-110 transition duration-300">
                                                {{ $icon }}
                                            </div>
                                        @else
                                            {{-- Fallback: Hiển thị icon mặc định nếu không có --}}
                                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white shadow-md transform group-hover:scale-110 transition duration-300">
                                                <i class="fas fa-medal text-xl"></i>
                                            </div>
                                        @endif
                                        
                                        {{-- Tooltip hiển thị tên khi di chuột vào --}}
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-50 w-max">
                                            <div class="bg-gray-800 text-white text-xs rounded py-1 px-3 shadow-lg text-center">
                                                <div class="font-bold">{{ $badge->name }}</div>
                                                @if($badge->description)
                                                    <div class="text-[10px] text-gray-300 font-normal">{{ $badge->description }}</div>
                                                @endif
                                            </div>
                                            {{-- Mũi tên nhỏ của tooltip --}}
                                            <div class="w-2 h-2 bg-gray-800 transform rotate-45 absolute -bottom-1 left-1/2 -translate-x-1/2"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    {{-- KẾT THÚC KHUNG DANH HIỆU --}}
                    
                    <div class="text-xs text-gray-400 space-y-1.5 mb-6 text-left pl-2">
                        <p><i class="far fa-calendar-alt mr-2 w-4 text-center"></i> Tham gia: <span class="text-gray-600">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</span></p>
                        <p><i class="fas fa-sync-alt mr-2 w-4 text-center"></i> Cập nhật: <span class="text-gray-600">{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : 'N/A' }}</span></p>
                    </div>

                    <div class="space-y-2">
                        @if(Auth::check() && Auth::id() != $user->id)
                             <button onclick="toggleFollow({{ $user->id }})" 
                                id="btn-follow"
                                class="w-full py-2.5 rounded-lg font-bold transition mb-4 shadow-md flex items-center justify-center gap-2 {{ Auth::user()->isFollowing($user->id) ? 'bg-gray-200 text-gray-800' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                <i class="fas {{ Auth::user()->isFollowing($user->id) ? 'fa-check' : 'fa-user-plus' }}"></i>
                                <span id="follow-text">
                                    {{ Auth::user()->isFollowing($user->id) ? 'Đang theo dõi' : 'Theo dõi' }}
                                </span>
                             </button>
                        @endif

                        @if(Auth::id() == $user->id)
                            <a href="#" class="block w-full border border-brand-green text-brand-green py-2 rounded-lg font-bold text-sm hover:bg-brand-green hover:text-white transition">
                                <i class="fas fa-edit mr-1"></i> Chỉnh sửa hồ sơ
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block w-full border border-red-200 text-red-500 py-2 rounded-lg font-bold text-sm hover:bg-red-50 transition mt-2">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3">

                {{-- ================================================================= --}}
                {{-- PHẦN 1: SÁCH TÔI ĐỀ XUẤT (ĐÃ SỬA GIAO DIỆN MOCKUP)                --}}
                {{-- ================================================================= --}}
                @if(Auth::check() && Auth::id() == $user->id)
                    <div class="bg-white rounded-xl shadow-soft p-4 mb-8 border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-lg font-bold text-brand-green font-serif border-l-4 border-brand-accent pl-3">
                            Sách Tôi Đề Xuất
                        </h3>
                        
                        {{-- Nút bấm Đề xuất --}}
                        <a href="#" class="text-xs font-bold text-white bg-brand-accent hover:bg-[#c29263] px-4 py-2 rounded-full shadow-sm transition flex items-center gap-2 transform hover:-translate-y-0.5">
                            <i class="fas fa-plus-circle"></i> Đề xuất sách mới
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        {{-- Tạm thời dùng $myBooks để hiển thị giao diện test --}}
                        @if(isset($myBooks) && count($myBooks) > 0)
                            @foreach($myBooks as $book)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-row h-40 relative group">
                                
                                {{-- [MOCKUP] BADGE TRẠNG THÁI --}}
                                <div class="absolute top-2 right-2 z-10">
                                    @if($loop->index % 2 == 0) 
                                        {{-- Giả lập: ĐÃ DUYỆT --}}
                                        <span class="bg-green-100 text-green-700 border border-green-200 text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center gap-1">
                                            <i class="fas fa-check-circle"></i> ĐÃ DUYỆT
                                        </span>
                                    @else
                                        {{-- Giả lập: CHỜ DUYỆT --}}
                                        <span class="bg-yellow-50 text-yellow-700 border border-yellow-100 text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center gap-1">
                                            <i class="fas fa-clock"></i> CHỜ DUYỆT
                                        </span>
                                    @endif
                                </div>

                                <div class="w-28 relative flex-shrink-0 bg-gray-200">
                                    <a href="#">
                                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/150x225?text=No+Image' }}" class="w-full h-full object-cover transition group-hover:opacity-90">
                                    </a>
                                </div>
                                <div class="p-4 flex flex-col justify-between flex-grow min-w-0">
                                    <div>
                                        <h4 class="font-bold font-serif text-gray-800 text-sm mb-1 leading-tight line-clamp-2">
                                            <a href="#" class="hover:text-brand-green transition">
                                                {{ $book->title }}
                                            </a>
                                        </h4>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ $book->author_name ?? ($book->author->name ?? 'Tác giả') }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 mt-1">
                                            <i class="far fa-calendar-alt mr-1"></i> Gửi: {{ now()->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-end mt-2">
                                        <a href="#" class="text-brand-green border border-brand-green/30 bg-brand-green/5 px-3 py-1 rounded-md text-xs font-bold hover:bg-brand-green hover:text-white transition">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-span-full text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    <i class="fas fa-book-medical text-2xl"></i>
                                </div>
                                <p class="text-gray-500 text-sm font-medium">Bạn chưa đề xuất cuốn sách nào.</p>
                                <p class="text-gray-400 text-xs mt-1 mb-3">Hãy đóng góp sách mới cho cộng đồng nhé!</p>
                                <a href="#" class="text-brand-accent text-sm font-bold hover:underline">
                                    + Đề xuất sách ngay
                                </a>
                            </div>
                        @endif
                    </div>
                @endif


                {{-- ================================================================= --}}
                {{-- PHẦN 2: DANH SÁCH REVIEW (ĐÃ FIX HIỂN THỊ TIÊU ĐỀ)                --}}
                {{-- ================================================================= --}}
                
                <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-gray-800 font-serif border-l-4 border-brand-green pl-3">
                            {{ isset($reviews) && $reviews->total() > 0 ? 'Bài Review Đã Đăng' : 'Chưa có bài viết nào' }}
                        </h3>

                        @if(Auth::check() && Auth::id() == $user->id)
                            <a href="{{ route('reviews.create') }}" class="inline-flex items-center gap-1.5 bg-brand-accent hover:bg-[#c29263] text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm transition transform hover:-translate-y-0.5">
                                <i class="fas fa-pen-nib"></i> Viết Review
                            </a>
                        @endif
                    </div>

                    @if(isset($reviews) && $reviews->total() > 0)
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Tổng: {{ $reviews->total() }}</span>
                    @endif
                </div>
                
                <div class="space-y-6">
                    @forelse($reviews as $post)
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group relative">
                            
                            {{-- [MỚI] BADGE TRẠNG THÁI (Góc trên cùng bên phải) --}}
                            <div class="absolute top-4 right-4 z-10">
                                @if($post->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-bold rounded-full border border-yellow-200 shadow-sm animate-pulse">
                                        <i class="fas fa-clock"></i> Đang chờ duyệt
                                    </span>
                                @elseif($post->status == 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-full border border-red-200 shadow-sm">
                                        <i class="fas fa-times-circle"></i> Bị từ chối
                                    </span>
                                @elseif($post->status == 'published')
                                    {{-- Nếu bạn muốn hiện chữ Đã duyệt (thường thì không cần thiết, để trống cho đẹp) --}}
                                    {{-- <span class="text-green-600 text-xs font-bold"><i class="fas fa-check-circle"></i> Đã duyệt</span> --}}
                                @endif
                            </div>

                            {{-- THÔNG TIN SÁCH (Giữ nguyên) --}}
                            <div class="flex justify-between items-start mb-4 pr-20"> {{-- Thêm pr-20 để tránh đè lên badge --}}
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('book.show', $post->book_id ?? 0) }}" class="block shrink-0">
                                        {{-- Sửa lại đường dẫn ảnh cho chuẩn --}}
                                        @php
                                            $cover = $post->book->cover_image ?? null;
                                            $coverUrl = $cover 
                                                ? (Str::startsWith($cover, 'http') ? $cover : asset('storage/' . $cover))
                                                : 'https://via.placeholder.com/50';
                                        @endphp
                                        <img src="{{ $coverUrl }}" 
                                             class="w-12 h-16 object-cover rounded shadow-sm border border-gray-200">
                                    </a>
                                    
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-base mb-1">
                                            <a href="{{ route('book.show', $post->book_id ?? 0) }}" class="hover:text-brand-green transition">
                                                {{ $post->book->title ?? 'Sách đã xóa' }}
                                            </a>
                                        </h4>
                                        <div class="flex text-yellow-400 text-xs items-center gap-2">
                                            <div class="flex">
                                                @for($i=1; $i<=5; $i++)
                                                    <i class="fas fa-star {{ $i <= ($post->rating ?? 0) ? '' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-gray-400 text-[11px]">• {{ $post->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TIÊU ĐỀ & NỘI DUNG --}}
                            <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-brand-green transition">
                                {{ $post->title }}
                            </h3>
                            
                            {{-- Nội dung review (Render HTML an toàn) --}}
                            <div class="text-gray-500 text-sm line-clamp-3 prose prose-sm max-w-none">
                                {!! $post->content !!}
                            </div>

                            {{-- FOOTER --}}
                            <div class="flex items-center justify-between mt-4 text-xs text-gray-400 border-t border-gray-50 pt-3">
                                <span class="flex items-center gap-2">
                                    <i class="far fa-clock"></i> {{ $post->created_at->diffForHumans() }}
                                </span>

                                <a href="{{ route('book.reviews', $post->book->slug ?? $post->book_id) }}" 
                                   class="text-brand-green font-bold hover:underline text-xs uppercase tracking-wide flex items-center gap-1">
                                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i class="fas fa-pen-nib text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Người dùng này chưa có bài viết nào.</p>
                            @if(Auth::check() && Auth::id() == $user->id)
                                <a href="{{ route('reviews.create') }}" class="text-brand-accent font-bold hover:underline text-sm">
                                    Viết bài đầu tiên ngay
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
        
        {{-- Modal Follow (Giữ nguyên) --}}
        <div id="followModal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeFollowModal()"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Danh sách</h3>
                                <button onclick="closeFollowModal()" class="text-gray-400 hover:text-gray-600 transition">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="bg-white px-4 py-2 sm:p-6 max-h-[400px] overflow-y-auto" id="modal-body">
                            <div class="flex justify-center py-4">
                                <i class="fas fa-spinner fa-spin text-brand-green text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        // --- 1. Xử lý Nút Toggle Follow (Một hàm duy nhất) ---
        function toggleFollow(userId) {
            fetch('{{ route('follow.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'error') { alert(data.message); return; }
                
                const btn = document.getElementById('btn-follow');
                const text = document.getElementById('follow-text');
                const icon = btn.querySelector('i');
                const countSpan = document.getElementById('follower-count');

                if(data.follower_count !== undefined) countSpan.innerText = data.follower_count;

                if(data.action === 'followed') {
                    btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                    btn.classList.add('bg-gray-200', 'text-gray-800');
                    text.innerText = 'Đang theo dõi';
                    icon.className = 'fas fa-check';
                } else {
                    btn.classList.remove('bg-gray-200', 'text-gray-800');
                    btn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                    text.innerText = 'Theo dõi';
                    icon.className = 'fas fa-user-plus';
                }
            })
            .catch(error => console.error('Lỗi Follow:', error));
        }

        // --- 2. Xử lý Modal Danh sách Follow ---
        function openFollowModal(type, userId) {
            const modal = document.getElementById('followModal');
            const title = document.getElementById('modal-title');
            const body = document.getElementById('modal-body');

            // Reset nội dung loading
            body.innerHTML = '<div class="flex justify-center py-4"><i class="fas fa-spinner fa-spin text-brand-green text-2xl"></i></div>';
            
            // Hiện modal
            modal.classList.remove('hidden');

            // Đặt tiêu đề
            if(type === 'followers') title.innerText = 'Người theo dõi';
            else title.innerText = 'Đang theo dõi';

            // Gọi API lấy danh sách
            fetch(`/api/user/${userId}/${type}`)
                .then(res => res.json())
                .then(users => {
                    body.innerHTML = ''; // Xóa loading

                    if(users.length === 0) {
                        body.innerHTML = '<p class="text-center text-gray-500 py-4 text-sm">Chưa có ai trong danh sách này.</p>';
                        return;
                    }

                    // Vẽ danh sách user
                    let html = '<div class="space-y-3">';
                    users.forEach(u => {
                        // Logic lấy avatar (Nếu null thì dùng UI Avatars)
                        const avatar = u.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=random`;
                        
                        // Link tới profile người đó
                        html += `
                            <a href="/profile/${u.id}" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition group border border-transparent hover:border-gray-100">
                                <img src="${avatar}" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm group-hover:text-brand-green transition">${u.name}</h4>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-xs text-gray-400 group-hover:text-brand-green"><i class="fas fa-chevron-right"></i></span>
                                </div>
                            </a>
                        `;
                    });
                    html += '</div>';
                    body.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    body.innerHTML = '<p class="text-center text-red-500 py-4 text-sm">Không thể tải dữ liệu.</p>';
                });
        }

        function closeFollowModal() {
            document.getElementById('followModal').classList.add('hidden');
        }

        // Đóng modal khi nhấn ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeFollowModal();
            }
        });
    </script>
@endsection