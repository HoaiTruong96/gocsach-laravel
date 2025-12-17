@if(isset($latestComments) && $latestComments->count() > 0)
    @foreach($latestComments as $comment) 
        @php
            $relatedBook = $comment->book ?? ($comment->post->book ?? null);
            $bookTitle = $relatedBook->title ?? 'Sách ẩn';
            $bookSlug = $relatedBook->slug ?? '#';
            $rating = $comment->rating ?? 0;
        @endphp

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 flex flex-col h-full group cursor-pointer animate-fade-in" 
             onclick="window.location.href='{{ $relatedBook ? route('detail', $bookSlug) : '#' }}'">
            
            <div class="flex justify-between items-start mb-3">
                <div class="flex items-center gap-3">
                    <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name ?? 'A').'&background=random' }}" class="w-10 h-10 rounded-full border border-gray-100 shadow-sm object-cover">
                    <div>
                        <span class="font-bold text-sm text-gray-800 line-clamp-1 hover:text-brand-green hover:underline z-10 relative">{{ $comment->user->name ?? 'Người dùng ẩn' }}</span>
                        <p class="text-[10px] text-gray-400 flex items-center gap-1"><i class="far fa-clock"></i> {{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if($rating > 0)
                    <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded text-xs font-bold text-yellow-600 border border-yellow-100">
                        <span>{{ $rating }}</span> <i class="fas fa-star text-[10px]"></i>
                    </div>
                @endif
            </div>

            <div class="mb-3 flex-grow">
                <h5 class="text-sm font-bold text-gray-700 mb-1 group-hover:text-brand-green transition">Review: <span class="italic font-serif text-brand-green text-base">"{{ $bookTitle }}"</span></h5>
                <p class="text-gray-600 text-sm line-clamp-2 md:line-clamp-3 leading-relaxed">{{ Str::limit(strip_tags($comment->content), 200) }}</p>
            </div>

            <div class="mt-auto pt-3 border-t border-gray-50">
                <div class="flex justify-between items-center">
                    <div class="flex gap-4 text-xs text-gray-400 font-medium">
                        {{-- NÚT LIKE --}}
                        <button type="button" onclick="event.stopPropagation(); handleLike({{ $comment->id }}, 'comment')" id="like-btn-comment-{{ $comment->id }}" class="flex items-center gap-1.5 transition z-20 relative {{ Auth::check() && $comment->likes->where('user_id', Auth::id())->count() > 0 ? 'text-red-500' : 'hover:text-red-500' }}">
                            <i id="like-icon-comment-{{ $comment->id }}" class="{{ Auth::check() && $comment->likes->where('user_id', Auth::id())->count() > 0 ? 'fas' : 'far' }} fa-heart"></i>
                            <span id="like-count-comment-{{ $comment->id }}">{{ $comment->likes_count ?? 0 }}</span> Thích
                        </button>
                        {{-- NÚT REPLY --}}
                        <button type="button" onclick="event.stopPropagation(); toggleReplyForm({{ $comment->id }})" class="flex items-center gap-1.5 hover:text-blue-500 transition z-20 relative">
                            <i class="far fa-comment-dots"></i> Bình luận
                        </button>
                    </div>
                </div>

                {{-- FORM REPLY --}}
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 transition-all duration-300 z-20 relative" onclick="event.stopPropagation()">
                    <div class="flex gap-2">
                        <img src="{{ Auth::check() ? (Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random') : 'https://ui-avatars.com/api/?name=Guest&background=gray' }}" class="w-8 h-8 rounded-full border border-gray-200">
                        <div class="flex-1">
                            <textarea id="reply-input-{{ $comment->id }}" rows="1" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-green focus:bg-white transition resize-none overflow-hidden" placeholder="Viết bình luận... (Enter để gửi)" oninput="autoResize(this)" onkeydown="handleEnter(event, {{ $comment->id }})"></textarea>
                            <div class="flex justify-end mt-1 gap-2">
                                <button onclick="toggleReplyForm({{ $comment->id }})" class="text-xs text-gray-500 hover:text-gray-700 font-bold px-2 py-1">Hủy</button>
                                <button onclick="submitInlineReply({{ $comment->id }})" class="text-xs bg-brand-green text-white font-bold px-3 py-1 rounded hover:bg-[#1e3a2f] transition">Gửi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- PHÂN TRANG --}}
    @if ($latestComments->hasPages())
        <div class="mt-10 flex justify-center">
             {{ $latestComments->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @endif
@else
    <div class="col-span-full py-12 text-center bg-white rounded-xl border border-dashed border-gray-300">
        <i class="far fa-comments text-4xl text-gray-300 mb-3"></i>
        <p class="text-gray-500">Chưa có bình luận nào mới.</p>
    </div>
@endif