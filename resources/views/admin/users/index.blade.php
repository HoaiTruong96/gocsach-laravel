@extends('layouts.admin')
@section('title', 'Thành Viên')
@section('header', 'Danh sách người dùng')

@section('content')
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-slate-300 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Thành viên</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3 text-center">Vai trò</th>
                        <th class="px-6 py-3 text-center">Đóng góp</th>
                        <th class="px-6 py-3 text-center">Ngày tham gia</th>
                        <th class="px-6 py-3 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name . '&background=random' }}"
                                        class="w-10 h-10 rounded-full border dark:border-slate-600">
                                    <div>
                                        <div class="font-bold text-gray-800 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">
                                            {{ $user->is_active ? '🟢 Đang hoạt động' : '⚪ Ngoại tuyến' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">{{ $user->email }}</td>

                            <td class="px-6 py-4 text-center">
                                @if($user->role === 'admin')
                                    <span
                                        class="px-3 py-1 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-full text-xs font-bold border border-red-200 dark:border-red-800">Quản trị</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 rounded-full text-xs font-bold border border-blue-100 dark:border-blue-800">Thành viên</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-bold text-gray-700 dark:text-white">{{ $user->posts_count }}</div>
                                <div class="text-[10px] text-gray-400 dark:text-slate-500 uppercase">Bài viết</div>
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-gray-500 dark:text-slate-400">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if($user->role !== 'admin')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa/ban thành viên này?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 p-2 rounded transition"
                                            title="Xóa thành viên">
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-300 dark:text-slate-600 cursor-not-allowed"><i
                                            class="fas fa-lock"></i></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t dark:border-slate-700">
            {{ $users->links('vendor.pagination.admin') }}
        </div>
    </div>
@endsection