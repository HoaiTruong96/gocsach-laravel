<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân - Góc Sách</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
        }

        /* Nền xám nhẹ cho nổi bật khối nội dung */
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
                <a href="#" class="hover:text-blue-600 transition">Review</a>
                <a href="{{ route('profile') }}" class="text-blue-600 border-b-2 border-blue-600 pb-1">Tài Khoản</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 text-center border border-gray-100 sticky top-24">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <!-- [LOGIC AVATAR] Ưu tiên lấy từ DB, nếu null thì tạo ảnh theo tên -->
                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=128' }}"
                            alt="Avatar"
                            class="rounded-full border-4 border-blue-100 shadow-md object-cover w-full h-full">
                        <button class="absolute bottom-0 right-0 bg-gray-800 text-white p-2 rounded-full text-xs hover:bg-blue-600 transition" title="Đổi ảnh">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <!-- Hiển thị thông tin thật từ biến $user -->
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm mb-4">{{ $user->email }}</p>

                    <div class="flex justify-center space-x-2 mb-6">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs rounded-full font-medium">Thành viên</span>
                        <span class="px-3 py-1 bg-green-50 text-green-600 text-xs rounded-full font-medium">Đang hoạt động</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t border-b border-gray-100 py-4 mb-4">
                        <div>
                            <span class="block font-bold text-lg text-gray-800">12</span>
                            <span class="text-xs text-gray-400 uppercase">Tủ sách</span>
                        </div>
                        <div>
                            <span class="block font-bold text-lg text-gray-800">5</span>
                            <span class="text-xs text-gray-400 uppercase">Review</span>
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition shadow-blue-200 shadow-md mb-2">
                        <i class="fas fa-edit mr-1"></i> Chỉnh sửa hồ sơ
                    </button>

                    <!-- Nút Đăng xuất thật -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full border border-gray-300 text-gray-600 py-2 rounded-lg font-medium hover:bg-gray-50 transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-3">

                <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold border-l-4 border-blue-500 pl-3">Tủ Sách Của Tôi</h3>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium">Tất cả</button>
                        <button class="px-4 py-2 text-gray-500 hover:bg-gray-50 rounded-lg text-sm transition">Đang đọc</button>
                        <button class="px-4 py-2 text-gray-500 hover:bg-gray-50 rounded-lg text-sm transition">Yêu thích</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($myBooks as $book)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-row h-40">
                        <div class="w-28 relative flex-shrink-0">
                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        </div>

                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div>
                                <h4 class="font-bold text-gray-800 line-clamp-2 text-sm mb-1">
                                    <a href="#" class="hover:text-blue-600">{{ $book->title }}</a>
                                </h4>
                                <p class="text-xs text-gray-500 mb-2"><i class="far fa-user mr-1"></i> {{ $book->author }}</p>

                                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: 70%"></div>
                                </div>
                                <p class="text-[10px] text-gray-400 text-right">Đã đọc 70%</p>
                            </div>

                            <div class="flex justify-end space-x-2 mt-2">
                                <button class="text-gray-400 hover:text-red-500 transition text-sm" title="Xóa khỏi tủ">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition">
                                    Đọc tiếp
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                        <i class="fas fa-bookmark text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Tủ sách của bạn đang trống.</p>
                        <a href="/" class="text-blue-500 text-sm font-medium hover:underline mt-2 inline-block">Khám phá sách ngay</a>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Góc Sách. Designed by TTCN-K64 Team.
    </footer>

</body>

</html>