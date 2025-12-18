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
                                @elseif($review->status == 'rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                        Đã từ chối
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

                                        <!-- Nút mở modal từ chối -->
                                        <button type="button"
                                            onclick="openRejectModal({{ $review->id }}, '{{ addslashes($review->title) }}')"
                                            class="bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-200 px-3 py-1 rounded text-xs hover:bg-gray-300 dark:hover:bg-slate-500 transition w-24">
                                            <i class="fas fa-ban mr-1"></i> Từ chối
                                        </button>
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
    </script>
@endsection