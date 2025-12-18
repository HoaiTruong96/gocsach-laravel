@if(isset($latestReviews) && $latestReviews->count() > 0)
    <div class="grid grid-cols-1 gap-6"> 
        @foreach($latestReviews as $post)
            {{-- ITEM BÀI REVIEW (POST) --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                
                {{-- 1. HEADER --}}
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&background=random' }}" 
                             class="w-10 h-10 rounded-full object-cover border border-gray-200">
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">{{ $post->user->name }}</h4>
                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                <span>Đang review:</span>
                                <a href="{{ route('detail', $post->book->slug ?? '#') }}" class="font-bold text-brand-green hover:underline">
                                    {{ $post->book->title ?? 'Sách ẩn' }}
                                </a>
                                <span class="text-gray-300 mx-1">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. NỘI DUNG POST --}}
                <div class="mb-4 pl-1">
                    <h3 class="font-serif font-bold text-lg text-gray-800 mb-2 cursor-pointer hover:text-brand-green"
                        onclick="window.location.href='{{ route('detail', $post->book->slug ?? '#') }}'">
                        {{ $post->title }}
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-3 text-gray-700 text-sm leading-relaxed relative mb-3">
                         {{ Str::limit(strip_tags($post->content), 200) }}
                    </div>
                </div>

                {{-- 3. ACTIONS FOOTER bài Post --}}
                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                    <div class="flex gap-4">
                        <button onclick="handleLike({{ $post->id }}, 'post')" 
                                id="like-btn-post-{{ $post->id }}"
                                class="flex items-center gap-1 text-xs font-bold {{ Auth::check() && $post->likes->contains('user_id', Auth::id()) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }} transition">
                             <i id="like-icon-post-{{ $post->id }}" class="{{ Auth::check() && $post->likes->contains('user_id', Auth::id()) ? 'fas' : 'far' }} fa-heart"></i>
                             <span>Thích</span>
                             <span id="like-count-post-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
                        </button>

                        <button onclick="togglePostComments({{ $post->id }})" 
                                class="flex items-center gap-1 text-xs font-bold text-gray-500 hover:text-brand-green transition group">
                            <i class="far fa-comment-dots group-hover:scale-110 transition-transform"></i>
                            <span class="comment-count-{{ $post->id }}">Bình luận ({{ $post->comments_count ?? 0 }})</span>
                            <i id="chevron-{{ $post->id }}" class="fas fa-chevron-down text-[10px] ml-1 transition-transform duration-300"></i>
                        </button>
                    </div>
                </div>

                {{-- 4. KHUNG BÌNH LUẬN (ẨN/HIỆN) --}}
                <div id="comments-list-{{ $post->id }}" class="hidden mt-4 pt-4 border-t border-dashed border-gray-100 bg-gray-50/50 rounded-xl p-4 animate-fade-in">
                    
                    {{-- Ô NHẬP BÌNH LUẬN CHO POST --}}
                    <div class="flex gap-3 items-start mb-6">
                        <img src="{{ Auth::check() ? (Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random') : 'https://ui-avatars.com/api/?name=Guest' }}" 
                             class="w-8 h-8 rounded-full border border-gray-200 flex-shrink-0">
                        <div class="flex-1 relative">
                            <textarea id="post-comment-input-{{ $post->id }}" rows="1" 
                                      class="w-full text-xs p-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-brand-green resize-none pr-10 shadow-sm" 
                                      placeholder="Viết bình luận cho bài review này..."
                                      oninput="autoResize(this)"></textarea>
                            <button type="button" onclick="submitComment({{ $post->id }}, null, event)" 
                                    class="absolute right-2 top-1.5 text-brand-green p-1.5 hover:bg-brand-green/10 rounded-full transition">
                                <i class="fas fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </div>

                    {{-- DANH SÁCH CÁC BÌNH LUẬN CHA --}}
                    <div class="space-y-6">
                        @forelse($post->comments as $comment)
                            <div class="flex gap-3">
                                <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name).'&background=random' }}" 
                                     class="w-9 h-9 rounded-full border border-white shadow-sm flex-shrink-0">
                                
                                <div class="flex-1">
                                    <div class="bg-white p-3 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <h5 class="font-bold text-xs text-gray-800">{{ $comment->user->name }}</h5>
                                            <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-gray-600">{{ $comment->content }}</p>
                                    </div>

                                    {{-- ACTIONS CHO BÌNH LUẬN CHA --}}
                                    <div class="flex gap-3 mt-1 ml-2">
                                        <button onclick="handleLike({{ $comment->id }}, 'comment')" 
                                                id="like-btn-comment-{{ $comment->id }}"
                                                class="text-[10px] font-bold flex items-center gap-1 {{ Auth::check() && $comment->likes->contains('user_id', Auth::id()) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                                            <i id="like-icon-comment-{{ $comment->id }}" class="{{ Auth::check() && $comment->likes->contains('user_id', Auth::id()) ? 'fas' : 'far' }} fa-heart text-xs"></i>
                                            <span id="like-count-comment-{{ $comment->id }}">{{ $comment->likes->count() }}</span>
                                        </button>

                                        <button onclick="toggleReplySection({{ $comment->id }})" class="text-[10px] font-bold text-gray-400 hover:text-blue-500 transition">
                                            Trả lời ({{ $comment->replies->count() }})
                                        </button>
                                    </div>

                                    {{-- KHUNG REPLIES CỦA TỪNG COMMENT (MẶC ĐỊNH ẨN) --}}
                                    <div id="reply-section-{{ $comment->id }}" class="hidden mt-3 space-y-4 border-l-2 border-gray-100 pl-4 animate-fade-in">
                                        @foreach($comment->replies as $reply)
                                            <div class="flex gap-2">
                                                <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($reply->user->name).'&background=random' }}" 
                                                     class="w-7 h-7 rounded-full flex-shrink-0">
                                                <div class="flex-1">
                                                    <div class="bg-gray-100/50 p-2 rounded-xl rounded-tl-none border border-gray-50">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <h6 class="font-bold text-[10px] text-gray-700">{{ $reply->user->name }}</h6>
                                                            <span class="text-[9px] text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-[11px] text-gray-600">{{ $reply->content }}</p>
                                                    </div>
                                                    {{-- Like cho reply con --}}
                                                    <button onclick="handleLike({{ $reply->id }}, 'comment')" 
                                                            id="like-btn-comment-{{ $reply->id }}"
                                                            class="text-[9px] font-bold ml-2 mt-1 flex items-center gap-1 {{ Auth::check() && $reply->likes->contains('user_id', Auth::id()) ? 'text-red-500' : 'text-gray-400' }}">
                                                        <i id="like-icon-comment-{{ $reply->id }}" class="{{ Auth::check() && $reply->likes->contains('user_id', Auth::id()) ? 'fas' : 'far' }} fa-heart"></i>
                                                        <span id="like-count-comment-{{ $reply->id }}">{{ $reply->likes->count() }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach

                                        {{-- Ô NHẬP REPLY CON --}}
                                        <div class="flex gap-2 relative mt-2">
                                            <textarea id="reply-input-{{ $comment->id }}" rows="1" 
                                                      class="w-full text-xs p-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green resize-none shadow-sm" 
                                                      placeholder="Nhập câu trả lời..."></textarea>
                                            <button type="button" onclick="submitComment({{ $post->id }}, {{ $comment->id }}, event)" 
                                                    class="text-brand-green px-3 py-1 bg-brand-green/10 rounded-lg text-xs font-bold hover:bg-brand-green hover:text-white transition">Gửi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-xs text-gray-400 italic py-4">Chưa có bình luận nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PHÂN TRANG --}}
    @if ($latestReviews->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="inline-flex items-center bg-white rounded-full shadow-sm border border-gray-200 px-2 py-1">
                @if (!$latestReviews->onFirstPage())
                    <a href="{{ $latestReviews->previousPageUrl() }}" class="ajax-pagination-link p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-green transition mr-2">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </a>
                @endif
                @for($i = max(1, $latestReviews->currentPage() - 2); $i <= min($latestReviews->lastPage(), $latestReviews->currentPage() + 2); $i++)
                    @if($i == $latestReviews->currentPage())
                        <span class="px-3 py-1 rounded-full bg-brand-green text-white font-bold mx-1 text-xs">{{ $i }}</span>
                    @else
                        <a href="{{ $latestReviews->url($i) }}" class="ajax-pagination-link px-3 py-1 rounded-full text-gray-600 hover:bg-gray-100 transition mx-1 text-xs">{{ $i }}</a>
                    @endif
                @endfor
                @if ($latestReviews->hasMorePages())
                    <a href="{{ $latestReviews->nextPageUrl() }}" class="ajax-pagination-link p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-green transition ml-2">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                @endif
            </nav>
        </div>
    @endif
@else
    <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-200">
        <p class="text-gray-500 text-sm">Chưa có bài review nào.</p>
    </div>
@endif