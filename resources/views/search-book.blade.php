<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm Sách - Góc Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-red-700 text-2xl font-bold flex items-center">
                <i class="fas fa-book-reader mr-2"></i> Góc Sách
            </a>
            <a href="/" class="text-blue-600 font-medium">Trang Chủ</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tìm Sách Để Review</h1>
            <p class="text-gray-500">Chọn một cuốn sách bạn muốn chia sẻ cảm nhận</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm mb-8">
            <form action="{{ route('books.search') }}" method="GET" class="flex gap-2">
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                       class="flex-grow p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Nhập tên sách...">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                    <i class="fas fa-search mr-1"></i> Tìm
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                    <div class="relative">
                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x450' }}" 
                             class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ url('/book/' . $book->id) }}" class="bg-yellow-400 text-black px-4 py-2 rounded-full font-bold shadow-lg hover:scale-105 transform transition">
                                <i class="fas fa-pen mr-1"></i> Viết Review
                            </a>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 line-clamp-1 mb-1">{{ $book->title }}</h3>
                        <a href="{{ url('/book/' . $book->id) }}" class="block w-full text-center border border-blue-600 text-blue-600 py-1.5 rounded mt-3 text-sm font-bold hover:bg-blue-50">
                            Chọn
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    <i class="fas fa-search text-4xl mb-2 text-gray-300"></i>
                    <p>Không tìm thấy sách nào.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>