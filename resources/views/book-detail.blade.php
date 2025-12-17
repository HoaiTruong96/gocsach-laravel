@extends('layouts.app')

@section('title', 'Chi Tiết Sách - ' . ($book->title ?? 'Góc Sách'))

@section('content')
    <style>
        html { scroll-behavior: smooth; }
        .text-justify-last-left { text-align: justify; text-align-last: left; }
    </style>

    {{-- [BREADCRUMB] --}}
    <div class="bg-brand-beige/40 py-4 border-b border-brand-beige/50">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500 font-medium">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('books.list') }}" class="hover:text-brand-green transition">
                    {{ isset($book->categories) && $book->categories->isNotEmpty() ? $book->categories->first()->name : 'Sách' }}
                </a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold truncate max-w-[200px]">{{ $book->title ?? 'Chi tiết sách' }}</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-12 flex-grow">
        
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm max-w-4xl mx-auto">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <span class="font-medium ml-2">{{ session('success') }}</span>
            </div>
        @endif

        {{-- 1. HERO SECTION (GIỮ NGUYÊN) --}}
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-soft border border-gray-100 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-green/5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 relative z-10">
                {{-- Ảnh Bìa --}}
                <div class="md:col-span-4 lg:col-span-3">
                    <div class="relative w-full aspect-[2/3] rounded-r-lg rounded-l-sm shadow-book transform hover:scale-[1.02] transition duration-500 cursor-pointer group">
                        <img src="{{ !empty($book->cover_image) ? $book->cover_image : 'https://via.placeholder.com/300x450?text=No+Image' }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover rounded-r-lg rounded-l-sm border-l-4 border-gray-200"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x450?text=No+Image'">
                    </div>
                </div>

                {{-- Thông Tin Chi Tiết --}}
                <div class="md:col-span-8 lg:col-span-9 flex flex-col justify-center">
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-brand-accent/10 text-brand-accent text-xs font-bold uppercase tracking-wider mb-3 border border-brand-accent/20">
                            {{ $book->categories->isNotEmpty() ? $book->categories->first()->name : 'Văn Học' }}
                        </span>
                        <h1 class="text-3xl md:text-5xl font-bold text-brand-green font-serif mt-1 mb-3 leading-tight">
                            {{ $book->title ?? 'Tiêu đề sách' }}
                        </h1>
                        <div class="flex items-center gap-4 text-sm font-medium">
                            <span class="text-gray-500">Tác giả: 
                                <span class="text-brand-green font-bold">{{ $book->author_name ?? 'Đang cập nhật' }}</span>
                            </span>
                            <span class="text-gray-300">|</span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i><span class="text-gray-500 ml-2 text-xs">({{ $book->avg_rating ?? '0' }}/5)</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-8 text-lg font-light italic line-clamp-3">
                        {{ $book->description ?? 'Chưa có mô tả ngắn.' }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-sm">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Nhà xuất bản</p>
                            <p class="font-bold text-brand-green">{{ $book->publisher ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Năm</p>
                            <p class="font-bold text-brand-green">{{ $book->published_year ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-400 text-xs mb-1 uppercase tracking-wide">Lượt xem</p>
                            <p class="font-bold text-brand-green">{{ number_format($book->view_count) }}</p>
                        </div>
                    </div>

                    <div class="mt-auto flex flex-col sm:flex-row gap-4 items-center">
                        <a href="#section-review" class="group flex items-center justify-center gap-2 px-8 py-3.5 rounded-full border-2 border-brand-green text-brand-green font-bold hover:bg-brand-green hover:text-white transition-all duration-300 min-w-[200px] shadow-sm hover:shadow-lg">
                            <i class="fas fa-book-open text-lg"></i>
                            <span>Đọc Review</span>
                        </a>
                        <a href="#" class="flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-brand-accent text-white font-bold shadow-lg hover:bg-[#c29263] hover:-translate-y-1 transition-all duration-300 min-w-[200px]">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Mua Sách Ngay</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================= --}}
        {{-- 2. MAIN CONTENT (GRID 2 CỘT: TRÁI 8 - PHẢI 4)                  --}}
        {{-- ============================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            {{-- A. CỘT CHÍNH (BÊN TRÁI - REVIEW CHI TIẾT & BÌNH LUẬN) --}}
            <div class="lg:col-span-8 space-y-12">
                
                {{-- [SECTION 1] BÀI REVIEW CHI TIẾT --}}
                <section id="section-review" class="scroll-mt-28">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <span class="w-1 h-8 bg-brand-green rounded-full"></span>
                            <h2 class="text-2xl font-bold text-gray-800 font-serif">Bài Review Chi Tiết</h2>
                        </div>
                        
                        @auth
                            <a href="{{ route('reviews.create') }}" class="flex items-center gap-2 px-5 py-2 bg-black text-white text-sm font-bold rounded-full hover:bg-gray-800 transition shadow-lg transform hover:-translate-y-0.5">
                                <i class="fas fa-pen-nib"></i> Viết Review
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-brand-green font-bold text-sm hover:underline flex items-center gap-1">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập để viết
                            </a>
                        @endauth
                    </div>

                    @php
                        // Lấy bài viết published mới nhất
                        $mainPost = $book->posts->where('status', 'published')->sortByDesc('created_at')->first();
                    @endphp

                    @if($mainPost)
                        <article class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4 font-serif leading-tight">{{ $mainPost->title }}</h1>
                            
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-6 bg-gray-50 p-3 rounded-lg w-fit">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($mainPost->user->name ?? 'Admin') }}&background=random&size=32" class="w-8 h-8 rounded-full">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800">{{ $mainPost->user->name ?? 'Quản trị viên' }}</span>
                                    <span class="text-xs">{{ $mainPost->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            @if(!empty($mainPost->thumbnail))
                                <div class="mb-8 rounded-2xl overflow-hidden shadow-sm aspect-[21/9]">
                                    <img src="{{ Str::startsWith($mainPost->thumbnail, 'http') ? $mainPost->thumbnail : asset('storage/' . $mainPost->thumbnail) }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endif

                            <div class="prose prose-stone prose-lg max-w-none text-gray-700 text-justify-last-left leading-relaxed">
                                {!! $mainPost->content !!}
                            </div>
                        </article>
                    @else
                        {{-- Trường hợp chưa có review nào --}}
                        <div class="bg-white p-12 rounded-2xl text-center border border-dashed border-gray-300 shadow-sm mb-6">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="fas fa-feather-alt text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Chưa có bài review chi tiết</h3>
                            <p class="text-gray-500 italic mb-4">Hãy là người đầu tiên chia sẻ cảm nhận sâu sắc về cuốn sách này!</p>
                            
                            @if(!empty($book->description))
                                <div class="mt-6 text-justify text-gray-600 bg-gray-50 p-6 rounded-xl border border-gray-100">
                                    <h4 class="font-bold text-sm mb-2 uppercase text-gray-400">Sơ lược nội dung:</h4>
                                    {!! nl2br(e($book->description)) !!}
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- NÚT XEM CÁC REVIEW KHÁC --}}
                    @if($book->posts->where('status', 'published')->count() > 0)
                        <div class="text-center border-t border-gray-100 pt-6">
                            <p class="text-gray-500 text-sm mb-3 italic">Bạn muốn đọc thêm các góc nhìn khác về cuốn sách này?</p>
                            <a href="{{ route('book.reviews', $book->slug ?? $book->id) }}" 
                               class="inline-flex items-center gap-2 px-8 py-3 bg-white border-2 border-brand-green text-brand-green font-bold rounded-full hover:bg-brand-green hover:text-white transition-all duration-300 shadow-sm group">
                                <span>Xem Các Bài Review Khác</span>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    @endif

                </section>

                {{-- [SECTION 2] BÌNH LUẬN CỘNG ĐỒNG --}}
                <section id="section-comments">
                    @php
                        $comments = collect();
                        if($book->posts->isNotEmpty()) {
                            foreach($book->posts as $post) {
                                if($post->comments->isNotEmpty()) {
                                    $comments = $comments->merge($post->comments);
                                }
                            }
                        }
                        $comments = $comments->sortByDesc('created_at');
                    @endphp

                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-1 h-8 bg-yellow-400 rounded-full"></span>
                        <h2 class="text-2xl font-bold text-gray-800 font-serif">Bình Luận Cộng Đồng</h2>
                        <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-1 rounded-md">
                            {{ $comments->count() }}
                        </span>
                    </div>

                    <div class="space-y-6">
                        @if($comments->count() > 0)
                            @foreach($comments as $comment)
                                {{-- THẺ CHA COMMENT CÓ ID ĐỂ SCROLL --}}
                                <div id="comment-{{ $comment->id }}" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'U') }}&background=random&size=48" 
                                                 class="w-10 h-10 rounded-full border border-gray-100">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-1">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-sm">{{ $comment->user->name ?? 'Người dùng' }}</h4>
                                                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line mt-2">
                                                {{ $comment->content }}
                                            </div>

                                            {{-- NÚT LIKE VÀ REPLY (CẬP NHẬT: REPLY INLINE) --}}
                                            <div class="mt-4 flex flex-col gap-3 border-t border-gray-50 pt-3">
                                                <div class="flex items-center gap-4">
                                                    {{-- Nút Like --}}
                                                    <button 
                                                        type="button"
                                                        onclick="handleLike({{ $comment->id }}, 'comment')" 
                                                        id="like-btn-comment-{{ $comment->id }}"
                                                        class="flex items-center gap-1.5 text-xs font-bold transition {{ Auth::check() && $comment->likes->where('user_id', Auth::id())->count() > 0 ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                                                        <i id="like-icon-comment-{{ $comment->id }}" class="{{ Auth::check() && $comment->likes->where('user_id', Auth::id())->count() > 0 ? 'fas' : 'far' }} fa-heart"></i>
                                                        <span id="like-count-comment-{{ $comment->id }}">{{ $comment->likes->count() }}</span> Thích
                                                    </button>

                                                    {{-- Nút Reply --}}
                                                    <button 
                                                        type="button"
                                                        onclick="toggleReplyForm({{ $comment->id }})" 
                                                        class="flex items-center gap-1.5 text-xs font-bold text-gray-400 hover:text-blue-500 transition">
                                                        <i class="far fa-comment-dots"></i> Trả lời
                                                    </button>
                                                </div>

                                                {{-- FORM REPLY (ẨN MẶC ĐỊNH - HIỆN KHI BẤM NÚT TRẢ LỜI) --}}
                                                <div id="reply-form-{{ $comment->id }}" class="hidden transition-all duration-300">
                                                    <div class="flex gap-2 items-start">
                                                        <img src="{{ Auth::check() ? (Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random') : 'https://ui-avatars.com/api/?name=Guest&background=gray' }}" 
                                                             class="w-8 h-8 rounded-full border border-gray-200 mt-1">
                                                        
                                                        <div class="flex-1">
                                                            <textarea id="reply-input-{{ $comment->id }}" 
                                                                      rows="1" 
                                                                      class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-green focus:bg-white transition resize-none overflow-hidden" 
                                                                      placeholder="Viết bình luận... (Enter để gửi)"
                                                                      oninput="autoResize(this)"
                                                                      onkeydown="handleEnter(event, {{ $comment->id }})"></textarea>
                                                            
                                                            <div class="flex justify-end mt-2 gap-2">
                                                                <button onclick="toggleReplyForm({{ $comment->id }})" class="text-xs text-gray-500 hover:text-gray-700 font-bold px-3 py-1.5">Hủy</button>
                                                                <button onclick="submitInlineReply({{ $comment->id }})" class="text-xs bg-brand-green text-white font-bold px-4 py-1.5 rounded-md hover:bg-[#1e3a2f] transition shadow-sm">Gửi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- KẾT THÚC FORM REPLY --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12 bg-stone-50 rounded-2xl border border-dashed border-stone-300">
                                <i class="far fa-comments text-4xl text-gray-300 mb-3 block"></i>
                                <p class="text-gray-500 text-sm">Chưa có bình luận nào. Hãy tham gia thảo luận ngay!</p>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            {{-- B. CỘT PHỤ (BÊN PHẢI - THÔNG TIN TÁC GIẢ) --}}
            <aside class="lg:col-span-4 space-y-8 ">
                
                {{-- [SECTION 3] CARD TÁC GIẢ --}}
                <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-6 text-center">
                    <h3 class="font-bold text-gray-500 text-xs uppercase tracking-widest mb-6">Thông Tin Tác Giả</h3>
                    
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($book->author_name ?? 'TG') }}&background=random&size=128" 
                             class="w-full h-full rounded-full object-cover border-4 border-stone-100 shadow-md">
                        <div class="absolute bottom-0 right-0 bg-brand-green text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white">TG</div>
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900 font-serif mb-2">
                        {{ $book->author_name ?? 'Tác giả' }}
                    </h2>
                    
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed px-2">
                        Theo dõi tác giả để nhận thông báo về những tác phẩm mới nhất và các sự kiện ra mắt sách.
                    </p>
                    
                    <button class="w-full py-3 bg-stone-100 hover:bg-brand-green hover:text-white text-gray-700 font-bold rounded-xl transition duration-300 flex items-center justify-center gap-2">
                        Xem Tác Phẩm Khác <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </div>

                {{-- Widget Gợi Ý --}}
                <div class="bg-brand-beige/20 rounded-2xl p-6 border border-brand-beige/50">
                    <h3 class="font-bold text-brand-green text-sm mb-4 flex items-center gap-2">
                        <i class="fas fa-lightbulb"></i> Có thể bạn thích
                    </h3>
                    <div class="space-y-4">
                        <div class="flex gap-3 items-center group cursor-pointer">
                            <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                <img src="https://via.placeholder.com/50x75" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-accent transition">Nhà Giả Kim</h4>
                                <span class="text-xs text-gray-500">Paulo Coelho</span>
                            </div>
                        </div>
                         <div class="flex gap-3 items-center group cursor-pointer">
                            <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                <img src="https://via.placeholder.com/50x75" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-brand-accent transition">Hoàng Tử Bé</h4>
                                <span class="text-xs text-gray-500">Saint-Exupéry</span>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>
        </div>
    </main>

    {{-- ĐÃ XÓA MODAL POPUP Ở ĐÂY --}}
