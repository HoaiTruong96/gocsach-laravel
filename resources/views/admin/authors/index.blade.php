@extends('layouts.admin')

@section('title', 'Quản lý Tác giả')

@section('header', 'Quản lý Tác giả')

@section('content')
<div class="space-y-6">
    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex gap-4">
            <!-- Search -->
            <form action="{{ route('admin.authors.index') }}" method="GET" class="relative">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="q" value="{{ request('q') }}"
                    class="pl-10 pr-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-all w-64 shadow-sm"
                    placeholder="Tìm kiếm tác giả...">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </form>
        </div>

        <div class="flex gap-3">
             <button onclick="openAuthorModal()"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Thêm tác giả</span>
            </button>
        </div>
    </div>

    <!-- Stats / Tabs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Tab: Tất cả -->
        <a href="{{ route('admin.authors.index', ['tab' => 'all', 'q' => request('q')]) }}"
            class="relative p-4 rounded-xl shadow-sm border transition-all duration-200 group overflow-hidden
            {{ $tab == 'all' ? 'bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-700' : 'bg-white dark:bg-slate-800 border-gray-100 dark:border-slate-700 hover:border-blue-200 dark:hover:border-blue-700' }}">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tất cả tác giả</p>
                    <h3 class="text-2xl font-bold {{ $tab == 'all' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-800 dark:text-white' }}">
                        {{ $stats['total'] }}
                    </h3>
                </div>
                <div class="p-3 rounded-lg {{ $tab == 'all' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' : 'bg-gray-100 dark:bg-slate-700 text-gray-500' }}">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </a>

        <!-- Tab: Đã đăng ký -->
        <a href="{{ route('admin.authors.index', ['tab' => 'registered', 'q' => request('q')]) }}"
            class="relative p-4 rounded-xl shadow-sm border transition-all duration-200 group overflow-hidden
            {{ $tab == 'registered' ? 'bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-700' : 'bg-white dark:bg-slate-800 border-gray-100 dark:border-slate-700 hover:border-green-200 dark:hover:border-green-700' }}">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Đã đăng ký</p>
                    <h3 class="text-2xl font-bold {{ $tab == 'registered' ? 'text-green-600 dark:text-green-400' : 'text-gray-800 dark:text-white' }}">
                        {{ $stats['registered'] }}
                    </h3>
                </div>
                <div class="p-3 rounded-lg {{ $tab == 'registered' ? 'bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400' : 'bg-gray-100 dark:bg-slate-700 text-gray-500' }}">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            @if($tab == 'registered')
                <div class="absolute bottom-0 left-0 w-full h-1 bg-green-500"></div>
            @endif
        </a>

        <!-- Tab: Chưa đăng ký -->
        <a href="{{ route('admin.authors.index', ['tab' => 'unregistered', 'q' => request('q')]) }}"
            class="relative p-4 rounded-xl shadow-sm border transition-all duration-200 group overflow-hidden
            {{ $tab == 'unregistered' ? 'bg-amber-50 border-amber-200 dark:bg-amber-900/20 dark:border-amber-700' : 'bg-white dark:bg-slate-800 border-gray-100 dark:border-slate-700 hover:border-amber-200 dark:hover:border-amber-700' }}">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Chưa đăng ký</p>
                    <h3 class="text-2xl font-bold {{ $tab == 'unregistered' ? 'text-amber-600 dark:text-amber-400' : 'text-gray-800 dark:text-white' }}">
                        {{ $stats['unregistered'] }}
                    </h3>
                </div>
                <div class="p-3 rounded-lg {{ $tab == 'unregistered' ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400' : 'bg-gray-100 dark:bg-slate-700 text-gray-500' }}">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </div>
            </div>
             @if($tab == 'unregistered')
                <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-500"></div>
            @endif
        </a>
    </div>

    <!-- Main Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 text-gray-600 dark:text-gray-300 text-sm uppercase font-semibold border-b border-gray-200 dark:border-slate-700">
                        <th class="px-6 py-4 w-16 text-center">STT</th>
                        <th class="px-6 py-4">Tác giả</th>
                        <th class="px-6 py-4 text-center">Số sách</th>
                        <th class="px-6 py-4">Thông tin</th>
                        <th class="px-6 py-4">Trạng thái</th>
                        <th class="px-6 py-4 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($authors as $index => $author)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors group">
                            <td class="px-6 py-4 text-center font-medium text-gray-500 dark:text-gray-400">
                                {{ ($authors->currentPage() - 1) * $authors->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 rounded-full overflow-hidden border border-gray-200 dark:border-slate-600 bg-gray-100 shrink-0">
                                        @if($author->photo)
                                            <img src="{{ Str::startsWith($author->photo, 'http') ? $author->photo : asset('storage/' . $author->photo) }}"
                                                alt="{{ $author->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-bold text-lg">
                                                {{ Str::substr($author->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $author->name }}
                                        </h4>
                                        @if(isset($author->id))
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">ID: {{ $author->id }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800">
                                    {{ $author->books_count }} sách
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                <div class="space-y-1">
                                    @if($author->birth_year)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-birthday-cake w-4 text-gray-400"></i>
                                            <span>
                                                {{ $author->birth_year }}
                                                @if($author->death_year) - {{ $author->death_year }} @endif
                                            </span>
                                        </div>
                                    @endif
                                    @if($author->nationality)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-globe w-4 text-gray-400"></i>
                                            <span>{{ $author->nationality }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($author->is_from_books) && $author->is_from_books)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100 dark:bg-amber-900/20 dark:border-amber-800/50 dark:text-amber-400">
                                        <i class="fas fa-exclamation-circle text-[10px]"></i> Chưa đăng ký
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600 border border-green-100 dark:bg-green-900/20 dark:border-green-800/50 dark:text-green-400">
                                        <i class="fas fa-check-circle text-[10px]"></i> Đã đăng ký
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if(isset($author->id))
                                        <!-- Edit -->
                                        <a href="{{ route('admin.authors.edit', $author->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all"
                                           title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Delete -->
                                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa tác giả này?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all"
                                                    title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Create from Unregistered -->
                                        <button onclick="openAuthorModal('{{ $author->name }}')"
                                           class="px-3 py-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all text-xs font-medium flex items-center gap-1">
                                            <i class="fas fa-plus"></i> Đăng ký
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-user-slash text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-lg font-medium mb-1">Không tìm thấy tác giả nào</p>
                                    <p class="text-sm">Thử thay đổi bộ lọc hoặc tìm kiếm lại</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($authors->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/30">
                {{ $authors->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Add Author Modal -->
<div id="authorModal" class="fixed inset-0 z-50 hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0" id="modalOverlay"></div>
    
    <!-- Modal Content -->
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
            <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Thêm Tác giả mới</h3>
                <button onclick="closeAuthorModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.authors.store') }}" method="POST" id="authorForm">
                @csrf
                <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên tác giả <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="authorName" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="VD: Nguyễn Nhật Ánh" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Ảnh (URL)</label>
                        <input type="text" name="photo" id="authorPhoto" value="{{ old('photo') }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="https://example.com/photo.jpg">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm sinh</label>
                            @include('admin.partials.custom-pickers', [
                                'type' => 'year',
                                'name' => 'birth_year',
                                'value' => old('birth_year'),
                                'placeholder' => 'Chọn năm sinh...'
                            ])
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm mất</label>
                            @include('admin.partials.custom-pickers', [
                                'type' => 'year',
                                'name' => 'death_year',
                                'value' => old('death_year'),
                                'placeholder' => 'Còn sống...'
                            ])
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Quốc tịch</label>
                        <input type="text" name="nationality" id="authorNationality" value="{{ old('nationality') }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="Việt Nam">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tiểu sử</label>
                        <textarea name="bio" id="authorBio" rows="5"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors resize-y min-h-[120px]"
                            placeholder="Giới thiệu về tác giả...">{{ old('bio') }}</textarea>
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-700/50 rounded-b-xl">
                    <button type="button" onclick="closeAuthorModal()"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-600 transition-colors font-medium">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors font-medium shadow-lg shadow-blue-500/30">
                        <i class="fas fa-save mr-2"></i> Lưu tác giả
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAuthorModal(name = '') {
        const modal = document.getElementById('authorModal');
        const overlay = document.getElementById('modalOverlay');
        const content = document.getElementById('modalContent');
        const form = document.getElementById('authorForm');
        
        // Show modal container
        modal.classList.remove('hidden');
        
        // Populate name if provided (for register action)
        if (name) {
            document.getElementById('authorName').value = name;
        } else {
            // Only clear if NOT reopening due to errors
            @unless($errors->any())
                form.reset();
            @endunless
        }
        
        // Animation
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeAuthorModal() {
        const modal = document.getElementById('authorModal');
        const overlay = document.getElementById('modalOverlay');
        const content = document.getElementById('modalContent');
        
        // Animation reverse
        overlay.classList.add('opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Auto open if errors exist
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openAuthorModal();
        });
    @endif
    
    // Close on overlay click
    document.getElementById('modalOverlay').addEventListener('click', closeAuthorModal);
</script>
@endsection
