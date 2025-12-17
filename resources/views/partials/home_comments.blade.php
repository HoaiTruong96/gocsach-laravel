@if(isset($latestComments) && $latestComments->count() > 0)
    <div class="grid grid-cols-1 gap-5"> {{-- Danh sách dọc --}}
        @foreach($latestComments as $comment)
            @php
                $relatedBook = $comment->book ?? ($comment->post->book ?? null);
                $bookTitle = $relatedBook->title ?? 'Sách ẩn';
                $bookSlug = $relatedBook->slug ?? '#';
                $rating = $comment->rating ?? 0;
            @endphp

            {{-- ITEM COMMENT --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group cursor-pointer animate-fade-in"
                 onclick="window.location.href='{{ $relatedBook ? route('detail', $bookSlug) : '#' }}'">
                
                {{-- HEADER: User & Time --}}
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name ?? 'A').'&background=random&size=48' }}" 
                                 class="w-11 h-11 rounded-full border-2 border-white shadow-sm object-cover">
                            
                            @if($rating >= 4.5)
                                <span class="absolute -bottom-1 -right-1 bg-yellow-400 text-white text-[9px] w-4 h-4 flex items-center justify-center rounded-full border border-white shadow-sm">
                                    <i class="fas fa-crown"></i>
                                </span>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-sm text-gray-800 leading-tight group-hover:text-brand-green transition">
                                {{ $comment->user->name ?? 'Người dùng ẩn' }}
                            </h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <p class="text-[11px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                @if($rating > 0)
                                    <span class="text-gray-300 text-[10px]">•</span>
                                    <div class="flex text-yellow-400 text-[10px]">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOOK NAME --}}
                <div class="mb-3 pl-3 border-l-4 border-brand-accent">
                    <span class="text-xs text-gray-400 uppercase font-bold block mb-0.5">Đang review:</span>
                    <h3 class="text-base font-serif font-bold text-gray-800 line-clamp-1">
                        <a href="{{ $relatedBook ? route('detail', $bookSlug) : '#' }}" class="hover:text-brand-green hover:underline decoration-1 underline-offset-2">
                            {{ $bookTitle }}
                        </a>
                    </h3>
                </div>

                {{-- CONTENT --}}
                <div class="bg-gray-50 rounded-xl p-3 mb-3 text-gray-700 text-sm leading-relaxed relative">
                    <i class="fas fa-quote-left text-gray-200 absolute top-2 left-2 text-xl -z-0"></i>
                    <p class="relative z-10 line-clamp-3 pl-1">
                        {{ Str::limit(strip_tags($comment->content), 220) }}
                    </p>
                </div>

                {{-- FOOTER ACTIONS --}}
                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                    <div class="flex gap-2">
                        <button type="button" 
                                onclick="event.stopPropagation(); handleLike({{ $comment->id }}, 'comment')" 
                                id="like-btn-comment-{{ $comment->id }}" 
                                class="group/btn flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-red-50 transition {{ Auth::check() && $comment->likes->where('user_id', Auth::id())->count() > 0 ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">
                            <i id="like-icon-comment-{{ $comment->id }}" class="{{ Auth::check() && $comment->likes->where('user_id', Auth::id())->count() > 0 ? 'fas' : 'far' }} fa-heart text-sm transition-transform group-active/btn:scale-125"></i>
                            <span class="text-xs font-bold" id="like-count-comment-{{ $comment->id }}">{{ $comment->likes_count ?? 0 }}</span>
                        </button>

                        <button type="button" 
                                onclick="event.stopPropagation(); toggleReplyForm({{ $comment->id }})" 
                                class="group/btn flex items-center gap-1.5 px-3 py-1.5 rounded-full text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition">
                            <i class="far fa-comment-dots text-sm"></i>
                            <span class="text-xs font-bold">Trả lời</span>
                        </button>
                    </div>
                </div>

                {{-- FORM REPLY (Ẩn) --}}
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 pt-3 border-t border-gray-100 animate-fade-in" onclick="event.stopPropagation()">
                    <div class="flex gap-2 items-start">
                        <img src="{{ Auth::check() ? (Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random') : 'https://ui-avatars.com/api/?name=Guest' }}" 
                             class="w-8 h-8 rounded-full border border-gray-200">
                        <div class="flex-1 relative">
                            <textarea id="reply-input-{{ $comment->id }}" 
                                      rows="1" 
                                      class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-2 text-sm focus:outline-none focus:border-brand-green focus:ring-1 focus:ring-brand-green/20 transition resize-none pr-10" 
                                      placeholder="Viết bình luận..." 
                                      oninput="autoResize(this)" 
                                      onkeydown="handleEnter(event, {{ $comment->id }})"></textarea>
                            <button onclick="submitInlineReply({{ $comment->id }})" 
                                    class="absolute right-2 bottom-1.5 text-brand-green p-1.5 hover:bg-brand-green/10 rounded-full transition">
                                <i class="fas fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PHÂN TRANG --}}
    @if ($latestComments->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white px-1 py-1 rounded-full shadow-sm border border-gray-200 inline-flex items-center">
                @if (!$latestComments->onFirstPage())
                    <a href="{{ $latestComments->previousPageUrl() }}" class="ajax-pagination-link w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-green transition">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                @endif

                <span class="px-4 text-xs font-bold text-gray-600">Trang {{ $latestComments->currentPage() }}</span>

                @if ($latestComments->hasMorePages())
                    <a href="{{ $latestComments->nextPageUrl() }}" class="ajax-pagination-link w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-green transition">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif

@else
    <div class="flex flex-col items-center justify-center py-10 bg-white rounded-2xl border border-dashed border-gray-300 text-center">
        <div class="bg-gray-50 p-4 rounded-full mb-3 text-gray-400">
            <i class="far fa-comments text-3xl"></i>
        </div>
        <h3 class="text-gray-800 font-bold text-sm">Chưa có bình luận nào</h3>
        <p class="text-gray-500 text-xs mt-1">Hãy là người đầu tiên chia sẻ cảm nhận!</p>
    </div>
@endif