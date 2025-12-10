@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('header', 'Tổng Quan Hệ Thống')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Tổng đầu sách</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($bookCount) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Thành viên</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xl">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Đánh giá tuần này</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($newReviewsCount) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 text-xl">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Review chờ duyệt</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($pendingReviewCount) }}</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Review Mới Nhất</h3>
        <a href="{{ route('admin.reviews.index') }}" class="text-sm text-blue-600 hover:underline">Xem tất cả</a>
    </div>

    @if(isset($recentReviews) && $recentReviews->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Người dùng</th>
                    <th class="px-6 py-3">Sách review</th>
                    <th class="px-6 py-3">Điểm</th>
                    <th class="px-6 py-3">Thời gian</th>
                    <th class="px-6 py-3 text-center">Trạng thái</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recentReviews as $review)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name='.$review->user->name }}" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium text-gray-700">{{ $review->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600 block truncate w-48" title="{{ $review->book->title ?? 'Sách đã xóa' }}">
                            {{ $review->book->title ?? 'Sách đã xóa' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-yellow-500 text-sm font-bold">
                            <i class="fas fa-star"></i> {{ $review->rating }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $review->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($review->status == 'published')
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Đã duyệt</span>
                        @elseif($review->status == 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Chờ duyệt</span>
                        @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">{{ $review->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-8 text-center text-gray-500">
        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
        <p>Chưa có bài review nào.</p>
    </div>
    @endif
</div>
@endsection