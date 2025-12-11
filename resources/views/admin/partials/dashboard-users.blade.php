<div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
    <h4 class="font-bold text-gray-800">
        <i class="fas fa-user-plus text-green-500 mr-2"></i>Thành viên mới T{{ $selectedMonth }}/{{ $selectedYear }}
    </h4>
    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-bold">{{ $monthlyUsersList->total() }}
        người</span>
</div>
@if($monthlyUsersList->count() > 0)
    <table class="w-full text-left text-sm">
        <tbody class="divide-y divide-gray-100">
            @foreach($monthlyUsersList as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . $user->name . '&background=random' }}"
                                class="w-8 h-8 rounded-full object-cover border-2 border-gray-100">
                            <div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right text-gray-500 text-xs">
                        {{ $user->created_at->format('d/m H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-3 bg-gray-50 border-t text-xs pagination">
        {{ $monthlyUsersList->links() }}
    </div>
@else
    <div class="p-8 text-center text-gray-400">
        <i class="fas fa-user-slash text-4xl mb-2 opacity-50"></i>
        <p>Không có thành viên mới.</p>
    </div>
@endif