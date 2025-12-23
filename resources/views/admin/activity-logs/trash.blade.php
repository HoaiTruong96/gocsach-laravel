@extends('layouts.admin')
@section('title', 'Thùng Rác')
@section('header', 'Thùng Rác')

@section('content')
    {{-- Back button --}}
    <div class="mb-6">
        <a href="{{ route('admin.activity-logs.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition font-medium text-sm">
            <i class="fas fa-arrow-left"></i>Quay lại Nhật ký hoạt động
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-xl">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $trashedBooks->count() }}</p>
                    <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Sách đã xóa</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 rounded-xl">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $trashedPosts->count() }}</p>
                    <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Bài viết đã xóa</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/40 text-yellow-600 dark:text-yellow-300 rounded-xl">
                    <i class="fas fa-folder text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $trashedCategories->count() }}</p>
                    <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Danh mục đã xóa</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 rounded-xl">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $trashedUsers->count() }}</p>
                    <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Thành viên đã xóa</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Books --}}
    @if($trashedBooks->count() > 0)
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-6">
            <div
                class="p-4 border-b border-gray-100 dark:border-slate-700 bg-blue-50 dark:bg-blue-900/20 flex items-center gap-3">
                <div
                    class="w-8 h-8 flex items-center justify-center bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-lg">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="font-bold text-blue-700 dark:text-blue-300">Sách Đã Xóa</h3>
                <span
                    class="ml-auto px-2 py-0.5 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded-full text-xs font-bold">{{ $trashedBooks->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Tên sách</th>
                            <th class="px-4 py-3">Tác giả</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Ngày xóa</th>
                            <th class="px-4 py-3 text-center w-48">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($trashedBooks as $book)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition group">
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $book->title }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-300 text-sm">{{ $book->author_name }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-500 dark:text-slate-400 italic">
                                    {{ $book->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}">
                                            @csrf
                                            <input type="hidden" name="type" value="book">
                                            <input type="hidden" name="id" value="{{ $book->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 hover:bg-green-500 dark:hover:bg-green-600 hover:text-white transition"
                                                title="Khôi phục">
                                                <i class="fas fa-undo text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}"
                                            onsubmit="return confirm('Xóa vĩnh viễn sách này?')">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="type" value="book">
                                            <input type="hidden" name="id" value="{{ $book->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 hover:bg-red-500 dark:hover:bg-red-600 hover:text-white transition"
                                                title="Xóa vĩnh viễn">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Posts --}}
    @if($trashedPosts->count() > 0)
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-6">
            <div
                class="p-4 border-b border-gray-100 dark:border-slate-700 bg-green-50 dark:bg-green-900/20 flex items-center gap-3">
                <div
                    class="w-8 h-8 flex items-center justify-center bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 rounded-lg">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3 class="font-bold text-green-700 dark:text-green-300">Bài Viết Đã Xóa</h3>
                <span
                    class="ml-auto px-2 py-0.5 bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 rounded-full text-xs font-bold">{{ $trashedPosts->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Sách</th>
                            <th class="px-4 py-3">Người viết</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Ngày xóa</th>
                            <th class="px-4 py-3 text-center w-48">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($trashedPosts as $post)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition group">
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">
                                    {{ $post->book->title ?? 'Sách đã xóa' }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-300 text-sm">{{ $post->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-500 dark:text-slate-400 italic">
                                    {{ $post->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}">
                                            @csrf
                                            <input type="hidden" name="type" value="post">
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 hover:bg-green-500 dark:hover:bg-green-600 hover:text-white transition"
                                                title="Khôi phục">
                                                <i class="fas fa-undo text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}"
                                            onsubmit="return confirm('Xóa vĩnh viễn bài viết này?')">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="type" value="post">
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 hover:bg-red-500 dark:hover:bg-red-600 hover:text-white transition"
                                                title="Xóa vĩnh viễn">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Categories --}}
    @if($trashedCategories->count() > 0)
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-6">
            <div
                class="p-4 border-b border-gray-100 dark:border-slate-700 bg-yellow-50 dark:bg-yellow-900/20 flex items-center gap-3">
                <div
                    class="w-8 h-8 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/40 text-yellow-600 dark:text-yellow-300 rounded-lg">
                    <i class="fas fa-folder"></i>
                </div>
                <h3 class="font-bold text-yellow-700 dark:text-yellow-300">Danh Mục Đã Xóa</h3>
                <span
                    class="ml-auto px-2 py-0.5 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-600 dark:text-yellow-300 rounded-full text-xs font-bold">{{ $trashedCategories->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Tên danh mục</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Ngày xóa</th>
                            <th class="px-4 py-3 text-center w-48">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($trashedCategories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition group">
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-300 text-sm font-mono italic">
                                    {{ $category->slug }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-500 dark:text-slate-400 italic">
                                    {{ $category->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}">
                                            @csrf
                                            <input type="hidden" name="type" value="category">
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 hover:bg-green-500 dark:hover:bg-green-600 hover:text-white transition"
                                                title="Khôi phục">
                                                <i class="fas fa-undo text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}"
                                            onsubmit="return confirm('Xóa vĩnh viễn danh mục này?')">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="type" value="category">
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 hover:bg-red-500 dark:hover:bg-red-600 hover:text-white transition"
                                                title="Xóa vĩnh viễn">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Users --}}
    @if($trashedUsers->count() > 0)
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden mb-6">
            <div
                class="p-4 border-b border-gray-100 dark:border-slate-700 bg-red-50 dark:bg-red-900/20 flex items-center gap-3">
                <div
                    class="w-8 h-8 flex items-center justify-center bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 rounded-lg">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="font-bold text-red-700 dark:text-red-300">Thành Viên Đã Xóa</h3>
                <span
                    class="ml-auto px-2 py-0.5 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 rounded-full text-xs font-bold">{{ $trashedUsers->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-400 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Thành viên</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Ngày xóa</th>
                            <th class="px-4 py-3 text-center w-48">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($trashedUsers as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition group">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                            class="w-8 h-8 rounded-full border dark:border-slate-600">
                                        <span class="font-medium text-gray-800 dark:text-white">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-300 text-sm">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-500 dark:text-slate-400 italic">
                                    {{ $user->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}">
                                            @csrf
                                            <input type="hidden" name="type" value="user">
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-300 hover:bg-green-500 dark:hover:bg-green-600 hover:text-white transition"
                                                title="Khôi phục">
                                                <i class="fas fa-undo text-xs"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}"
                                            onsubmit="return confirm('Xóa vĩnh viễn thành viên này?')">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="type" value="user">
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 hover:bg-red-500 dark:hover:bg-red-600 hover:text-white transition"
                                                title="Xóa vĩnh viễn">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Empty State --}}
    @if($trashedBooks->count() == 0 && $trashedPosts->count() == 0 && $trashedCategories->count() == 0 && $trashedUsers->count() == 0)
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-16 text-center">
            <div class="w-24 h-24 mx-auto mb-6 flex items-center justify-center bg-gray-100 dark:bg-slate-700 rounded-full">
                <i class="fas fa-trash-alt text-4xl text-gray-300 dark:text-slate-500"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-600 dark:text-slate-300 mb-2">Thùng rác trống</h3>
            <p class="text-gray-400 dark:text-slate-500">Không có mục nào đã bị xóa.</p>
        </div>
    @endif
@endsection