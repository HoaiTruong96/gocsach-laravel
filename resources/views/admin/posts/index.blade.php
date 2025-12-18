@extends('layouts.admin')
@section('title', 'Kiểm Duyệt Bài Đăng')
@section('header', 'Quản lý Đánh giá Sách')

@section('content')
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <div
            class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-700">
            <div class="flex gap-4">
                <span
                    class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 rounded-lg text-sm font-bold">
                    <i class="fas fa-clock mr-1"></i> {{ $reviews->where('status', 'pending')->count() }} Chờ duyệt
                </span>
                <span
                    class="px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-lg text-sm font-bold">
                    <i class="fas fa-check-circle mr-1"></i> {{ $reviews->where('status', 'published')->count() }} Đã đăng
                </span>
            </div>
            <span class="text-sm text-gray-500 dark:text-slate-400">Tổng cộng: {{ $reviews->total() }} bài</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400 text-xs uppercase border-b dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-3">Người viết & Sách</th>
                        <th class="px-6 py-3">Nội dung tóm tắt</th>
                        <th class="px-6 py-3 text-center">Đánh giá</th>
                        <th class="px-6 py-3 text-center">Trạng thái</th>
                        <th class="px-6 py-3 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach($reviews as $review)
                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-slate-700 {{ $review->status == 'pending' ? 'bg-yellow-50/50 dark:bg-yellow-900/10' : '' }} transition-colors">
                            <td class="px-6 py-4 align-top w-64">
                                <div class="flex items-start gap-3">
                                    <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . $review->user->name }}"
                                        class="w-8 h-8 rounded-full border dark:border-slate-600">
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $review->user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mb-1">
                                            {{ $review->created_at->diffForHumans() }}</p>
                                        <a href="{{ route('book.show', $review->book->slug ?? '#') }}"
                                            class="text-xs text-blue-600 dark:text-blue-400 hover:underline flex items-center"
                                            target="_blank">
                                            <i class="fas fa-book mr-1"></i>
                                            {{ Str::limit($review->book->title ?? 'Sách đã xóa', 20) }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <h4 class="font-bold text-gray-800 dark:text-white text-sm mb-1">{{ $review->title }}</h4>
                                <p class="text-gray-600 dark:text-slate-300 text-sm line-clamp-2 mb-2">
                                    {{ Str::limit(strip_tags($review->content), 100) }}</p>
                                <button type="button" 
                                        onclick="showReviewModal({{ $review->id }})"
                                        class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    <i class="fas fa-eye mr-1"></i> Xem chi tiết
                                </button>
                                
                                {{-- Hidden full content for modal --}}
                                <div id="review-content-{{ $review->id }}" class="hidden">
                                    <div class="review-title">{{ $review->title }}</div>
                                    <div class="review-user">{{ $review->user->name }}</div>
                                    <div class="review-book">{{ $review->book->title ?? 'Sách đã xóa' }}</div>
                                    <div class="review-rating">{{ $review->rating }}</div>
                                    <div class="review-date">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="review-content">{!! $review->content !!}</div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center align-top">
                                <div
                                    class="inline-block text-yellow-400 font-bold bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 rounded text-sm border border-yellow-100 dark:border-yellow-800">
                                    {{ $review->rating }} <i class="fas fa-star text-xs"></i>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center align-top">
                                @if($review->status == 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300">
                                        Chờ duyệt
                                    </span>
                                @elseif($review->status == 'published')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                        Hiển thị
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-600 text-gray-800 dark:text-slate-200">
                                        {{ $review->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right align-top">
                                <div class="flex flex-col gap-2 items-end">
                                    @if($review->status == 'pending')
                                        <form action="{{ route('admin.posts.update', $review->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="published">
                                            <button
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition w-24">
                                                <i class="fas fa-check mr-1"></i> Duyệt ngay
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.posts.update', $review->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button
                                                class="bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 px-3 py-1 rounded text-xs hover:bg-gray-300 dark:hover:bg-slate-500 transition w-24">
                                                <i class="fas fa-ban mr-1"></i> Từ chối
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.posts.destroy', $review->id) }}" method="POST"
                                            onsubmit="return confirm('Xóa vĩnh viễn bài review này?');">
                                            @csrf @method('DELETE')
                                            <button
                                                class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 px-3 py-1 rounded text-xs transition w-24 text-right">
                                                <i class="fas fa-trash mr-1"></i> Xóa bỏ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t dark:border-slate-700">
            {{ $reviews->links('vendor.pagination.admin') }}
        </div>
    </div>

    {{-- Modal Xem Chi Tiết Review --}}
    <div id="reviewModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" onclick="closeReviewModal(event)">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b dark:border-slate-700 bg-gray-50 dark:bg-slate-700">
                <div>
                    <h3 id="modal-title" class="text-xl font-bold text-gray-800 dark:text-white"></h3>
                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                        <span><i class="fas fa-user mr-1"></i> <span id="modal-user"></span></span>
                        <span><i class="fas fa-book mr-1"></i> <span id="modal-book"></span></span>
                        <span><i class="fas fa-calendar mr-1"></i> <span id="modal-date"></span></span>
                        <span class="text-yellow-500"><i class="fas fa-star mr-1"></i> <span id="modal-rating"></span>/5</span>
                    </div>
                </div>
                <button onclick="closeReviewModal()" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-600 hover:bg-gray-200 dark:hover:bg-slate-500 flex items-center justify-center transition">
                    <i class="fas fa-times text-gray-500 dark:text-slate-300"></i>
                </button>
            </div>
            
            {{-- Content --}}
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="modal-content" class="prose dark:prose-invert max-w-none text-gray-700 dark:text-slate-300 leading-relaxed"></div>
            </div>
            
            {{-- Footer --}}
            <div class="p-4 border-t dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-end gap-3">
                <button onclick="closeReviewModal()" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 font-medium hover:bg-gray-300 dark:hover:bg-slate-500 transition">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        function showReviewModal(reviewId) {
            const container = document.getElementById('review-content-' + reviewId);
            if (!container) return;
            
            document.getElementById('modal-title').textContent = container.querySelector('.review-title').textContent;
            document.getElementById('modal-user').textContent = container.querySelector('.review-user').textContent;
            document.getElementById('modal-book').textContent = container.querySelector('.review-book').textContent;
            document.getElementById('modal-rating').textContent = container.querySelector('.review-rating').textContent;
            document.getElementById('modal-date').textContent = container.querySelector('.review-date').textContent;
            document.getElementById('modal-content').innerHTML = container.querySelector('.review-content').innerHTML;
            
            document.getElementById('reviewModal').classList.remove('hidden');
            document.getElementById('reviewModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        function closeReviewModal(event) {
            if (event && event.target !== event.currentTarget) return;
            document.getElementById('reviewModal').classList.add('hidden');
            document.getElementById('reviewModal').classList.remove('flex');
            document.body.style.overflow = '';
        }
        
        // ESC key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeReviewModal();
        });
    </script>
@endsection