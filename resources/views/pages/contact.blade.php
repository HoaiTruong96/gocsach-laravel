@extends('layouts.app')

@section('title', 'Liên Hệ')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row">
            
            {{-- Cột Thông tin --}}
            <div class="bg-brand-green text-white p-10 md:w-2/5 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-6">Thông tin liên hệ</h2>
                    <p class="text-white/80 mb-8 text-sm">Nếu bạn có bất kỳ câu hỏi hoặc góp ý nào, đừng ngần ngại liên hệ với chúng tôi.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Địa chỉ</h4>
                                <p class="text-xs text-white/80 mt-1">123 Đường Sách, Quận 1, TP. Hồ Chí Minh</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Điện thoại</h4>
                                <p class="text-xs text-white/80 mt-1">1900 1234</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Email</h4>
                                <p class="text-xs text-white/80 mt-1">contact@gocsach.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <p class="text-sm font-bold mb-4">Theo dõi chúng tôi</p>
                    <div class="flex gap-4">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="hover:text-brand-accent transition"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="hover:text-brand-accent transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="hover:text-brand-accent transition"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
            </div>

            {{-- Cột Form --}}
            <div class="p-10 md:w-3/5">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Gửi tin nhắn</h2>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Họ tên</label>
                            <input type="text" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green transition" placeholder="Nhập tên của bạn">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green transition" placeholder="example@mail.com">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nội dung</label>
                        <textarea rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-brand-green transition resize-none" placeholder="Bạn muốn nhắn gửi điều gì?"></textarea>
                    </div>

                    <button type="button" onclick="alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.')" class="bg-brand-accent hover:bg-[#c29263] text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                        Gửi Tin Nhắn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection