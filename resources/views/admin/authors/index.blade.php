@extends('layouts.admin')
@section('title', 'Quản Lý Tác Giả')
@section('header', 'Quản Lý Tác Giả')

@section('content')
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        {{-- Header with Tabs and Actions --}}
        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
                <div>
                    <h2 class="font-bold text-gray-800 dark:text-white text-lg">Danh sách Tác Giả</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                        "Chưa đăng ký" = Tác giả có trong sách nhưng chưa được thêm vào hệ thống
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Reset Filter --}}
                    <button onclick="resetSort()" id="reset-btn"
                        class="hidden w-9 h-9 rounded-lg bg-gray-200 dark:bg-slate-500 text-gray-700 dark:text-white hover:bg-red-100 dark:hover:bg-red-900/50 hover:text-red-600 transition items-center justify-center"
                        title="Reset bộ lọc">
                        <i class="fas fa-undo"></i>
                    </button>

                    {{-- Button giống Banner --}}
                    <a href="{{ route('admin.authors.create') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm shadow-sm transition flex items-center gap-2">
                        <i class="fas fa-plus"></i> Thêm mới
                    </a>
                </div>
            </div>

            {{-- Tabs với hover đã sửa --}}
            <div class="flex flex-wrap gap-2" id="author-tabs">
                <button onclick="switchTab('all')" data-tab="all"
                    class="tab-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $tab === 'all' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <i class="fas fa-users mr-1"></i> Tất cả
                    <span
                        class="ml-1 px-1.5 py-0.5 {{ $tab === 'all' ? 'bg-white/20' : 'bg-gray-200 dark:bg-slate-600' }} rounded text-xs">{{ $stats['total'] }}</span>
                </button>
                <button onclick="switchTab('registered')" data-tab="registered"
                    class="tab-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $tab === 'registered' ? 'bg-green-600 text-white shadow-md' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-green-100 dark:hover:bg-green-900/30 hover:text-green-600 dark:hover:text-green-400' }}">
                    <i class="fas fa-check-circle mr-1"></i> Đã đăng ký
                    <span
                        class="ml-1 px-1.5 py-0.5 {{ $tab === 'registered' ? 'bg-white/20' : 'bg-gray-200 dark:bg-slate-600' }} rounded text-xs">{{ $stats['registered'] }}</span>
                </button>
                <button onclick="switchTab('unregistered')" data-tab="unregistered"
                    class="tab-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $tab === 'unregistered' ? 'bg-amber-500 text-white shadow-md' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-amber-100 dark:hover:bg-amber-900/30 hover:text-amber-600 dark:hover:text-amber-400' }}">
                    <i class="fas fa-exclamation-circle mr-1"></i> Chưa đăng ký
                    <span
                        class="ml-1 px-1.5 py-0.5 {{ $tab === 'unregistered' ? 'bg-white/20' : 'bg-gray-200 dark:bg-slate-600' }} rounded text-xs">{{ $stats['unregistered'] }}</span>
                </button>
            </div>
        </div>

        {{-- Table Container (for AJAX reload like Books) --}}
        <div id="authors-table-container">
            @include('admin.authors.table')
        </div>
    </div>

    <script>
        // ===== AJAX Tab Switching =====
        function switchTab(tab) {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            url.searchParams.delete('page');

            // Show loading
            const container = document.getElementById('authors-table-container');
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';

            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                    container.style.pointerEvents = 'auto';

                    // Update tab styles
                    updateTabStyles(tab);

                    // Update URL
                    window.history.pushState({}, '', url.toString());
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.style.opacity = '1';
                    container.style.pointerEvents = 'auto';
                    window.location.href = url.toString();
                });
        }

        function updateTabStyles(activeTab) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                const btnTab = btn.dataset.tab;
                const isActive = btnTab === activeTab;
                const countBadge = btn.querySelector('span');

                // Remove all active classes
                btn.classList.remove(
                    'bg-blue-600', 'bg-green-600', 'bg-amber-500', 'text-white', 'shadow-md',
                    'bg-gray-100', 'dark:bg-slate-700', 'text-gray-600', 'dark:text-slate-300',
                    'hover:bg-blue-100', 'dark:hover:bg-blue-900/30', 'hover:text-blue-600', 'dark:hover:text-blue-400',
                    'hover:bg-green-100', 'dark:hover:bg-green-900/30', 'hover:text-green-600', 'dark:hover:text-green-400',
                    'hover:bg-amber-100', 'dark:hover:bg-amber-900/30', 'hover:text-amber-600', 'dark:hover:text-amber-400'
                );

                if (countBadge) {
                    countBadge.classList.remove('bg-white/20', 'bg-gray-200', 'dark:bg-slate-600');
                }

                if (isActive) {
                    btn.classList.add('text-white', 'shadow-md');
                    if (countBadge) countBadge.classList.add('bg-white/20');

                    if (btnTab === 'all') btn.classList.add('bg-blue-600');
                    else if (btnTab === 'registered') btn.classList.add('bg-green-600');
                    else if (btnTab === 'unregistered') btn.classList.add('bg-amber-500');
                } else {
                    btn.classList.add('bg-gray-100', 'dark:bg-slate-700', 'text-gray-600', 'dark:text-slate-300');
                    if (countBadge) countBadge.classList.add('bg-gray-200', 'dark:bg-slate-600');

                    if (btnTab === 'all') {
                        btn.classList.add('hover:bg-blue-100', 'dark:hover:bg-blue-900/30', 'hover:text-blue-600', 'dark:hover:text-blue-400');
                    } else if (btnTab === 'registered') {
                        btn.classList.add('hover:bg-green-100', 'dark:hover:bg-green-900/30', 'hover:text-green-600', 'dark:hover:text-green-400');
                    } else if (btnTab === 'unregistered') {
                        btn.classList.add('hover:bg-amber-100', 'dark:hover:bg-amber-900/30', 'hover:text-amber-600', 'dark:hover:text-amber-400');
                    }
                }
            });
        }

        // Handle browser back/forward
        window.addEventListener('popstate', function (e) {
            location.reload();
        });
    </script>
@endsection