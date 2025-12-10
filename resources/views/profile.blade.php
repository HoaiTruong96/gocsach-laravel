@extends('layouts.app')

@section('title', 'Trang Cá Nhân - ' . $user->name)

@section('content')
    <!-- Breadcrumb -->
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
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- CỘT TRÁI: THÔNG TIN USER -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-soft p-6 text-center border border-gray-100 sticky top-24">
                    
                    <!-- Avatar -->
                    <div class="relative w-32 h-32 mx-auto mb-4 group">
                        <!-- Logic Avatar: Nếu null thì dùng UI Avatars -->
                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3E5F4E&color=fff&size=128' }}" 
                             class="rounded-full border-4 border-brand-beige shadow-md object-cover w-full h-full group-hover:border-brand-green transition duration-300">
                        
                        <!-- Nút đổi ảnh (Chỉ hiện khi xem profile của chính mình) -->
                        @if(Auth::id() == $user->id)
                            <button class="absolute bottom-0 right-0 bg-white border border-gray-200 p-1.5 rounded-full text-gray-500 hover:text-brand-green hover:border-brand-green shadow-sm transition" title="Đổi ảnh đại diện">
                                <i class="fas fa-camera text-xs"></i>
                            </button>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-gray-800 font-serif">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm mb-3">{{ $user->email }}</p>
                    
                    <!-- Bio -->
                    <p class="text-gray-600 text-sm italic mb-4 px-2 bg-gray-50 py-2 rounded-lg border border-gray-100 relative">
                        <i class="fas fa-quote-left text-gray-300 absolute top-1 left-1 text-xs"></i>
                        {{ $user->bio ?? 'Thành viên tích cực của Góc Sách.' }}
                    </p>

                    <!-- Badges (Role & Status) -->
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

                     <!-- Thống kê (Click mở Modal) -->
                    <div class="grid grid-cols-2 gap-3 mb-6 border-t border-b border-gray-100 py-4">
                        <div class="text-center">
                            <span class="block font-bold text-xl text-brand-green">{{ $totalBooks ?? 0 }}</span>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tủ sách</span>
                        </div>
                        <div class="text-center border-l border-gray-100">
                            <span class="block font-bold text-xl text-brand-accent">{{ $totalReviews ?? 0 }}</span>
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Bài viết</span>
                        </div>
                        
                        <div class="text-center mt-2 pt-2 border-t border-gray-50 col-span-2 grid grid-cols-2">
                            <!-- Nút Đang theo dõi -->
                            <div class="cursor-pointer hover:bg-gray-50 rounded transition p-1" onclick="openFollowModal('following', {{ $user->id }})">
                                <span class="block font-bold text-lg text-gray-800">{{ $totalFollowing ?? 0 }}</span>
                                <span class="text-xs text-gray-400 uppercase hover:text-blue-500 transition">Đang theo dõi</span>
                            </div>
                            <!-- Nút Người theo dõi -->
                            <div class="cursor-pointer hover:bg-gray-50 rounded transition p-1" onclick="openFollowModal('followers', {{ $user->id }})">
                                <span class="block font-bold text-lg text-gray-800" id="follower-count">{{ $totalFollowers ?? 0 }}</span>
                                <span class="text-xs text-gray-400 uppercase hover:text-blue-500 transition">Người theo dõi</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-400 space-y-1.5 mb-6 text-left pl-2">
                        <p><i class="far fa-calendar-alt mr-2 w-4 text-center"></i> Tham gia: <span class="text-gray-600">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</span></p>
                        <p><i class="fas fa-sync-alt mr-2 w-4 text-center"></i> Cập nhật: <span class="text-gray-600">{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : 'N/A' }}</span></p>
                    </div>

                    <!-- Các nút hành động -->
                    <div class="space-y-2">
                        <!-- Nút Follow cho người khác (Ajax) -->
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

                        <!-- Nút cho chủ tài khoản -->
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
                {{-- PHẦN 1: SÁCH YÊU THÍCH (Chỉ hiện wishlist) --}}
                {{-- ================================================================= --}}
                
                <!-- Tiêu đề Section -->
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 font-serif border-l-4 border-pink-500 pl-3">
                        Sách Yêu Thích
                    </h3>
                    <span class="bg-pink-100 text-pink-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $myBooks->count() }} cuốn
                    </span>
                    <div class="flex-grow border-b border-gray-100"></div>
                </div>

                <!-- Grid Sách Yêu Thích -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @if(isset($myBooks) && count($myBooks) > 0)
                        @foreach($myBooks as $book)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-row h-36 relative group">
                            
                            <!-- Badge Tim (Trang trí) -->
                            <div class="absolute top-0 right-2 z-10 text-pink-500 opacity-20 group-hover:opacity-100 transition text-2xl">
                                <i class="fas fa-heart"></i>
                            </div>

                            <div class="w-24 relative flex-shrink-0 bg-gray-200">
                                <a href="{{ route('book.show', $book->id) }}">
                                    <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/150x225?text=No+Image' }}" 
                                         class="w-full h-full object-cover transition group-hover:opacity-90">
                                </a>
                            </div>

                            <div class="p-3 flex flex-col justify-between flex-grow min-w-0">
                                <div>
                                    <h4 class="font-bold font-serif text-gray-800 text-sm mb-1 leading-tight line-clamp-2" title="{{ $book->title }}">
                                        <a href="{{ route('book.show', $book->id) }}" class="hover:text-pink-600 transition">{{ $book->title }}</a>
                                    </h4>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ is_object($book->author) ? ($book->author->name ?? 'N/A') : $book->author_id }}
                                    </p>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <a href="{{ route('book.show', $book->id) }}" class="text-pink-500 border border-pink-200 bg-pink-50 px-3 py-1 rounded-md text-xs font-bold hover:bg-pink-500 hover:text-white transition">
                                        Xem lại
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-8 bg-white rounded-xl border border-dashed border-gray-300">
                            <i class="far fa-heart text-3xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500 text-sm">Chưa có cuốn sách yêu thích nào.</p>
                        </div>
                    @endif
                </div>


                {{-- ================================================================= --}}
                {{-- PHẦN 2: DANH SÁCH REVIEW (Giữ nguyên code review cũ ở đây) --}}
                {{-- ================================================================= --}}
                
                <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">
                    <h3 class="text-xl font-bold text-gray-800 font-serif border-l-4 border-brand-green pl-3">
                        Bài Review Đã Đăng
                    </h3>
                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Tổng: {{ $reviews->total() }}</span>
                </div>
                
                <div class="space-y-6">
                    @foreach($reviews as $post)
                        <!-- (Dán lại đoạn code hiển thị 1 bài review cũ của bạn vào đây) -->
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                            <!-- ... Code Review Cũ ... -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('book.show', $post->book_id ?? 0) }}" class="block shrink-0">
                                        <img src="{{ $post->book->cover_image ?? 'https://via.placeholder.com/50' }}" class="w-12 h-16 object-cover rounded shadow-sm border border-gray-200">
                                    </a>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-base mb-1">{{ $post->book->title ?? 'Sách đã xóa' }}</h4>
                                        <div class="flex text-yellow-400 text-xs">
                                            @for($i=1; $i<=5; $i++) <i class="fas fa-star {{ $i <= $post->rating ? '' : 'text-gray-300' }}"></i> @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-3 bg-gray-50 p-3 rounded-lg italic">"{{ $post->content }}"</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
        <div id="followModal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeFollowModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                    <!-- Header Modal -->
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Danh sách</h3>
                            <button onclick="closeFollowModal()" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body Modal (List User) -->
                    <div class="bg-white px-4 py-2 sm:p-6 max-h-[400px] overflow-y-auto" id="modal-body">
                        <!-- Ajax sẽ chèn nội dung vào đây -->
                        <div class="flex justify-center py-4">
                            <i class="fas fa-spinner fa-spin text-brand-green text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </main>

    <!-- SCRIPT AJAX FOLLOW -->
    <script>
        function toggleFollow(userId) {
            const btn = document.getElementById('btn-follow');
            const text = document.getElementById('follow-text');
            const icon = btn.querySelector('i');
            const countSpan = document.getElementById('follower-count');

            // Gửi Ajax
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
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }

                // Cập nhật số lượng người theo dõi ngay lập tức
                if (data.follower_count !== undefined) {
                    countSpan.innerText = data.follower_count;
                }

                // Cập nhật giao diện nút bấm
                if (data.action === 'followed') {
                    // Trạng thái: Đã theo dõi
                    btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                    btn.classList.add('bg-gray-200', 'text-gray-800');
                    text.innerText = 'Đang theo dõi';
                    icon.className = 'fas fa-check';
                } else {
                    // Trạng thái: Chưa theo dõi
                    btn.classList.remove('bg-gray-200', 'text-gray-800');
                    btn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                    text.innerText = 'Theo dõi';
                    icon.className = 'fas fa-user-plus';
                }
            })
            .catch(err => console.error(err));
        }
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
            // Đảm bảo URL chính xác: /api/user/{id}/followers hoặc /api/user/{id}/following
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
                                    <!-- Nếu muốn hiện thêm bio hoặc email -->
                                    <!-- <p class="text-xs text-gray-400 truncate w-48">${u.email}</p> -->
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