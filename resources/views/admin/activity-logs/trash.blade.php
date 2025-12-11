@extends('layouts.admin')
@section('title', 'Thùng Rác')
@section('header', 'Thùng Rác - Các Mục Đã Xóa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.activity-logs.index') }}"
            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại Lịch sử hoạt động
        </a>
    </div>

    <!-- Thống kê nhanh -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $trashedBooks->count() }}</p>
                <p class="text-xs text-gray-500">Sách đã xóa</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $trashedPosts->count() }}</p>
                <p class="text-xs text-gray-500">Bài viết đã xóa</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-folder text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $trashedCategories->count() }}</p>
                <p class="text-xs text-gray-500">Danh mục đã xóa</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $trashedUsers->count() }}</p>
                <p class="text-xs text-gray-500">Thành viên đã xóa</p>
            </div>
        </div>
    </div>

    <!-- Sách đã xóa -->
    @if($trashedBooks->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-blue-50">
                <h3 class="font-bold text-blue-800">
                    <i class="fas fa-book mr-2"></i>
                    Sách Đã Xóa ({{ $trashedBooks->count() }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-medium">
                        <tr>
                            <th class="px-4 py-3">Tên sách</th>
                            <th class="px-4 py-3">Tác giả</th>
                            <th class="px-4 py-3">Ngày xóa</th>
                            <th class="px-4 py-3 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($trashedBooks as $book)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $book->title }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $book->author_name }}</td>
                                <td class="px-4 py-3 text-gray-500 text-sm">{{ $book->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}"
                                            class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="book">
                                            <input type="hidden" name="id" value="{{ $book->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition">
                                                <i class="fas fa-undo mr-1"></i> Khôi phục
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}" class="inline"
                                            onsubmit="return confirm('Xóa vĩnh viễn sách này? Hành động không thể hoàn tác!')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="type" value="book">
                                            <input type="hidden" name="id" value="{{ $book->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition">
                                                <i class="fas fa-trash mr-1"></i> Xóa vĩnh viễn
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

    <!-- Bài viết đã xóa -->
    @if($trashedPosts->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-green-50">
                <h3 class="font-bold text-green-800">
                    <i class="fas fa-file-alt mr-2"></i>
                    Bài Viết Đã Xóa ({{ $trashedPosts->count() }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-medium">
                        <tr>
                            <th class="px-4 py-3">Sách</th>
                            <th class="px-4 py-3">Người viết</th>
                            <th class="px-4 py-3">Ngày xóa</th>
                            <th class="px-4 py-3 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($trashedPosts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $post->book->title ?? 'Sách đã xóa' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $post->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-500 text-sm">{{ $post->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}"
                                            class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="post">
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition">
                                                <i class="fas fa-undo mr-1"></i> Khôi phục
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}" class="inline"
                                            onsubmit="return confirm('Xóa vĩnh viễn bài viết này? Hành động không thể hoàn tác!')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="type" value="post">
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition">
                                                <i class="fas fa-trash mr-1"></i> Xóa vĩnh viễn
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

    <!-- Danh mục đã xóa -->
    @if($trashedCategories->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-yellow-50">
                <h3 class="font-bold text-yellow-800">
                    <i class="fas fa-folder mr-2"></i>
                    Danh Mục Đã Xóa ({{ $trashedCategories->count() }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-medium">
                        <tr>
                            <th class="px-4 py-3">Tên danh mục</th>
                            <th class="px-4 py-3">Slug</th>
                            <th class="px-4 py-3">Ngày xóa</th>
                            <th class="px-4 py-3 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($trashedCategories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $category->slug }}</td>
                                <td class="px-4 py-3 text-gray-500 text-sm">{{ $category->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}"
                                            class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="category">
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition">
                                                <i class="fas fa-undo mr-1"></i> Khôi phục
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}" class="inline"
                                            onsubmit="return confirm('Xóa vĩnh viễn danh mục này? Hành động không thể hoàn tác!')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="type" value="category">
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition">
                                                <i class="fas fa-trash mr-1"></i> Xóa vĩnh viễn
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

    <!-- Thành viên đã xóa -->
    @if($trashedUsers->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-red-50">
                <h3 class="font-bold text-red-800">
                    <i class="fas fa-users mr-2"></i>
                    Thành Viên Đã Xóa ({{ $trashedUsers->count() }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500 font-medium">
                        <tr>
                            <th class="px-4 py-3">Thành viên</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Ngày xóa</th>
                            <th class="px-4 py-3 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($trashedUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                            class="w-8 h-8 rounded-full object-cover border">
                                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-gray-500 text-sm">{{ $user->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.activity-logs.restore-trashed') }}"
                                            class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="user">
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition">
                                                <i class="fas fa-undo mr-1"></i> Khôi phục
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.activity-logs.force-delete') }}" class="inline"
                                            onsubmit="return confirm('Xóa vĩnh viễn thành viên này? Hành động không thể hoàn tác!')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="type" value="user">
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition">
                                                <i class="fas fa-trash mr-1"></i> Xóa vĩnh viễn
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

    <!-- Thông báo trống -->
    @if($trashedBooks->count() == 0 && $trashedPosts->count() == 0 && $trashedCategories->count() == 0 && $trashedUsers->count() == 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
            <i class="fas fa-trash-alt text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-600 mb-2">Thùng rác trống</h3>
            <p class="text-gray-400">Không có mục nào đã bị xóa.</p>
        </div>
    @endif
@endsection