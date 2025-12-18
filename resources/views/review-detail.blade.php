@extends('layouts.app')

@section('title', 'Tất Cả Đánh Giá - ' . $book->title)

@section('content')
    {{-- 1. HEADER NHỎ --}}
    <div class="bg-[#2A483A] text-white py-10 border-b border-brand-green-light relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-[80px] pointer-events-none"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <div class="flex items-center gap-2 text-white/60 text-xs mb-3 font-medium uppercase tracking-wider">
                        <a href="{{ route('home') }}" class="hover:text-white transition">Trang chủ</a>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <a href="{{ route('detail', $book->slug) }}" class="hover:text-white transition">Chi tiết sách</a>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span class="text-white">Đánh giá</span>
                    </div>
                    <h1 class="text-2xl md:text-4xl font-serif font-bold leading-tight mb-2">
                        {{ $book->title }}
                    </h1>
                    <div class="flex items-center gap-2 text-sm text-white/80">
                        <span>Tổng hợp đánh giá từ cộng đồng</span>
                    </div>
                </div>
                
                <a href="{{ route('detail', $book->slug) }}" class="group flex items-center gap-3 px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-full transition backdrop-blur-sm shadow-lg">
                    <div class="w-8 h-8 rounded-full bg-white text-brand-green flex items-center justify-center group-hover:-translate-x-1 transition-transform">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <span class="text-sm font-bold">Quay lại trang sách</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <main class="container mx-auto px-4 py-12 flex-grow min-h-[600px]">
        <div class="max-w-4xl mx-auto">
            
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 font-serif flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full bg-brand-green/10 flex items-center justify-center text-brand-green"><i class="fas fa-comments"></i></span>
                    Danh Sách Review ({{ $reviews->total() }})
                </h2>
                
                <a href="{{ route('detail', $book->slug) }}#section-review" class="inline-flex items-center gap-2 text-sm font-bold text-brand-accent hover:text-brand-brown hover:underline transition">
                    <i class="fas fa-pen"></i> Viết đánh giá mới
                </a>
            </div>

            <div class="space-y-6">
                @forelse($reviews as $review)
                    <div id="post-{{ $review->id }}" class="bg-white p-6 md:p-8 rounded-2xl shadow-soft border border-gray-100 hover:shadow-card transition duration-300 scroll-mt-24">
                        <div class="flex items-start gap-5">
                            <div class="flex-shrink-0">
                                <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=random&size=64&color=fff' }}" 
                                     class="w-12 h-12 rounded-full border-2 border-brand-beige shadow-sm object-cover">
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-base flex items-center">
                                            {{ $review->user->name }}
                                            @if($review->user)
                                                @include('partials.user-badges', ['user' => $review->user, 'size' => 'xs'])
                                            @endif
                                        </h4>
                                        <div class="flex items-center gap-3 mt-1">
                                            <div class="flex text-yellow-400 text-xs">
                                                @for($i=0; $i < round($review->rating); $i++) <i class="fas fa-star"></i> @endfor
                                                @for($i=0; $i < 5 - round($review->rating); $i++) <i class="far fa-star text-gray-300"></i> @endfor
                                            </div>
                                            <span class="text-gray-300 text-xs">•</span>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($review->title)
                                    <h3 class="font-bold text-brand-green text-lg mb-2">"{{ $review->title }}"</h3>
                                @endif
                                
                                {{-- [MỚI] Hiển thị ảnh Thumbnail của bài Review --}}
                                @if(!empty($review->thumbnail))
                                    <div class="mb-4 rounded-xl overflow-hidden shadow-sm border border-gray-100 max-w-lg">
                                        <img src="{{ \Illuminate\Support\Str::startsWith($review->thumbnail, 'http') ? $review->thumbnail : asset('storage/' . $review->thumbnail) }}" 
                                             class="w-full h-auto object-cover hover:scale-105 transition duration-700">
                                    </div>
                                @endif
                                
                                {{-- [SỬA] Dùng {!! !!} để render HTML từ CKEditor --}}
                                <div class="text-gray-600 text-sm leading-7 mb-4 text-justify prose prose-sm max-w-none">
                                    {!! $review->content !!}
                                </div>

                                <div class="flex items-center gap-6 pt-4 border-t border-gray-50">
                                    {{-- Nút Like --}}
                                    <button 
                                        type="button"
                                        onclick="handleLike({{ $review->id }}, 'post')" 
                                        id="like-btn-post-{{ $review->id }}"
                                        class="flex items-center gap-2 text-xs font-bold transition group {{ Auth::check() && $review->likes->where('user_id', Auth::id())->count() > 0 ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">
                                        <i id="like-icon-post-{{ $review->id }}" class="{{ Auth::check() && $review->likes->where('user_id', Auth::id())->count() > 0 ? 'fas' : 'far' }} fa-heart text-sm group-hover:bg-red-50 p-1.5 rounded-full"></i> 
                                        Thích (<span id="like-count-post-{{ $review->id }}">{{ $review->likes_count ?? 0 }}</span>)
                                    </button>

                                    {{-- Nút Bình luận --}}
                                    <button onclick="toggleComment({{ $review->id }})" class="flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-blue-500 transition group">
                                        <i class="far fa-comment-dots text-sm group-hover:bg-blue-50 p-1.5 rounded-full"></i> 
                                        Bình luận (<span id="comment-count-{{ $review->id }}">{{ $review->comments_count ?? 0 }}</span>)
                                    </button>
                                </div>

                                {{-- KHUNG BÌNH LUẬN --}}
                                <div id="comment-box-{{ $review->id }}" class="hidden mt-4 pt-4 border-t border-dashed border-gray-100 animate-fade-in-down">
                                    
                                    {{-- Danh sách bình luận cũ --}}
                                    @if($review->comments && $review->comments->count() > 0)
                                        <div class="space-y-3 mb-4 pl-4 border-l-2 border-gray-100">
                                            @foreach($review->comments as $comment)
                                                <div class="flex gap-3">
                                                    <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&size=32' }}" 
                                                         class="w-8 h-8 rounded-full mt-1 border border-white shadow-sm object-cover">
                                                    <div class="bg-gray-50 p-3 rounded-r-xl rounded-bl-xl text-xs w-full">
                                                        <div class="flex justify-between mb-1">
                                                            <span class="font-bold text-gray-800 flex items-center">
                                                                {{ $comment->user->name ?? 'Ẩn danh' }}
                                                                @if($comment->user)
                                                                    @include('partials.user-badges', ['user' => $comment->user, 'size' => 'xs', 'max' => 2])
                                                                @endif
                                                            </span>
                                                            <span class="text-gray-400 text-[10px]">{{ $comment->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <span class="text-gray-600 block leading-relaxed">{{ $comment->content }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Form bình luận AJAX --}}
                                    @auth
                                        <form data-comment-form data-review-id="{{ $review->id }}" 
                                              onsubmit="submitComment({{ $review->id }}, event)"
                                              class="flex gap-3 items-start mt-2">
                                            @csrf
                                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3E5F4E&color=fff' }}" 
                                                 class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                                            
                                            <div class="flex-1 relative group">
                                                <textarea name="content" rows="1" required
                                                          class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-2 pl-4 pr-10 text-sm focus:outline-none focus:border-brand-green focus:bg-white resize-none transition-all shadow-inner"
                                                          placeholder="Viết bình luận của bạn..."></textarea>
                                                <button type="submit" class="absolute right-2 top-1.5 text-gray-400 hover:text-brand-green p-1 transition-colors">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-center py-3 bg-gray-50 rounded-lg text-xs text-gray-500 border border-dashed border-gray-200">
                                            <a href="{{ route('login') }}" class="text-brand-green font-bold hover:underline">Đăng nhập</a> để tham gia thảo luận cùng mọi người.
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-comment-slash text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-600 mb-2">Chưa có đánh giá nào</h3>
                        <p class="text-gray-500 mb-6 text-sm">Hãy quay lại trang chi tiết sách để viết bài đầu tiên nhé.</p>
                        <a href="{{ route('detail', $book->slug) }}#section-review" class="inline-block bg-brand-green text-white px-6 py-2 rounded-lg font-bold shadow-sm hover:bg-brand-green-light transition">
                            Viết đánh giá ngay
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center">
                {{ $reviews->links() }}
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    const currentUserId = "{{ Auth::id() }}";

    // --- 1. Toggle Comment Box ---
    function toggleComment(reviewId) {
        const commentBox = document.getElementById(`comment-box-${reviewId}`);
        if (commentBox.classList.contains('hidden')) {
            commentBox.classList.remove('hidden');
            const textarea = commentBox.querySelector('textarea');
            if(textarea) setTimeout(() => textarea.focus(), 100);
        } else {
            commentBox.classList.add('hidden');
        }
    }

    // --- 2. Handle Like (AJAX) ---
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

        if (!btn || !icon || !countSpan) return;

        // Optimistic UI update
        const isLiked = icon.classList.contains('fas'); 
        
        if(isLiked) {
            icon.classList.remove('fas', 'text-red-500');
            icon.classList.add('far');
            btn.classList.remove('text-red-500');
            btn.classList.add('text-gray-500');
            let currentCount = parseInt(countSpan.innerText);
            countSpan.innerText = Math.max(0, currentCount - 1);
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas', 'bounce', 'text-red-500');
            btn.classList.remove('text-gray-500');
            btn.classList.add('text-red-500');
            let currentCount = parseInt(countSpan.innerText);
            countSpan.innerText = currentCount + 1;
        }

        // Send AJAX request
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

    // --- 3. Handle Comment Submit (AJAX) ---
    function submitComment(reviewId, event) {
        event.preventDefault();
        
        const form = event.target;
        const textarea = form.querySelector('textarea[name="content"]');
        const content = textarea.value.trim();

        if (!content) {
            alert("Nội dung bình luận không được để trống!");
            return;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch(`/posts/${reviewId}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update comment count
                const countSpan = document.getElementById(`comment-count-${reviewId}`);
                if (countSpan) countSpan.innerText = data.count;

                // Clear textarea
                textarea.value = '';

                // Reload to show new comment
                location.reload();
            } else {
                alert(data.error || "Có lỗi xảy ra, vui lòng thử lại.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Có lỗi xảy ra, vui lòng thử lại.");
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        });
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