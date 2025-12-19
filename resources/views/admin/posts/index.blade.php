@extends('layouts.admin')
@section('title', 'Kiểm Duyệt Bài Đăng')
@section('header', 'Quản lý Đánh giá Sách')

@section('content')
    <div id="posts-container"
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">

        {{-- AJAX Tabs lọc theo trạng thái --}}
        <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700">
            <div class="flex flex-wrap gap-2" id="status-tabs">
                <button type="button" data-status=""
                    class="ajax-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap {{ !request('status') ? 'bg-blue-600 text-white shadow-md' : 'bg-white dark:bg-slate-600 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-500 border border-gray-200 dark:border-slate-500' }}">
                    <i class="fas fa-list mr-1"></i> Tất cả
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded text-xs font-bold {{ !request('status') ? 'bg-white/20' : 'bg-slate-200 dark:bg-slate-500 text-slate-600 dark:text-slate-200' }}"
                        id="count-all">{{ \App\Models\Post::whereNotNull('book_id')->count() }}</span>
                </button>
                <button type="button" data-status="pending"
                    class="ajax-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap {{ request('status') == 'pending' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white dark:bg-slate-600 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-500 border border-gray-200 dark:border-slate-500' }}">
                    <i class="fas fa-clock mr-1"></i> Chờ duyệt
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded text-xs font-bold {{ request('status') == 'pending' ? 'bg-white/20' : 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300' }}"
                        id="count-pending">{{ \App\Models\Post::whereNotNull('book_id')->where('status', 'pending')->count() }}</span>
                </button>
                <button type="button" data-status="published"
                    class="ajax-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap {{ request('status') == 'published' ? 'bg-green-500 text-white shadow-md' : 'bg-white dark:bg-slate-600 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-500 border border-gray-200 dark:border-slate-500' }}">
                    <i class="fas fa-check-circle mr-1"></i> Đã đăng
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded text-xs font-bold {{ request('status') == 'published' ? 'bg-white/20' : 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' }}"
                        id="count-published">{{ \App\Models\Post::whereNotNull('book_id')->where('status', 'published')->count() }}</span>
                </button>
                <button type="button" data-status="hidden"
                    class="ajax-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap {{ request('status') == 'hidden' ? 'bg-gray-500 text-white shadow-md' : 'bg-white dark:bg-slate-600 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-500 border border-gray-200 dark:border-slate-500' }}">
                    <i class="fas fa-eye-slash mr-1"></i> Đang ẩn
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded text-xs font-bold {{ request('status') == 'hidden' ? 'bg-white/20' : 'bg-gray-200 dark:bg-slate-500 text-gray-600 dark:text-slate-300' }}"
                        id="count-hidden">{{ \App\Models\Post::whereNotNull('book_id')->where('status', 'hidden')->count() }}</span>
                </button>
                <button type="button" data-status="rejected"
                    class="ajax-tab px-4 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap {{ request('status') == 'rejected' ? 'bg-red-500 text-white shadow-md' : 'bg-white dark:bg-slate-600 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-500 border border-gray-200 dark:border-slate-500' }}">
                    <i class="fas fa-ban mr-1"></i> Từ chối
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded text-xs font-bold {{ request('status') == 'rejected' ? 'bg-white/20' : 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300' }}"
                        id="count-rejected">{{ \App\Models\Post::whereNotNull('book_id')->where('status', 'rejected')->count() }}</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400 text-xs uppercase border-b dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap">Người viết & Sách</th>
                        <th class="px-6 py-3 whitespace-nowrap">Nội dung tóm tắt</th>
                        <th class="px-6 py-3 text-center whitespace-nowrap">Đánh giá</th>
                        <th class="px-6 py-3 text-center whitespace-nowrap">Trạng thái</th>
                        <th class="px-6 py-3 text-center whitespace-nowrap">Hành động</th>
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
                                            {{ $review->created_at->diffForHumans() }}
                                        </p>
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
                                <p class="text-gray-600 dark:text-slate-300 text-sm line-clamp-2">
                                    {{ Str::limit(strip_tags($review->content), 100) }}
                                </p>

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
                                    class="inline-flex items-center gap-1 text-yellow-500 font-bold bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 rounded text-sm border border-yellow-100 dark:border-yellow-800 whitespace-nowrap">
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
                                @elseif($review->status == 'rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                        Đã từ chối
                                    </span>
                                @elseif($review->status == 'hidden')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-600 text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                        Đang ẩn
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-600 text-gray-800 dark:text-slate-200">
                                        {{ $review->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right align-top">
                                <div class="flex justify-end gap-2">
                                    @if($review->status == 'pending')
                                        <form action="{{ route('admin.posts.update', $review->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="published">
                                            <button
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-600 hover:text-white transition"
                                                title="Duyệt bài">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>

                                        <!-- Nút mở modal từ chối -->
                                        <button type="button"
                                            onclick="openRejectModal({{ $review->id }}, '{{ addslashes($review->title) }}')"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-300 hover:bg-gray-500 hover:text-white transition"
                                            title="Từ chối">
                                            <i class="fas fa-ban text-xs"></i>
                                        </button>
                                    @else
                                        {{-- Bài đã published: có thể ẩn --}}
                                        @if($review->status == 'published')
                                            <form action="{{ route('admin.posts.update', $review->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="hidden">
                                                <button
                                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-slate-400 hover:bg-gray-500 hover:text-white transition"
                                                    title="Ẩn bài viết">
                                                    <i class="fas fa-eye-slash text-xs"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Bài đang ẩn: có thể hiện lại --}}
                                        @if($review->status == 'hidden')
                                            <form action="{{ route('admin.posts.update', $review->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="published">
                                                <button
                                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-600 hover:text-white transition"
                                                    title="Hiện lại bài viết">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.posts.destroy', $review->id) }}" method="POST"
                                            onsubmit="return confirm('Xóa vĩnh viễn bài review này?');">
                                            @csrf @method('DELETE')
                                            <button
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-600 hover:text-white transition"
                                                title="Xóa bài viết">
                                                <i class="fas fa-trash text-xs"></i>
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

    <!-- Modal Từ Chối Bài Viết -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeRejectModal()"></div>

        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-md transform transition-all">
                <!-- Header -->
                <div class="bg-red-500 text-white px-6 py-4 rounded-t-xl flex justify-between items-center">
                    <h3 class="font-bold text-lg">
                        <i class="fas fa-ban mr-2"></i>Từ Chối Bài Viết
                    </h3>
                    <button onclick="closeRejectModal()" class="text-white/70 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Body -->
                <form id="rejectForm" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="rejected">

                    <div class="p-6">
                        <p class="text-sm text-gray-600 dark:text-slate-300 mb-4">
                            Bạn đang từ chối bài viết: <strong id="rejectPostTitle"
                                class="text-gray-800 dark:text-white"></strong>
                        </p>

                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-200 mb-3">
                            <i class="fas fa-clipboard-list mr-1"></i> Chọn lý do từ chối:
                        </label>

                        <!-- Các lý do có sẵn -->
                        <div class="space-y-2 mb-4">
                            <label
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                                <input type="radio" name="rejection_reason" value="Nội dung không liên quan đến sách"
                                    class="text-red-500 focus:ring-red-500">
                                <span class="text-sm text-gray-700 dark:text-slate-200">Nội dung không liên quan đến
                                    sách</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                                <input type="radio" name="rejection_reason" value="Nội dung vi phạm quy tắc cộng đồng"
                                    class="text-red-500 focus:ring-red-500">
                                <span class="text-sm text-gray-700 dark:text-slate-200">Vi phạm quy tắc cộng đồng</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                                <input type="radio" name="rejection_reason" value="Nội dung spam hoặc quảng cáo"
                                    class="text-red-500 focus:ring-red-500">
                                <span class="text-sm text-gray-700 dark:text-slate-200">Spam hoặc quảng cáo</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                                <input type="radio" name="rejection_reason" value="Nội dung quá ngắn hoặc không đầy đủ"
                                    class="text-red-500 focus:ring-red-500">
                                <span class="text-sm text-gray-700 dark:text-slate-200">Nội dung quá ngắn hoặc không đầy
                                    đủ</span>
                            </label>

                            <label
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                                <input type="radio" name="rejection_reason" value="Ngôn từ không phù hợp"
                                    class="text-red-500 focus:ring-red-500">
                                <span class="text-sm text-gray-700 dark:text-slate-200">Ngôn từ không phù hợp</span>
                            </label>

                            <!-- Tùy chọn Khác -->
                            <label
                                class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                                <input type="radio" name="rejection_reason" value="other" id="otherReasonRadio"
                                    class="text-red-500 focus:ring-red-500" onchange="toggleCustomReason()">
                                <span class="text-sm text-gray-700 dark:text-slate-200">Khác (nhập lý do)</span>
                            </label>
                        </div>

                        <!-- Ô nhập lý do tùy chỉnh -->
                        <div id="customReasonContainer" class="hidden">
                            <textarea name="custom_reason" id="customReasonInput" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-slate-700 dark:text-white text-sm"
                                placeholder="Nhập lý do từ chối cụ thể..."></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700 rounded-b-xl flex justify-end gap-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-500 transition text-sm font-bold">
                            Hủy
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-bold">
                            <i class="fas fa-ban mr-1"></i> Xác nhận từ chối
                        </button>
                    </div>
                </form>
                {{-- Modal Xem Chi Tiết Review --}}
                <div id="reviewModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4"
                    onclick="closeReviewModal(event)">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden"
                        onclick="event.stopPropagation()">
                        {{-- Header --}}
                        <div
                            class="flex items-center justify-between p-6 border-b dark:border-slate-700 bg-gray-50 dark:bg-slate-700">
                            <div>
                                <h3 id="modal-title" class="text-xl font-bold text-gray-800 dark:text-white"></h3>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500 dark:text-slate-400">
                                    <span><i class="fas fa-user mr-1"></i> <span id="modal-user"></span></span>
                                    <span><i class="fas fa-book mr-1"></i> <span id="modal-book"></span></span>
                                    <span><i class="fas fa-calendar mr-1"></i> <span id="modal-date"></span></span>
                                    <span class="text-yellow-500"><i class="fas fa-star mr-1"></i> <span
                                            id="modal-rating"></span>/5</span>
                                </div>
                            </div>
                            <button onclick="closeReviewModal()"
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-600 hover:bg-gray-200 dark:hover:bg-slate-500 flex items-center justify-center transition">
                                <i class="fas fa-times text-gray-500 dark:text-slate-300"></i>
                            </button>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 overflow-y-auto max-h-[60vh]">
                            <div id="modal-content"
                                class="prose dark:prose-invert max-w-none text-gray-700 dark:text-slate-300 leading-relaxed">
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="p-4 border-t dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-end gap-3">
                            <button onclick="closeReviewModal()"
                                class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 font-medium hover:bg-gray-300 dark:hover:bg-slate-500 transition">
                                Đóng
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function openRejectModal(postId, postTitle) {
                        const modal = document.getElementById('rejectModal');
                        const form = document.getElementById('rejectForm');
                        const titleEl = document.getElementById('rejectPostTitle');

                        // Set form action
                        form.action = `/admin/posts/${postId}`;
                        titleEl.textContent = postTitle;

                        // Reset form
                        form.reset();
                        document.getElementById('customReasonContainer').classList.add('hidden');

                        // Show modal
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeRejectModal() {
                        const modal = document.getElementById('rejectModal');
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }

                    function toggleCustomReason() {
                        const container = document.getElementById('customReasonContainer');
                        const otherRadio = document.getElementById('otherReasonRadio');

                        if (otherRadio.checked) {
                            container.classList.remove('hidden');
                            document.getElementById('customReasonInput').focus();
                        } else {
                            container.classList.add('hidden');
                        }
                    }

                    // Đóng modal khi nhấn ESC
                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape') {
                            closeRejectModal();
                        }
                    });

                    // Xử lý form submit để gửi custom reason
                    document.getElementById('rejectForm').addEventListener('submit', function (e) {
                        const otherRadio = document.getElementById('otherReasonRadio');
                        const customInput = document.getElementById('customReasonInput');

                        if (otherRadio.checked && customInput.value.trim()) {
                            // Thay đổi giá trị radio sang custom reason
                            otherRadio.value = customInput.value.trim();
                        }
                    });

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

                    // ========== AJAX TABS ==========
                    let currentStatus = '{{ request('status') ?? '' }}';

                    function bindAjaxTabs() {
                        document.querySelectorAll('.ajax-tab').forEach(tab => {
                            tab.addEventListener('click', function () {
                                const status = this.dataset.status;
                                currentStatus = status;
                                loadPosts();
                                updateTabStyles(status);
                            });
                        });
                    }

                    function updateTabStyles(activeStatus) {
                        document.querySelectorAll('.ajax-tab').forEach(tab => {
                            const status = tab.dataset.status;
                            const isActive = status === activeStatus;

                            tab.classList.remove(
                                'bg-blue-600', 'bg-yellow-500', 'bg-green-500', 'bg-gray-500', 'bg-red-500',
                                'text-white', 'shadow-md',
                                'bg-white', 'dark:bg-slate-600', 'text-gray-600', 'dark:text-slate-300',
                                'hover:bg-gray-100', 'dark:hover:bg-slate-500', 'border', 'border-gray-200', 'dark:border-slate-500'
                            );

                            if (isActive) {
                                if (status === '') tab.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                                else if (status === 'pending') tab.classList.add('bg-yellow-500', 'text-white', 'shadow-md');
                                else if (status === 'published') tab.classList.add('bg-green-500', 'text-white', 'shadow-md');
                                else if (status === 'hidden') tab.classList.add('bg-gray-500', 'text-white', 'shadow-md');
                                else if (status === 'rejected') tab.classList.add('bg-red-500', 'text-white', 'shadow-md');
                            } else {
                                tab.classList.add('bg-white', 'dark:bg-slate-600', 'text-gray-600', 'dark:text-slate-300',
                                    'hover:bg-gray-100', 'dark:hover:bg-slate-500', 'border', 'border-gray-200', 'dark:border-slate-500');
                            }

                            const countBadge = tab.querySelector('span');
                            if (countBadge) {
                                countBadge.classList.remove('bg-white/20', 'bg-slate-200', 'dark:bg-slate-500', 'text-slate-600', 'dark:text-slate-200',
                                    'bg-yellow-100', 'dark:bg-yellow-900/50', 'text-yellow-700', 'dark:text-yellow-300',
                                    'bg-green-100', 'dark:bg-green-900/50', 'text-green-700', 'dark:text-green-300',
                                    'bg-gray-200', 'text-gray-600', 'bg-red-100', 'dark:bg-red-900/50', 'text-red-700', 'dark:text-red-300');

                                if (isActive) {
                                    countBadge.classList.add('bg-white/20');
                                } else {
                                    if (status === '') countBadge.classList.add('bg-slate-200', 'dark:bg-slate-500', 'text-slate-600', 'dark:text-slate-200');
                                    else if (status === 'pending') countBadge.classList.add('bg-yellow-100', 'dark:bg-yellow-900/50', 'text-yellow-700', 'dark:text-yellow-300');
                                    else if (status === 'published') countBadge.classList.add('bg-green-100', 'dark:bg-green-900/50', 'text-green-700', 'dark:text-green-300');
                                    else if (status === 'hidden') countBadge.classList.add('bg-gray-200', 'dark:bg-slate-500', 'text-gray-600', 'dark:text-slate-300');
                                    else if (status === 'rejected') countBadge.classList.add('bg-red-100', 'dark:bg-red-900/50', 'text-red-700', 'dark:text-red-300');
                                }
                            }
                        });
                    }

                    function loadPosts() {
                        const container = document.getElementById('posts-container');

                        const url = new URL(window.location.href);
                        url.searchParams.delete('page');
                        if (currentStatus) {
                            url.searchParams.set('status', currentStatus);
                        } else {
                            url.searchParams.delete('status');
                        }

                        fetch(url.toString(), {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContainer = doc.getElementById('posts-container');

                                if (newContainer) {
                                    container.innerHTML = newContainer.innerHTML;
                                }

                                history.pushState({}, '', url.toString());
                                bindAjaxTabs();
                            })
                            .catch(error => {
                                console.error('Error loading posts:', error);
                            });
                    }

                    // Init
                    bindAjaxTabs();

                    // ESC key to close modals
                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape') {
                            closeRejectModal();
                            closeReviewModal();
                        }
                    });
                </script>
@endsection