{{-- Top Bar --}}
<div class="bg-brand-green text-white/80 text-xs py-2 hidden md:block border-b border-white/10">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex gap-6">
            <a href="tel:19001234" class="hover:text-brand-accent cursor-pointer transition flex items-center">
                <i class="fas fa-phone-alt mr-2"></i> Hotline: 1900 1234
            </a>
            <a href="mailto:contact@gocsach.com" class="hover:text-brand-accent cursor-pointer transition flex items-center">
                <i class="fas fa-envelope mr-2"></i> contact@gocsach.com
            </a>
        </div>
        <div class="flex gap-4 items-center">
            <button onclick="openModal('helpModal')" class="hover:text-white transition focus:outline-none">Trợ giúp</button>
            <span class="text-white/20">|</span>
            <button onclick="openModal('rulesModal')" class="hover:text-white transition focus:outline-none">Quy tắc cộng đồng</button>
            
            <div class="flex gap-3 ml-4">
                <a href="#" class="hover:text-brand-accent transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-brand-accent transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-brand-accent transition"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Header --}}
<header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-300">
    <div class="container mx-auto px-4 py-3">
        <div class="flex flex-wrap justify-between items-center gap-4">
            
            {{-- Logo --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-brand-green text-white rounded-lg flex items-center justify-center shadow-md transform group-hover:rotate-6 transition-transform duration-300">
                        <i class="fas fa-book-reader text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold font-serif text-brand-green leading-none tracking-tight">GÓC SÁCH</span>
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Review & Share</span>
                    </div>
                </a>
            </div>

            {{-- Search Bar --}}
            <div class="hidden md:flex flex-1 max-w-2xl px-8 relative z-40">
                <form action="{{ route('books.search') }}" method="GET" class="relative w-full flex items-center" id="header-search-form">
                    
                    {{-- Dropdown Danh Mục --}}
                    <div class="absolute left-0 pl-1 z-50 group pb-4 -mb-4"> 
                        <div class="flex items-center cursor-pointer bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full transition relative z-20">
                            <span class="text-gray-600 text-xs font-bold mr-1">Danh mục</span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-500 transition-transform group-hover:rotate-180"></i>
                        </div>
                        <div class="dropdown-menu dropdown-bridge absolute top-full left-0 mt-0 bg-white rounded-xl shadow-2xl border border-gray-100 p-4 min-w-[600px] max-w-[800px] z-10">
                            <div class="grid grid-rows-[repeat(10,minmax(0,1fr))] grid-flow-col gap-x-8 gap-y-2">
                                <a href="{{ route('books.list') }}" class="text-sm text-gray-600 hover:text-brand-green hover:font-bold truncate flex items-center">
                                    <i class="fas fa-caret-right text-gray-300 mr-2 text-xs"></i> Tất cả
                                </a>
                                @if(isset($menuCategories))
                                    @foreach($menuCategories as $cat)
                                        <a href="{{ route('books.list', ['category_id' => $cat->id]) }}" class="text-sm text-gray-600 hover:text-brand-green hover:font-bold truncate block py-0.5">{{ $cat->name }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Input tìm kiếm --}}
                    <input type="text" 
                           id="header-search-input" 
                           name="keyword" 
                           value="{{ request('keyword') }}" 
                           autocomplete="off"
                           placeholder="Nhập tên sách, tác giả..." 
                           class="w-full bg-gray-50 border border-gray-200 hover:border-brand-green/30 focus:border-brand-green/50 rounded-full py-2.5 pl-28 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/10 transition-all text-gray-700 placeholder-gray-400 shadow-inner">
                    
                    <button type="submit" class="absolute right-2 top-1.5 w-8 h-8 bg-brand-green text-white rounded-full flex items-center justify-center hover:bg-brand-accent transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </form>

                {{-- Kết quả Ajax (Đặt NGOÀI form để tránh form submit) --}}
                <div id="header-search-results" class="absolute top-full left-0 w-full bg-white shadow-xl rounded-xl mt-2 hidden z-[60] overflow-hidden border border-gray-100 max-h-[400px] overflow-y-auto">
                    {{-- JS sẽ render kết quả vào đây --}}
                </div>
            </div>
        
            {{-- User & Notification Actions --}}
            <div class="flex items-center gap-3 md:gap-5">
                @auth
                    {{-- Notification Bell --}}
                    <div class="relative group pb-4 -mb-4"> 
                        <button class="text-gray-500 hover:text-brand-green transition relative p-2 focus:outline-none">
                            <i class="far fa-bell text-xl"></i>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white animate-bounce">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-bridge absolute right-0 top-full mt-0 w-80 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in z-50 origin-top-right">
                            <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                                <span class="text-sm font-bold text-gray-700">Thông báo</span>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <a href="{{ route('notification.readAll') }}" class="text-[10px] text-blue-500 hover:underline cursor-pointer">Đánh dấu đã đọc</a>
                                @endif
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse(Auth::user()->notifications as $notification)
                                    @php
                                        $isSystemNotification = isset($notification->data['icon']);
                                    @endphp

                                    <a href="{{ route('notification.read', $notification->id) }}" class="flex gap-3 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 {{ $notification->read_at ? 'opacity-60 grayscale-[0.5]' : 'bg-blue-50/30' }}">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($isSystemNotification)
                                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                                    <i class="{{ $notification->data['icon'] }} {{ $notification->data['color'] ?? 'text-green-600' }} text-sm"></i>
                                                </div>
                                            @else
                                                <img src="{{ $notification->data['user_avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}" class="w-8 h-8 rounded-full border border-gray-100 object-cover">
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            @if($isSystemNotification)
                                                <p class="text-sm font-bold text-gray-800">Bài viết của bạn đã được duyệt</p>
                                                <p class="text-xs text-gray-600 line-clamp-2 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                            @else
                                                <p class="text-sm text-gray-700 line-clamp-2">
                                                    <span class="font-bold text-gray-900">{{ $notification->data['user_name'] ?? 'Ai đó' }}</span> 
                                                    {{ $notification->data['message'] ?? 'đã tương tác với bạn' }}
                                                    <span class="font-bold block text-xs text-gray-500 italic mt-0.5">"{{ Str::limit($notification->data['post_title'] ?? '', 50) }}"</span>
                                                </p>
                                            @endif
                                            <p class="text-[10px] text-gray-400 mt-1 flex items-center"><i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>

                                        @if(!$notification->read_at)
                                            <div class="w-2 h-2 bg-brand-green rounded-full mt-2 shrink-0"></div>
                                        @endif
                                    </a>
                                @empty
                                    <div class="text-center py-8 text-gray-400">
                                        <i class="far fa-bell-slash text-2xl mb-2 text-gray-300"></i>
                                        <p class="text-xs">Không có thông báo mới</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="relative group pb-2 -mb-2 z-50">
                         <a href="{{ route('profile') }}" class="flex items-center gap-2 focus:outline-none py-1 group-hover:opacity-80 transition cursor-pointer relative z-20">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=3E5F4E&color=fff&size=40' }}" 
                                 class="w-9 h-9 rounded-full border-2 border-brand-beige shadow-sm group-hover:border-brand-green transition object-cover">
                            <div class="hidden lg:flex flex-col items-start">
                                <span class="text-xs font-bold text-gray-700 truncate max-w-[80px]">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-gray-400">Thành viên</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 ml-1"></i>
                        </a>
                        
                        <div class="dropdown-menu dropdown-bridge absolute right-0 top-full mt-0 w-60 bg-white rounded-xl shadow-xl border border-gray-100 py-2 animate-fade-in origin-top-right z-10">
                            <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50 rounded-t-xl mb-1">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Tài khoản</p>
                                <p class="text-sm font-bold text-brand-green truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-red-600 bg-red-50 hover:bg-red-100 transition font-bold border-l-2 border-transparent hover:border-red-600 mx-2 rounded-md mb-1">
                                    <i class="fas fa-tachometer-alt w-5 mr-2"></i> Quản Trị Viên
                                </a>
                            @endif

                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-brand-green transition mx-2 rounded-md">
                                <i class="fas fa-user-circle w-5 mr-2 text-gray-400"></i> Hồ sơ cá nhân
                            </a>
                            
                            <a href="{{ route('change.password') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-brand-green transition mx-2 rounded-md">
                                <i class="fas fa-key w-5 mr-2 text-gray-400"></i> Đổi mật khẩu
                            </a>
                            
                            <div class="border-t border-gray-100 my-1 pt-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-gray-500 hover:bg-red-50 hover:text-red-600 transition font-medium mx-2 rounded-md">
                                    <i class="fas fa-sign-out-alt w-5 mr-2"></i> Đăng Xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green font-bold text-sm px-3 py-2 rounded-lg hover:bg-gray-100 transition hidden sm:block">Đăng Nhập</a>
                        <a href="{{ route('register') }}" class="bg-brand-green text-white px-5 py-2.5 rounded-full hover:bg-[#16271f] transition font-bold shadow-md text-sm flex items-center gap-2">
                            <i class="fas fa-user-plus text-xs"></i> <span>Đăng Ký</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Navigation --}}
        <div class="hidden md:flex justify-center mt-2 border-t border-gray-100 pt-3">
            <nav class="flex items-center gap-8 text-sm font-semibold text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all {{ request()->routeIs('home') ? 'text-brand-green border-b-2 border-brand-green' : '' }}">Trang Chủ</a>
                <a href="{{ route('books.list') }}" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all {{ request()->routeIs('books.list') ? 'text-brand-green border-b-2 border-brand-green' : '' }}">Danh Sách</a>
                <a href="{{ route('books.search') }}" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all {{ request()->routeIs('books.search') ? 'text-brand-green border-b-2 border-brand-green' : '' }}">Review Hay</a>
                <a href="#" class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all">Tác Giả</a>
                <a href="{{ route('challenges.index') }}" 
                class="hover:text-brand-green hover:border-b-2 hover:border-brand-green pb-3 -mb-3.5 transition-all {{ request()->routeIs('challenges.index') ? 'text-brand-green border-b-2 border-brand-green' : '' }}">
                Thử Thách
                </a>
            </nav>
        </div>
    </div>
