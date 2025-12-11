@extends('layouts.admin')
@section('title', 'Tổng Quan Hệ Thống')
@section('header', 'Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div
        class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="font-bold text-gray-700"><i class="fas fa-filter mr-2 text-blue-500"></i>Bộ lọc thời gian</h3>
            <p class="text-xs text-gray-500">Xem chi tiết dữ liệu theo từng tháng cụ thể</p>
        </div>
        <div class="flex items-center gap-2" id="filter-controls">
            <select id="filter-month"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 cursor-pointer">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                @endfor
            </select>
            <select id="filter-year"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 cursor-pointer">
                @for($y = date('Y'); $y >= 2023; $y--)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>Năm {{ $y }}</option>
                @endfor
            </select>
            <div id="filter-loading" class="hidden">
                <i class="fas fa-spinner fa-spin text-blue-500"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-blue-500 text-sm font-bold uppercase tracking-wider mb-1">TỔNG BÀI REVIEW</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($totalReviews) }}</h3>
                <p class="text-gray-400 text-xs mt-2"><i class="fas fa-check-circle text-green-500 mr-1"></i> Đã xuất bản
                </p>
            </div>
            <i
                class="fas fa-file-alt absolute right-4 top-6 text-6xl text-blue-50 opacity-50 group-hover:scale-110 transition-transform"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-green-500 text-sm font-bold uppercase tracking-wider mb-1">TỔNG LƯỢT XEM</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($totalViews) }}</h3>
                <p class="text-gray-400 text-xs mt-2">Toàn hệ thống</p>
            </div>
            <i
                class="fas fa-eye absolute right-4 top-6 text-6xl text-green-50 opacity-50 group-hover:scale-110 transition-transform"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-yellow-500 text-sm font-bold uppercase tracking-wider mb-1">CHỜ DUYỆT</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($pendingReviews) }}</h3>
                <p class="text-gray-400 text-xs mt-2">Cần xử lý ngay</p>
            </div>
            <i
                class="fas fa-clipboard-list absolute right-4 top-6 text-6xl text-yellow-50 opacity-50 group-hover:scale-110 transition-transform"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-indigo-500 text-sm font-bold uppercase tracking-wider mb-1">THÀNH VIÊN</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($totalUsers) }}</h3>
                <p class="text-gray-400 text-xs mt-2">Đang hoạt động</p>
            </div>
            <i
                class="fas fa-users absolute right-4 top-6 text-6xl text-indigo-50 opacity-50 group-hover:scale-110 transition-transform"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h4 class="text-blue-600 font-bold mb-6">Biểu đồ phát triển (12 tháng qua)</h4>
            <div class="relative h-80 w-full"><canvas id="reviewChart"></canvas></div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-blue-50">
                <h4 class="text-blue-600 font-bold text-sm">Chi tiết theo tháng</h4>
            </div>
            <div class="overflow-y-auto max-h-[340px]">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-medium sticky top-0">
                        <tr>
                            <th class="px-4 py-3">Tháng</th>
                            <th class="px-4 py-3 text-right">Bài viết</th>
                            <th class="px-4 py-3 text-right">User mới</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($tableData as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $row['month'] }}</td>
                                <td class="px-4 py-3 text-right text-blue-600 font-bold">{{ $row['reviews'] }}</td>
                                <td class="px-4 py-3 text-right text-green-600">{{ $row['users'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <div id="reviews-container" class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            @include('admin.partials.dashboard-reviews', ['monthlyReviewsList' => $monthlyReviewsList, 'selectedMonth' => $selectedMonth, 'selectedYear' => $selectedYear])
        </div>

        <div id="users-container" class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            @include('admin.partials.dashboard-users', ['monthlyUsersList' => $monthlyUsersList, 'selectedMonth' => $selectedMonth, 'selectedYear' => $selectedYear])
        </div>
    </div>

    <script>
        // Chart initialization
        const ctx = document.getElementById('reviewChart').getContext('2d');
        const labels = @json($labels);
        const dataReviews = @json($dataReviews);
        const dataUsers = @json($dataViews);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Bài Review', data: dataReviews, borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 2, tension: 0.4, fill: true },
                    { label: 'Thành viên', data: dataUsers, borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.05)', borderWidth: 2, borderDash: [5, 5], tension: 0.4, fill: false }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true }, x: { grid: { display: false } } } }
        });

        // AJAX functionality for filter and pagination
        document.addEventListener('DOMContentLoaded', function () {
            const filterMonth = document.getElementById('filter-month');
            const filterYear = document.getElementById('filter-year');
            const filterLoading = document.getElementById('filter-loading');
            const reviewsContainer = document.getElementById('reviews-container');
            const usersContainer = document.getElementById('users-container');

            let currentReviewsPage = 1;
            let currentUsersPage = 1;

            // Show/hide loading indicator
            function showLoading() {
                filterLoading.classList.remove('hidden');
            }

            function hideLoading() {
                filterLoading.classList.add('hidden');
            }

            // Load reviews via AJAX
            function loadReviews(page = 1) {
                currentReviewsPage = page;
                const month = filterMonth.value;
                const year = filterYear.value;

                showLoading();

                fetch(`{{ route('admin.dashboard.reviews') }}?month=${month}&year=${year}&page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        reviewsContainer.innerHTML = html;
                        bindReviewsPagination();
                        hideLoading();
                    })
                    .catch(error => {
                        console.error('Error loading reviews:', error);
                        hideLoading();
                    });
            }

            // Load users via AJAX
            function loadUsers(page = 1) {
                currentUsersPage = page;
                const month = filterMonth.value;
                const year = filterYear.value;

                showLoading();

                fetch(`{{ route('admin.dashboard.users') }}?month=${month}&year=${year}&page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        usersContainer.innerHTML = html;
                        bindUsersPagination();
                        hideLoading();
                    })
                    .catch(error => {
                        console.error('Error loading users:', error);
                        hideLoading();
                    });
            }

            // Bind pagination click events for reviews
            function bindReviewsPagination() {
                reviewsContainer.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page') || 1;
                        loadReviews(page);
                    });
                });
            }

            // Bind pagination click events for users
            function bindUsersPagination() {
                usersContainer.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page') || 1;
                        loadUsers(page);
                    });
                });
            }

            // Filter change events - auto load both sections
            filterMonth.addEventListener('change', function () {
                currentReviewsPage = 1;
                currentUsersPage = 1;
                loadReviews(1);
                loadUsers(1);
                updateURL();
            });

            filterYear.addEventListener('change', function () {
                currentReviewsPage = 1;
                currentUsersPage = 1;
                loadReviews(1);
                loadUsers(1);
                updateURL();
            });

            // Update browser URL without reload
            function updateURL() {
                const month = filterMonth.value;
                const year = filterYear.value;
                const newUrl = `{{ route('admin.dashboard') }}?month=${month}&year=${year}`;
                window.history.pushState({}, '', newUrl);
            }

            // Initial binding
            bindReviewsPagination();
            bindUsersPagination();
        });
    </script>
@endsection