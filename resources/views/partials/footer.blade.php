<div class="relative mt-20">
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none z-10 transform -translate-y-full">
        <svg class="relative block w-full h-12 md:h-16 text-[#2C3E36]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
        </svg>
    </div>

    <footer class="bg-[#2C3E36] text-white pt-16 pb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-green-light/20 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-accent/10 rounded-full blur-[80px] -ml-10 -mb-10 pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="space-y-4">
                    <div class="flex flex-col items-start">
                        <div class="mb-2"><i class="fas fa-book-open text-4xl text-[#E9EDC9]"></i></div>
                        <h3 class="font-bold text-lg leading-tight">Góc Sách Review</h3>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Nơi kết nối những tâm hồn yêu sách. Chia sẻ cảm nhận, lan tỏa tri thức và tìm kiếm cuốn sách thay đổi cuộc đời bạn.
                    </p>
                    <div class="flex gap-4 pt-2">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#D4A373] hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#D4A373] hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-twitter text-xs"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#D4A373] hover:text-white transition transform hover:-translate-y-1"><i class="fab fa-instagram text-xs"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Liên Kết Nhanh</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs"></i> Trang chủ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.about') }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs"></i> Về chúng tôi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.terms') }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs"></i> Điều khoản sử dụng
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.privacy') }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs"></i> Chính sách bảo mật
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.contact') }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs"></i> Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Thể Loại Phổ Biến</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li>
                            {{-- Link tới danh sách, lọc theo slug 'tieu-thuyet' (khớp với Database của bạn) --}}
                            <a href="{{ route('books.list', ['category' => 'tieu-thuyet']) }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-book text-xs opacity-50"></i> Tiểu thuyết
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.list', ['category' => 'kinh-te']) }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-book text-xs opacity-50"></i> Kinh tế & Kinh doanh
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.list', ['category' => 'tam-ly-ky-nang-song']) }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-book text-xs opacity-50"></i> Tâm lý - Kỹ năng
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.list', ['category' => 'van-hoc-nuoc-ngoai']) }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-book text-xs opacity-50"></i> Văn học kinh điển
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.list', ['category' => 'thieu-nhi']) }}" class="hover:text-white transition flex items-center gap-2">
                                <i class="fas fa-book text-xs opacity-50"></i> Thiếu nhi
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-6 text-white text-lg">Đăng Ký Nhận Tin</h4>
                    <p class="text-xs text-gray-300 mb-4 leading-relaxed">Nhận thông báo về sách mới, sự kiện offline và các bài viết hay hàng tuần.</p>
                    <form onsubmit="event.preventDefault();" class="flex flex-col gap-3">
                        <input type="email" placeholder="Email của bạn..." class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-sm focus:outline-none focus:border-[#D4A373] text-white placeholder-gray-400 transition">
                        <button class="bg-[#8C6B4B] hover:bg-[#6e5338] text-white font-bold px-4 py-3 rounded-lg text-sm transition shadow-lg flex justify-center items-center gap-2">
                            <i class="fas fa-paper-plane text-xs"></i> Đăng Ký Ngay
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-600/50 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-400">
                <p>Copyright © {{ date('Y') }} Góc Sách Review. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="{{ route('page.privacy') }}" class="hover:text-white transition">Privacy Policy</a>
                    <a href="{{ route('page.terms') }}" class="hover:text-white transition">Terms of Service</a>
                    <a href="#" class="hover:text-white transition">Cookie Settings</a>
                </div>
            </div>
        </div>
    </footer>
</div>

{{-- Back to Top Button --}}
<button id="back-to-top" 
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-brand-green text-white rounded-full shadow-lg opacity-0 invisible transform translate-y-4 transition-all duration-300 hover:bg-brand-accent hover:scale-110 hover:shadow-xl flex items-center justify-center group"
        aria-label="Back to top">
    <i class="fas fa-chevron-up group-hover:animate-bounce"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible', 'translate-y-4');
                backToTopBtn.classList.add('opacity-100', 'visible', 'translate-y-0');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible', 'translate-y-4');
                backToTopBtn.classList.remove('opacity-100', 'visible', 'translate-y-0');
            }
        });
        
        // Smooth scroll to top
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>