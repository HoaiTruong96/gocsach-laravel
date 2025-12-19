@extends('layouts.admin')
@section('title', 'Quản lý Tác giả')
@section('header', 'Quản lý Tác giả')

@section('content')
    {{-- Thống kê và Tabs --}}
    <div class="mb-6">
        <div class="flex flex-wrap gap-2 bg-white dark:bg-slate-800 rounded-xl p-2 border border-gray-100 dark:border-slate-700 shadow-sm">
            <a href="{{ route('admin.authors.index', ['tab' => 'all']) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $tab === 'all' ? 'bg-blue-600 text-white shadow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700' }}">
                <i class="fas fa-users mr-1"></i> Tất cả 
                <span class="ml-1 px-1.5 py-0.5 bg-white/20 rounded text-xs">{{ $stats['total'] }}</span>
            </a>
            <a href="{{ route('admin.authors.index', ['tab' => 'registered']) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $tab === 'registered' ? 'bg-green-600 text-white shadow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700' }}">
                <i class="fas fa-check-circle mr-1"></i> Đã đăng ký
                <span class="ml-1 px-1.5 py-0.5 bg-white/20 rounded text-xs">{{ $stats['registered'] }}</span>
            </a>
            <a href="{{ route('admin.authors.index', ['tab' => 'unregistered']) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $tab === 'unregistered' ? 'bg-amber-500 text-white shadow' : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700' }}">
                <i class="fas fa-exclamation-circle mr-1"></i> Chưa đăng ký
                <span class="ml-1 px-1.5 py-0.5 bg-white/20 rounded text-xs">{{ $stats['unregistered'] }}</span>
            </a>
        </div>
        <p class="text-xs text-gray-500 dark:text-slate-400 mt-2 ml-2">
            <i class="fas fa-info-circle mr-1"></i>
            "Chưa đăng ký" = Tác giả có trong sách nhưng chưa được thêm vào hệ thống quản lý
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Form thêm tác giả --}}
        <div class="md:col-span-1">
            <div
                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sticky top-6 transition-colors duration-300">
                <h3 class="font-bold text-gray-800 dark:text-white mb-4 text-lg">Thêm tác giả mới</h3>
                <form action="{{ route('admin.authors.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên tác giả
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                placeholder="VD: Nguyễn Nhật Ánh">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Ảnh (URL)</label>
                            <input type="text" name="photo" value="{{ old('photo') }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                placeholder="https://example.com/photo.jpg">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm sinh</label>
                                <input type="number" name="birth_year" value="{{ old('birth_year') }}"
                                
                                    class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                    placeholder="1955">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm mất</label>
                                <input type="number" name="death_year" value="{{ old('death_year') }}"
                                
                                    class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                    placeholder="Để trống nếu còn sống">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Quốc tịch</label>
                            <input type="text" name="nationality" value="{{ old('nationality') }}"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                placeholder="Việt Nam">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tiểu sử</label>
                            <textarea name="bio" rows="3"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                placeholder="Giới thiệu ngắn về tác giả...">{{ old('bio') }}</textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium transition">
                            <i class="fas fa-plus mr-1"></i> Thêm tác giả
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danh sách tác giả --}}
        <div class="md:col-span-2">
            <div
                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div
                    class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                    <span class="font-semibold text-gray-700 dark:text-slate-200">
                        @if($tab === 'registered')
                            Tác giả đã đăng ký
                        @elseif($tab === 'unregistered')
                            Tác giả chưa đăng ký
                        @else
                            Tất cả tác giả
                        @endif
                        ({{ $authors->total() }})
                    </span>
                </div>
                <table class="w-full text-left">
                    <thead
                        class="text-xs text-gray-500 dark:text-slate-400 uppercase bg-white dark:bg-slate-800 border-b dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-3">Tác giả</th>
                            <th class="px-6 py-3 text-center">Số sách</th>
                            <th class="px-6 py-3">Quốc tịch</th>
                            <th class="px-6 py-3 text-center">Trạng thái</th>
                            <th class="px-6 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($authors as $author)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 group transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($author->photo ?? false)
                                            <img src="{{ $author->photo }}" alt="{{ $author->name }}"
                                                class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                                {{ mb_substr($author->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">{{ $author->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-slate-400">
                                                {{ $author->birth_year ?? '?' }} - {{ $author->death_year ?? 'nay' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full">
                                        {{ $author->books_count ?? 0 }} sách
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-slate-400">{{ $author->nationality ?? '—' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($author->is_from_books ?? false)
                                        <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-xs font-bold rounded-full">
                                            Chưa đăng ký
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full">
                                            Đã đăng ký
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @if($author->id)
                                            {{-- Tác giả đã có trong bảng authors --}}
                                            <a href="{{ route('admin.authors.edit', $author->id) }}"
                                                class="text-blue-500 hover:text-blue-700" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST"
                                                onsubmit="return confirm('Xóa tác giả {{ $author->name }}?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-400 hover:text-red-600" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Tác giả chưa có trong bảng authors - Nút đăng ký nhanh --}}
                                            <form action="{{ route('admin.authors.store') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="name" value="{{ $author->name }}">
                                                <button type="submit" class="text-green-500 hover:text-green-700" title="Đăng ký tác giả này">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                    <i class="fas fa-user-edit text-4xl mb-2 opacity-30"></i>
                                    <p>Không có tác giả nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($authors->hasPages())
                    <div class="p-4 border-t dark:border-slate-700">
                        {{ $authors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse z-50">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
@endsection
