@extends('layouts.app')

@section('title', 'Thử Thách Đọc Sách - Góc Sách')

@section('content')
    
    {{-- 1. HEADER NHỎ GỌN --}}
    <div class="bg-white border-b border-gray-100 py-8">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl font-serif font-bold text-brand-green mb-2">Sàn Đấu Thử Thách</h1>
            <p class="text-gray-500 text-sm">Tham gia sự kiện, hoàn thành mục tiêu và nhận huy hiệu vinh danh.</p>
        </div>
    </div>

    {{-- 2. DANH SÁCH THỬ THÁCH (STYLE MỚI) --}}
    <main class="container mx-auto px-4 py-12 flex-grow min-h-screen max-w-5xl">
    
    {{-- Thông báo Flash Message --}}
    @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 shadow-sm animate-fade-in">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        {{-- VÒNG LẶP: Duyệt qua từng thử thách thật trong Database --}}
        @foreach($challenges as $challenge)
            
            @php
                // Logic kiểm tra trạng thái của User với Thử thách này
                $userChallenge = null;
                $isJoined = false;
                $isCompleted = false;
                $percent = 0;

                if(Auth::check()) {
                    // Lấy thông tin từ bảng trung gian (pivot)
                    $userChallenge = Auth::user()->challenges->find($challenge->id);
                    if($userChallenge) {
                        $isJoined = true;
                        $isCompleted = $userChallenge->pivot->is_completed;
                        
                        // Tính % tiến độ
                        $current = $userChallenge->pivot->current_count;
                        $target = $challenge->target_count;
                        $percent = ($target > 0) ? ($current / $target) * 100 : 0;
                        if($percent > 100) $percent = 100;
                    }
                }
            @endphp

            {{-- TRƯỜNG HỢP 1: ĐÃ HOÀN THÀNH (Thẻ Vàng) --}}
            @if($isCompleted)
                <div class="bg-gradient-to-r from-yellow-50 to-white border border-yellow-200 rounded-2xl p-6 md:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-yellow-100 opacity-50 transform rotate-12">
                        <i class="fas fa-trophy text-9xl"></i>
                    </div>

                    <div class="flex-1 text-center md:text-left relative z-10">
                        <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-3 inline-block">
                            Hoàn Thành
                        </span>
                        <h3 class="text-xl md:text-2xl font-serif font-bold text-gray-800 mb-1">
                            {{ $challenge->name }}
                        </h3>
                        <p class="text-gray-500 text-sm">
                            Bạn đã xuất sắc hoàn thành mục tiêu!
                        </p>
                    </div>

                    <div class="flex-shrink-0 relative z-10 flex flex-col md:flex-row items-center gap-3">
                        <!-- Badge -->
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 mb-1 shadow-sm border border-yellow-200">
                                <i class="fas fa-medal text-3xl"></i>
                            </div>
                            <span class="text-xs font-bold text-yellow-700 uppercase tracking-wide">Danh hiệu</span>
                        </div>
                        
                        <!-- Avatar Frame (if exists) -->
                        @if($challenge->avatarFrame)
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-1 shadow-sm border border-purple-200 overflow-hidden p-1">
                                    <img src="{{ Str::startsWith($challenge->avatarFrame->frame_image, 'http') ? $challenge->avatarFrame->frame_image : asset('storage/' . $challenge->avatarFrame->frame_image) }}" 
                                         alt="{{ $challenge->avatarFrame->name }}" 
                                         class="w-full h-full object-contain">
                                </div>
                                <span class="text-xs font-bold text-purple-700 uppercase tracking-wide">Khung Avatar</span>
                            </div>
                        @endif
                    </div>
                </div>

            {{-- TRƯỜNG HỢP 2: ĐANG THỰC HIỆN (Thẻ Trắng có thanh tiến độ) --}}
            @elseif($isJoined)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative group hover:shadow-md transition duration-300">
                    <div class="flex-1 text-center md:text-left w-full">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                            <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                                Đang Diễn Ra
                            </span>
                            <span class="text-xs text-gray-400 font-medium">
                                <i class="fas fa-clock mr-1"></i> Hạn chót: {{ \Carbon\Carbon::parse($challenge->end_date)->format('d/m/Y') }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl md:text-2xl font-serif font-bold text-gray-800 mb-2">
                            {{ $challenge->name }}
                        </h3>
                        <p class="text-gray-500 text-sm mb-4">
                            {{ $challenge->description ?? 'Cố lên! Bạn đang làm rất tốt.' }}
                        </p>

                        {{-- Thanh tiến độ --}}
                        <div class="bg-gray-100 rounded-full h-3 w-full max-w-md mx-auto md:mx-0 overflow-hidden relative border border-gray-200">
                            <div class="bg-brand-green h-full rounded-full relative transition-all duration-1000" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="flex justify-between max-w-md mx-auto md:mx-0 mt-1 text-xs font-bold">
                            <span class="text-brand-green">{{ $userChallenge->pivot->current_count }} / {{ $challenge->target_count }} bài</span>
                            <span class="text-gray-400">{{ round($percent) }}%</span>
                        </div>
                    </div>

                    <div class="flex-shrink-0 text-center">
                        <a href="{{ route('reviews.create') }}" class="inline-block bg-brand-green text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-lg hover:bg-[#1e3a2f] transition transform hover:-translate-y-0.5">
                            Viết Review Ngay
                        </a>
                        <p class="text-[10px] text-gray-400 italic mt-2">Viết thêm bài để tăng điểm</p>
                    </div>
                </div>

            {{-- TRƯỜNG HỢP 3: CHƯA THAM GIA (Thẻ Xanh Đậm) --}}
            @else
                <div class="bg-[#2A483A] rounded-2xl p-6 md:p-8 shadow-lg text-white flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group hover:-translate-y-1 transition duration-300">
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                    
                    <div class="relative z-10 flex-1 text-center md:text-left">
                        <span class="inline-block border border-brand-accent/50 text-brand-accent text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-3 bg-black/10">
                            Sự Kiện Mới
                        </span>
                        <h3 class="text-2xl md:text-3xl font-serif font-bold mb-2 text-white">
                            {{ $challenge->name }}
                        </h3>
                        <p class="text-white/70 text-sm md:text-base font-light max-w-xl">
                            {{ $challenge->description ?? 'Hoàn thành mục tiêu để nhận huy hiệu danh giá.' }}
                        </p>
                        
                        <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-4 text-xs text-white/50 font-medium">
                            <span class="flex items-center gap-1.5"><i class="fas fa-bullseye"></i> Mục tiêu: {{ $challenge->target_count }} bài review</span>
                            <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt"></i> Hạn: {{ \Carbon\Carbon::parse($challenge->end_date)->format('d/m/Y') }}</span>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-gift"></i> 
                                Phần thưởng: Danh hiệu{{ $challenge->avatarFrame ? ' + Khung Avatar' : '' }}
                            </span>
                        </div>
                    </div>

                    <div class="relative z-10 flex-shrink-0">
                        <form action="{{ route('challenge.join', $challenge->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-brand-accent hover:bg-[#c29263] text-white px-8 py-3 rounded-full font-bold shadow-lg transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
                                <span>Tham Gia Ngay</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        @endforeach

        {{-- Nếu không có thử thách nào --}}
        @if($challenges->isEmpty())
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <i class="fas fa-clipboard-list text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-600">Chưa có thử thách nào</h3>
                <p class="text-gray-500 text-sm">Hãy quay lại sau nhé!</p>
            </div>
        @endif
    </div>
</main>
@endsection