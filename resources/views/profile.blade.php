<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        body { font-family: 'Roboto', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="text-gray-800">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-red-700 text-2xl font-bold flex items-center hover:opacity-80 transition">
                <i class="fas fa-book-reader mr-2"></i> Góc Sách
            </a>
            <nav class="hidden md:flex space-x-6 text-sm font-medium uppercase text-gray-700">
                <a href="/" class="hover:text-blue-600 transition">Trang Chủ</a>
                <a href="{{ route('books.search') }}" class="hover:text-blue-600 transition">Review</a>
                <a href="{{ route('profile') }}" class="text-blue-600 border-b-2 border-blue-600 pb-1">Tài Khoản</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 text-center border border-gray-100 sticky top-24">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128' }}" 
                             class="rounded-full border-4 border-blue-100 shadow-md object-cover w-full h-full">
                    </div>

                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm mb-2">{{ $user->email }}</p>
                    
                    <p class="text-gray-600 text-sm italic mb-4 px-2">
                        "{{ $user->bio ?? 'Thành viên tích cực của Góc Sách.' }}"
                    </p>

                    <div class="flex justify-center space-x-2 mb-4">
                        @if($user->role == 'admin')
                            <span class="px-3 py-1 bg-red-100 text-red-600 text-xs rounded-full font-bold border border-red-200">Quản trị viên</span>
                        @else
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs rounded-full font-medium border border-blue-100">Thành viên</span>
                        @endif

                        @if($user->is_active == 1)
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-xs rounded-full font-medium border border-green-100 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Hoạt động
                            </span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs rounded-full font-medium border border-gray-200">Đang khóa</span>
                        @endif
                    </div>

                    <div class="text-xs text-gray-400 space-y-1 mb-6 border-t border-b border-gray-100 py-3">
                        <p><i class="far fa-calendar-alt mr-1"></i> Tham gia: {{ $user->created_at->format('d/m/Y') }}</p>
                        <p><i class="fas fa-sync-alt mr-1"></i> Cập nhật: {{ $user->updated_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <span class="block font-bold text-xl text-blue-600">{{ $totalBooks }}</span>
                            <span class="text-xs text-gray-500 uppercase font-semibold">Tủ sách</span>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <span class="block font-bold text-xl text-green-600">{{ $totalReviews }}</span>
                            <span class="text-xs text-gray-500 uppercase font-semibold">Review</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full border border-gray-300 text-gray-600 py-2 rounded-lg font-medium hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold border-l-4 border-blue-500 pl-3">Tủ Sách Của Tôi</h3>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('profile') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $currentFilter == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                           Tất cả
                        </a>
                        <a href="{{ route('profile', ['status' => 'reading']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $currentFilter == 'reading' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                           Đang đọc
                        </a>
                        <a href="{{ route('profile', ['status' => 'favorites']) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $currentFilter == 'favorites' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                           Yêu thích
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($myBooks as $book)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-row h-44 relative group">
                        
                        <div class="absolute top-0 right-0 p-2 z-10">
                            @if($book->pivot->status == 'reading')
                                <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-1 rounded shadow">ĐANG ĐỌC</span>
                            @elseif($book->pivot->status == 'wishlist')
                                <span class="bg-pink-100 text-pink-600 text-[10px] font-bold px-2 py-1 rounded shadow">YÊU THÍCH</span>
                            @elseif($book->pivot->status == 'completed')
                                <span class="bg-green-100 text-green-600 text-[10px] font-bold px-2 py-1 rounded shadow">ĐÃ ĐỌC</span>
                            @endif
                        </div>

                        <div class="w-32 relative flex-shrink-0">
                            <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                        </div>

                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div>
                                <h4 class="font-bold text-gray-800 line-clamp-2 text-sm mb-1">
                                    <a href="{{ url('/book/' . $book->id) }}" class="hover:text-blue-600">{{ $book->title }}</a>
                                </h4>
                                <p class="text-xs text-gray-500 mb-2">ID Tác giả: {{ $book->author_id }}</p>
                                
                                @if($book->pivot->started_at)
                                    <p class="text-[10px] text-gray-400">
                                        <i class="far fa-clock"></i> Bắt đầu: {{ date('d/m/Y', strtotime($book->pivot->started_at)) }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex justify-end mt-2">
                                <a href="{{ url('/book/' . $book->id) }}" class="bg-white border border-blue-500 text-blue-500 px-3 py-1 rounded text-xs hover:bg-blue-500 hover:text-white transition font-medium">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                        <i class="fas fa-book-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Chưa có cuốn sách nào trong mục này.</p>
                        <a href="{{ route('books.search') }}" class="text-blue-500 text-sm font-medium hover:underline mt-2 inline-block">Thêm sách ngay</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Góc Sách.
    </footer>
</body>
</html>