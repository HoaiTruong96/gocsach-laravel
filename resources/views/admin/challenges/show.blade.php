@extends('layouts.admin')
@section('title', 'Chi tiết Thử Thách')
@section('header', 'Thử Thách: ' . $challenge->name)

@section('content')
    <div class="space-y-6">
        {{-- Info Card --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors duration-300">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl">{{ $challenge->badge->icon ?? '🏆' }}</span>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $challenge->name }}</h2>
                            <p class="text-gray-500 dark:text-slate-400">{{ $challenge->description }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-4 text-sm">
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                            <i class="fas fa-pen mr-1"></i>Mục tiêu: {{ $challenge->target_count }} reviews
                        </span>
                        <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full">
                            <i class="fas fa-calendar mr-1"></i>{{ $challenge->start_date->format('d/m/Y') }} -
                            {{ $challenge->end_date->format('d/m/Y') }}
                        </span>
                        <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full">
                            <i class="fas fa-medal mr-1"></i>{{ $challenge->badge->name }}
                        </span>
                        @if($challenge->isOngoing())
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full font-semibold">
                                <i class="fas fa-play mr-1"></i>Đang diễn ra
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.challenges.edit', $challenge) }}"
                        class="px-4 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 font-medium">
                        <i class="fas fa-edit mr-1"></i>Sửa
                    </a>
                    <a href="{{ route('admin.game.index', ['tab' => 'challenges']) }}"
                        class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 font-medium">
                        <i class="fas fa-arrow-left mr-1"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>

        {{-- Participants --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
            <div
                class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                <span class="font-semibold text-gray-700 dark:text-white">
                    <i class="fas fa-users text-blue-500 mr-2"></i>Người tham gia ({{ $userChallenges->total() }})
                </span>
            </div>
            <table class="w-full text-left">
                <thead
                    class="text-xs text-gray-500 dark:text-slate-400 uppercase bg-white dark:bg-slate-800 border-b dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-3">Người dùng</th>
                        <th class="px-6 py-3 text-center">Tiến độ</th>
                        <th class="px-6 py-3 text-center">Trạng thái</th>
                        <th class="px-6 py-3 text-center">Hoàn thành lúc</th>
                        <th class="px-6 py-3 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($userChallenges as $uc)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ $uc->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($uc->user->name) }}"
                                        class="w-8 h-8 rounded-full mr-3" alt="">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-white">{{ $uc->user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $uc->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $uc->progress_percent }}%">
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm text-gray-600">{{ $uc->current_count }}/{{ $challenge->target_count }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($uc->is_completed)
                                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs font-bold">
                                        <i class="fas fa-check mr-1"></i>Hoàn thành
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs font-bold">
                                        Đang thực hiện
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ $uc->completed_at ? $uc->completed_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($uc->is_completed)
                                    @php
                                        $hasBadge = \App\Models\UserBadge::where('user_id', $uc->user_id)
                                            ->where('badge_id', $challenge->badge_id)->exists();
                                    @endphp
                                    @if($hasBadge)
                                        <span class="text-green-500 text-sm"><i class="fas fa-medal"></i> Đã cấp danh hiệu</span>
                                    @else
                                        <form action="{{ route('admin.challenges.award-badge', [$challenge, $uc->user_id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                                <i class="fas fa-award mr-1"></i>Cấp Danh Hiệu
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                <i class="fas fa-users text-4xl text-gray-300 dark:text-slate-600 mb-2"></i>
                                <p>Chưa có ai tham gia thử thách này</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($userChallenges->hasPages())
                <div class="p-4 border-t dark:border-slate-700">
                    {{ $userChallenges->links('vendor.pagination.admin') }}
                </div>
            @endif
        </div>
    </div>
@endsection