</header>

{{-- Modals --}}
<div id="rulesModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 modal-overlay transition-opacity" onclick="closeModal('rulesModal')"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg animate-scale-up">
                <div class="bg-brand-green px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold leading-6 text-white" id="modal-title"><i class="fas fa-gavel mr-2"></i> Quy Tắc Cộng Đồng</h3>
                    <button onclick="closeModal('rulesModal')" class="text-white/70 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="px-4 py-5 sm:p-6 text-sm text-gray-600 space-y-3 max-h-[400px] overflow-y-auto">
                    <p class="font-bold text-gray-800">1. Tôn trọng lẫn nhau:</p><p>Không sử dụng ngôn từ đả kích, xúc phạm hoặc phân biệt đối xử với các thành viên khác.</p>
                    <p class="font-bold text-gray-800 mt-2">2. Không Spam:</p><p>Không đăng tải các nội dung quảng cáo, tin rác hoặc bình luận trùng lặp nhiều lần.</p>
                    <p class="font-bold text-gray-800 mt-2">3. Bản quyền nội dung:</p><p>Chỉ chia sẻ những nội dung bạn có quyền sở hữu hoặc trích dẫn nguồn rõ ràng. Không đăng tải sách lậu.</p>
                    <p class="font-bold text-gray-800 mt-2">4. Review trung thực:</p><p>Đánh giá sách dựa trên trải nghiệm thực tế, không thiên vị hoặc cố tình dìm hàng.</p>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-brand-green px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-green/90 sm:ml-3 sm:w-auto" onclick="closeModal('rulesModal')">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="helpModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 modal-overlay transition-opacity" onclick="closeModal('helpModal')"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg animate-scale-up">
                <div class="bg-blue-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold leading-6 text-white"><i class="fas fa-question-circle mr-2"></i> Trung Tâm Trợ Giúp</h3>
                    <button onclick="closeModal('helpModal')" class="text-white/70 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="px-4 py-5 sm:p-6 text-sm text-gray-600 space-y-4">
                    <div class="flex items-start gap-3"><div class="bg-blue-100 p-2 rounded-full text-blue-600"><i class="fas fa-user-plus"></i></div><div><h4 class="font-bold text-gray-800">Làm sao để đăng ký?</h4><p>Nhấn vào nút "Đăng Ký" ở góc phải màn hình và điền thông tin email của bạn.</p></div></div>
                    <div class="flex items-start gap-3"><div class="bg-blue-100 p-2 rounded-full text-blue-600"><i class="fas fa-star"></i></div><div><h4 class="font-bold text-gray-800">Cách viết Review?</h4><p>Tìm cuốn sách bạn muốn, vào trang chi tiết và kéo xuống phần "Viết đánh giá của bạn".</p></div></div>
                    <div class="flex items-start gap-3"><div class="bg-blue-100 p-2 rounded-full text-blue-600"><i class="fas fa-envelope"></i></div><div><h4 class="font-bold text-gray-800">Liên hệ hỗ trợ?</h4><p>Email: <a href="mailto:support@gocsach.com" class="text-blue-600 hover:underline">support@gocsach.com</a><br>Hotline: 1900 1234 (8h-17h)</p></div></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-300 sm:ml-3 sm:w-auto" onclick="closeModal('helpModal')">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            document.querySelectorAll('[id$="Modal"]').forEach(el => el.classList.add('hidden'));
        }
    });
