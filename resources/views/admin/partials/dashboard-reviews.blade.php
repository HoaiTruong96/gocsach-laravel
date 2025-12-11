<div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
    <h4 class="font-bold text-gray-800">
        <i class="fas fa-file-alt text-blue-500 mr-2"></i>Review Tháng {{ $selectedMonth }}/{{ $selectedYear }}
    </h4>
    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-bold">{{ $monthlyReviewsList->total() }}
        bài</span>
</div>
@if($monthlyReviewsList->count() > 0)
    <table class="w-full text-left text-sm">
        <tbody class="divide-y divide-gray-100">
            @foreach($monthlyReviewsList as $review)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-800 line-clamp-1">{{ $review->book->title ?? 'Sách đã xóa' }}</p>
                        <p class="text-xs text-gray-500">Bởi: {{ $review->user->name }} •
                            {{ $review->created_at->format('d/m') }}</p>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <span
                            class="px-2 py-1 rounded text-xs font-bold {{ $review->status == 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $review->status == 'published' ? 'Đã duyệt' : 'Chờ duyệt' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-3 bg-gray-50 border-t text-xs pagination">
        {{ $monthlyReviewsList->links() }}
    </div>
@else
    <div class="p-8 text-center text-gray-400">
        <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
        <p>Không có bài viết nào trong tháng này.</p>
    </div>
@endif