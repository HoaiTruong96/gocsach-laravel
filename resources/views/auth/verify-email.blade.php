@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16 flex justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg border border-gray-100 text-center">
        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Kiểm tra hộp thư của bạn</h2>
        <p class="text-gray-600 mb-6">
            Chúng tôi đã gửi một liên kết xác thực đến email <strong>{{ Auth::user()->email }}</strong>. 
            Vui lòng kiểm tra và nhấn vào liên kết để kích hoạt tài khoản.
        </p>

        @if (session('message'))
            <div class="bg-green-50 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="bg-brand-green text-white px-6 py-2 rounded-full font-bold hover:bg-green-700 transition w-full mb-3">
                Gửi lại email xác thực
            </button>
        </form>
        
        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:underline">Về trang chủ</a>
    </div>
</div>
@endsection