</script>

<style>
    .dropdown-menu { display: none; }
    .group:hover .dropdown-menu { display: block; }
    
    .dropdown-bridge::before {
        content: "";
        position: absolute;
        top: -10px;
        left: 0;
        width: 100%;
        height: 10px;
        background: transparent;
    }

    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .animate-fade-in {
        animation: fadeIn 0.2s ease-in-out;
    }
    
    .animate-scale-up {
        animation: scaleUp 0.3s ease-out;
    }

    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleUp {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
</style>

{{-- Live Search Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('header-search-input');
    const resultsBox = document.getElementById('header-search-results');
    let timeout = null;

    if (searchInput && resultsBox) {
        // 1. Khi người dùng gõ phím
        searchInput.addEventListener('input', function() {
            const keyword = this.value.trim();
            clearTimeout(timeout);

            if (keyword.length < 2) { 
                resultsBox.classList.add('hidden');
                resultsBox.innerHTML = '';
                return;
            }

            // Hiển thị loading
            resultsBox.innerHTML = '<div class="p-4 text-center text-gray-400"><i class="fas fa-spinner fa-spin mr-2"></i>Đang tìm kiếm...</div>';
            resultsBox.classList.remove('hidden');

            // Debounce 300ms
            timeout = setTimeout(() => {
                fetchResults(keyword);
            }, 300);
        });

        // 2. Gửi Ajax lên Server
        function fetchResults(keyword) {
            fetch(`/ajax-search?keyword=${encodeURIComponent(keyword)}`)
                .then(response => response.json())
                .then(data => {
                    renderResults(data, keyword);
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsBox.innerHTML = '<div class="p-4 text-center text-red-400">Có lỗi xảy ra</div>';
                });
        }

        // 3. Hiển thị kết quả
        function renderResults(books, keyword) {
            if (books.length > 0) {
                let html = '<ul class="divide-y divide-gray-100">';
                
                books.forEach(book => {
                    // Xử lý ảnh bìa
                    let imgUrl = book.cover_image 
                        ? (book.cover_image.startsWith('http') ? book.cover_image : '/storage/' + book.cover_image)
                        : 'https://via.placeholder.com/50x70?text=No+Image';
                    
                    // URL chi tiết sách (dùng slug hoặc ID nếu slug không có)
                    let detailUrl = `/chi-tiet/${book.slug || book.id}`;

                    // Highlight từ khóa trong title
                    let highlightedTitle = book.title.replace(
                        new RegExp(`(${keyword})`, 'gi'), 
                        '<span class="bg-yellow-200 text-gray-900 font-bold">$1</span>'
                    );

                    html += `
                        <li>
                            <a href="${detailUrl}" class="search-result-link flex items-center gap-3 p-3 hover:bg-gray-50 transition cursor-pointer">
                                <img src="${imgUrl}" class="w-10 h-14 object-cover rounded shadow-sm border border-gray-200 flex-shrink-0" onerror="this.src='https://via.placeholder.com/50x70?text=No+Image'">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-1">${highlightedTitle}</h4>
                                    <p class="text-xs text-gray-500">${book.author_name || 'Đang cập nhật'}</p>
                                    ${book.avg_rating ? `<div class="flex items-center gap-1 mt-0.5"><i class="fas fa-star text-yellow-400 text-[10px]"></i><span class="text-[10px] text-gray-400">${parseFloat(book.avg_rating).toFixed(1)}</span></div>` : ''}
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                            </a>
                        </li>
                    `;
                });
                
                // Link xem tất cả
                html += `
                    <li class="bg-gradient-to-r from-gray-50 to-white text-center p-3 border-t border-gray-100">
                        <a href="/danh-sach-sach?keyword=${encodeURIComponent(keyword)}" class="text-sm font-bold text-brand-green hover:text-brand-accent transition flex items-center justify-center gap-2">
                            <span>Xem tất cả kết quả</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </li>
                `;

                html += '</ul>';
                resultsBox.innerHTML = html;
            } else {
                resultsBox.innerHTML = `
                    <div class="p-6 text-center">
                        <i class="far fa-frown text-3xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-400">Không tìm thấy sách nào với từ khóa "<strong>${keyword}</strong>"</p>
                        <a href="/danh-sach-sach" class="text-xs text-brand-green hover:underline mt-2 inline-block">Xem tất cả sách →</a>
                    </div>
                `;
            }
            resultsBox.classList.remove('hidden');
        }

        // 4. Click ra ngoài thì ẩn dropdown (nhưng cho phép click vào link bên trong)
        document.addEventListener('click', function(e) {
            // Nếu click vào link bên trong resultsBox thì cho phép navigation
            if (e.target.closest('#header-search-results a')) {
                return; // Không làm gì, để link hoạt động bình thường
            }
            
            if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add('hidden');
            }
        });

        // 5. Nhấn ESC để đóng dropdown
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                resultsBox.classList.add('hidden');
            }
        });

        // 6. Focus lại input thì hiện dropdown nếu có kết quả
        searchInput.addEventListener('focus', function() {
            if (resultsBox.innerHTML.trim() !== '' && this.value.length >= 2) {
                resultsBox.classList.remove('hidden');
            }
        });
    }
});
</script>