@endsection

@push('scripts')
<script>
    const currentUserId = "{{ Auth::id() }}";

    // --- LOGIC CUỘN XUỐNG VÀ HIGHLIGHT COMMENT ---
    document.addEventListener("DOMContentLoaded", function() {
        if(window.location.hash) {
            const targetId = window.location.hash.substring(1); 
            const targetElement = document.getElementById(targetId);

            if(targetElement) {
                targetElement.scrollIntoView({ behavior: "smooth", block: "center" });
                targetElement.classList.add('bg-yellow-50', 'border-yellow-200'); // Highlight nhẹ
                setTimeout(() => {
                    targetElement.classList.remove('bg-yellow-50', 'border-yellow-200');
                }, 3000);
            }
        }
    });

    // --- LOGIC LIKE ---
    function handleLike(id, type) {
        if (!currentUserId) {
            alert("Vui lòng đăng nhập để thả tim!");
            window.location.href = "/login";
            return;
        }

        const btnId = `like-btn-${type}-${id}`;
        const iconId = `like-icon-${type}-${id}`;
        const countId = `like-count-${type}-${id}`;

        const btn = document.getElementById(btnId);
        const icon = document.getElementById(iconId);
        const countSpan = document.getElementById(countId);

        if (!btn) return;

        const isLiked = icon.classList.contains('fas'); 
        
        if(isLiked) {
            icon.classList.remove('fas', 'text-red-500');
            icon.classList.add('far');
            btn.classList.remove('text-red-500');
            btn.classList.add('text-gray-400');
            let currentCount = parseInt(countSpan.innerText);
            countSpan.innerText = Math.max(0, currentCount - 1);
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas', 'bounce', 'text-red-500');
            btn.classList.remove('text-gray-400');
            btn.classList.add('text-red-500');
            let currentCount = parseInt(countSpan.innerText);
            countSpan.innerText = currentCount + 1;
        }

        fetch('/like', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, type: type })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                countSpan.innerText = data.count;
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // --- LOGIC REPLY INLINE (MỚI) ---
    
    // 1. Ẩn/Hiện form nhập liệu
    function toggleReplyForm(commentId) {
        if (!currentUserId) {
            alert("Vui lòng đăng nhập để bình luận!");
            window.location.href = "/login";
            return;
        }
        
        const form = document.getElementById(`reply-form-${commentId}`);
        const input = document.getElementById(`reply-input-${commentId}`);
        
        if (form.classList.contains('hidden')) {
            // Đóng tất cả các form khác đang mở để gọn màn hình
            document.querySelectorAll('[id^="reply-form-"]').forEach(el => el.classList.add('hidden'));
            
            form.classList.remove('hidden');
            input.focus();
        } else {
            form.classList.add('hidden');
        }
    }

    // 2. Tự động chỉnh độ cao textarea khi gõ
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // 3. Xử lý bấm Enter để gửi
    function handleEnter(event, commentId) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault(); // Ngăn xuống dòng
            submitInlineReply(commentId);
        }
    }

    // 4. Gửi Reply qua AJAX -> Reload
    function submitInlineReply(commentId) {
        const input = document.getElementById(`reply-input-${commentId}`);
        const content = input.value.trim();

        if (!content) {
            alert("Nội dung không được để trống!");
            return;
        }

        fetch(`/comment/${commentId}/reply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tắt form và reload trang để hiện comment mới
                toggleReplyForm(commentId); 
                location.reload(); 
            } else {
                alert("Có lỗi xảy ra, vui lòng thử lại.");
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
<style>
    /* Animation nảy cho tim */
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    .bounce { animation: bounce 0.3s; }
</style>
@endpush