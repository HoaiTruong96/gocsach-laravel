<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sách - Cây Cam Ngọt Của Tôi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#3E5F4E',
                        'brand-cream': '#FDFBF7',
                        'brand-beige': '#F3E5D0',
                        'brand-brown': '#8C6B4B',
                        'brand-accent': '#D4A373',
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'Roboto', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body { background-color: #FDFBF7; color: #2C3E36; }
    </style>
</head>
<body class="font-sans antialiased flex flex-col min-h-screen">

    <header class="bg-brand-cream sticky top-0 z-50 border-b border-gray-200/50 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <a href="{{ route('home') }}" class="text-brand-green text-2xl font-bold flex items-center gap-2">
                    <span class="text-3xl">📚</span>
                    <span class="tracking-wide">GÓC SÁCH</span>
                </a>
            </div>
            <div class="hidden md:flex flex-1 mx-10 max-w-lg">
                <div class="relative w-full">
                    <input type="text" placeholder="Tìm kiếm sách, tác giả..." 
                           class="w-full bg-[#EBE5D9] rounded-full py-2 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green text-gray-700 placeholder-gray-500">
                    <button class="absolute right-4 top-2.5 text-gray-500 hover:text-brand-green">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <nav class="flex items-center space-x-6 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-brand-green transition">Trang Chủ</a>
                <a href="{{ route('list') }}" class="hover:text-brand-green transition">Thể Loại</a>
                <a href="#" class="text-brand-green font-bold">Đăng Nhập</a>
            </nav>
        </div>
    </header>

    <div class="bg-brand-beige/30 py-4 border-b border-brand-beige">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-brand-green">Trang chủ</a>
                <span class="mx-2 text-gray-300">/</span>
                <a href="{{ route('list') }}" class="hover:text-brand-green">Văn Học</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-brand-green font-bold">Cây Cam Ngọt Của Tôi</span>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8 flex-grow">
        
        <div class="bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                
                <div class="md:col-span-4 lg:col-span-3">
                    <div class="relative rounded-lg overflow-hidden shadow-2xl transform hover:scale-[1.02] transition duration-500">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=800" 
                             class="w-full object-cover aspect-[2/3]">
                    </div>
                </div>

                <div class="md:col-span-8 lg:col-span-9 flex flex-col">
                    <div class="mb-4">
                        <span class="text-brand-accent text-xs font-bold uppercase tracking-wider">Văn Học Kinh Điển</span>
                        <h1 class="text-3xl md:text-4xl font-bold text-brand-green font-serif mt-2 mb-2 leading-tight">
                            Cây Cam Ngọt Của Tôi
                        </h1>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-gray-500">Tác giả: <a href="#author" class="text-brand-green font-semibold hover:underline">José Mauro de Vasconcelos</a></span>
                            <span class="text-gray-300">|</span>
                            <a href="#" class="flex items-center text-yellow-400 hover:opacity-80 transition cursor-pointer">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-500 ml-1 hover:text-brand-green hover:underline">(4.9/5 từ 1.2k đánh giá)</span>
                            </a>
                        </div>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3">
                        "Vị chua chát của cái nghèo hòa trộn với vị ngọt ngào của trí tưởng tượng..." Một cuốn sách lấy đi nước mắt của hàng triệu độc giả trên toàn thế giới. Câu chuyện về cậu bé Zezé thông minh, tinh nghịch nhưng cô đơn...
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 text-sm text-gray-600">
                        <div><p class="text-gray-400 text-xs mb-1">Nhà xuất bản</p><p class="font-semibold">Hội Nhà Văn</p></div>
                        <div><p class="text-gray-400 text-xs mb-1">Năm xuất bản</p><p class="font-semibold">2023</p></div>
                        <div><p class="text-gray-400 text-xs mb-1">Số trang</p><p class="font-semibold">244 trang</p></div>
                        <div><p class="text-gray-400 text-xs mb-1">Hình thức</p><p class="font-semibold">Bìa mềm</p></div>
                    </div>

                    <div class="mt-auto flex flex-col sm:flex-row gap-4 items-center">
                        
                        <a href="#" class="group flex items-center justify-center gap-2 px-8 py-3 rounded-lg border-2 border-brand-green text-brand-green font-bold hover:bg-brand-green hover:text-white transition-all duration-300 min-w-[200px]">
                            <i class="far fa-comments text-lg"></i>
                            <span>Xem Các Bài Review</span>
                        </a>

                        <a href="https://tiki.vn" target="_blank" class="flex items-center justify-center gap-2 px-8 py-3 rounded-lg bg-brand-green text-white font-bold shadow-lg hover:bg-[#2C3E36] hover:-translate-y-0.5 transition-all duration-300 min-w-[200px]">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Xem Nơi Bán</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-brand-green font-serif mb-6 flex items-center gap-2 pb-3 border-b border-gray-100">
                        <i class="fas fa-align-left"></i> Giới Thiệu Sách
                    </h2>
                    <div class="prose prose-stone max-w-none text-gray-700 leading-7">
                        <p class="mb-4">
                            <strong>Cây Cam Ngọt Của Tôi</strong> là một tác phẩm văn học kinh điển dành cho thiếu nhi nhưng lại chạm đến trái tim của người lớn. Cuốn sách kể về cậu bé Zezé 5 tuổi, sinh ra trong một gia đình nghèo đông con ở Brazil.
                        </p>
                        <p class="mb-4">
                            Zezé thông minh, nhạy cảm và có trí tưởng tượng phong phú, nhưng em cũng rất nghịch ngợm. Chính vì sự nghịch ngợm đó mà em thường xuyên bị đòn roi. Trong thế giới cô đơn của mình, Zezé tìm thấy một người bạn đặc biệt: một cây cam ngọt sau vườn nhà mà em đặt tên là Minguinho.
                        </p>
                        <blockquote class="border-l-4 border-brand-accent pl-4 italic bg-brand-cream/50 p-4 rounded my-6 text-gray-600">
                            "Mẹ ơi, đáng lẽ con không nên được sinh ra trên đời này..." - Câu nói xé lòng của Zezé khiến bất cứ ai đọc cũng phải rơi lệ.
                        </blockquote>
                        <p>
                            Cuốn sách không chỉ là câu chuyện về nỗi đau, sự nghèo đói mà còn là bài ca về tình yêu thương, lòng trắc ẩn và sự thấu hiểu. Nó dạy chúng ta rằng: "Ai đã yêu mến thì sẽ không bao giờ làm tổn thương người mình yêu".
                        </p>
                    </div>
                </div>
                
                </div>

            <div class="lg:col-span-4 space-y-8">
                
                <div id="author" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4 pb-2 border-b border-gray-100">
                        Thông Tin Tác Giả
                    </h3>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-brand-beige mb-4 shadow-sm">
                            <img src="https://images.gr-assets.com/authors/1614710185p8/4336024.jpg" alt="José Mauro" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-bold text-xl text-gray-800 font-serif mb-1">José Mauro</h4>
                        <span class="text-xs text-brand-brown font-bold uppercase tracking-wide mb-3">Nhà văn Brazil</span>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4">
                            (1920 - 1984) Ông là nhà văn người Brazil. Ông mang trong mình dòng máu thổ dân, Bồ Đào Nha. Các tác phẩm của ông thường mang màu sắc tự truyện.
                        </p>
                        <button class="text-brand-green text-sm font-bold border border-brand-green rounded-full px-4 py-1 hover:bg-brand-green hover:text-white transition">
                            Xem thêm tác phẩm
                        </button>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-brand-green font-serif text-lg mb-4">Có Thể Bạn Thích</h3>
                    <div class="space-y-4">
                        <a href="#" class="flex gap-3 group bg-white p-3 rounded-lg border border-gray-100 hover:shadow-md transition">
                            <div class="w-16 flex-shrink-0"><img src="https://images.unsplash.com/photo-1629198688000-71f23e745b6e?auto=format&fit=crop&q=80&w=200" class="w-full rounded object-cover aspect-[2/3]"></div>
                            <div><h4 class="font-bold text-gray-800 text-sm font-serif group-hover:text-brand-green transition line-clamp-2">Hoàng Tử Bé</h4><p class="text-xs text-gray-500 mt-1">Saint-Exupéry</p><div class="flex items-center gap-1 text-xs text-yellow-400 mt-2"><i class="fas fa-star"></i> 4.9</div></div>
                        </a>
                        <a href="#" class="flex gap-3 group bg-white p-3 rounded-lg border border-gray-100 hover:shadow-md transition">
                            <div class="w-16 flex-shrink-0"><img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=200" class="w-full rounded object-cover aspect-[2/3]"></div>
                            <div><h4 class="font-bold text-gray-800 text-sm font-serif group-hover:text-brand-green transition line-clamp-2">Nhà Giả Kim</h4><p class="text-xs text-gray-500 mt-1">Paulo Coelho</p><div class="flex items-center gap-1 text-xs text-yellow-400 mt-2"><i class="fas fa-star"></i> 4.8</div></div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-[#2C3E36] text-white pt-16 pb-8 relative overflow-hidden mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="space-y-4">
                    <div class="flex flex-col items-start">
                        <div class="mb-2"><i class="fas fa-book-open text-4xl text-[#E9EDC9]"></i></div>
                        <h3 class="font-bold text-lg leading-tight">Mọt Sách Review</h3>
                    </div>
                </div>
                <div><h4 class="font-bold mb-6 text-white text-lg">Liên Kết</h4><ul class="space-y-3 text-sm text-gray-300"><li>Về chúng tôi</li><li>Liên hệ</li></ul></div>
                <div><h4 class="font-bold mb-6 text-white text-lg">Thể Loại</h4><ul class="space-y-3 text-sm text-gray-300"><li>Tiểu thuyết</li><li>Kinh tế</li></ul></div>
                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Đăng Ký Nhận Tin</h4>
                    <form onsubmit="event.preventDefault();" class="flex mb-6"><input type="email" placeholder="Email..." class="w-full px-4 py-2 text-gray-800 rounded-l text-sm focus:outline-none"><button class="bg-[#8C6B4B] hover:bg-[#6e5338] text-white font-bold px-4 py-2 rounded-r text-sm transition">Đăng Ký</button></form>
                </div>
            </div>
            <div class="border-t border-gray-600 pt-8 text-center text-xs text-gray-400">Copyright © 2025 Mọt Sách Review</div>
        </div>
    </footer>
</body>
</html>