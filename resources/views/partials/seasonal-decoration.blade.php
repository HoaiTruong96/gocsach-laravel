{{--
    Seasonal Decorations Component
    Tự động hiển thị trang trí theo mùa/lễ hội dựa vào ngày hiện tại
    Hoặc theo theme được admin chọn
--}}

@php
    $now = now();
    $month = $now->month;
    $day = $now->day;
    
    // Kiểm tra nếu admin đã chọn theme cụ thể (lưu trong session)
    $overrideTheme = session('admin_theme_override');
    
    if ($overrideTheme && $overrideTheme !== 'auto') {
        $theme = $overrideTheme === 'default' ? null : $overrideTheme;
    } else {
        // Xác định chủ đề tự động theo ngày
        $theme = null;
        
        // 🎄 Giáng Sinh: 20/12 - 26/12
        if ($month == 12 && $day >= 20 && $day <= 26) {
            $theme = 'christmas';
        }
        // 🧧 Tết Nguyên Đán: ~15/01 - 15/02 (ước lượng)
        elseif (($month == 1 && $day >= 15) || ($month == 2 && $day <= 15)) {
            $theme = 'tet';
        }
        // 💕 Valentine: 12/02 - 15/02
        elseif ($month == 2 && $day >= 12 && $day <= 15) {
            $theme = 'valentine';
        }
        // 🎃 Halloween: 25/10 - 01/11
        elseif (($month == 10 && $day >= 25) || ($month == 11 && $day == 1)) {
            $theme = 'halloween';
        }
    }
@endphp

{{-- ADMIN THEME SELECTOR --}}
@if(Auth::check() && Auth::user()->isAdmin())
<div id="admin-theme-selector" class="fixed bottom-6 left-6 z-[9999]">
    {{-- Toggle Button --}}
    <button id="theme-toggle-btn" 
        class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-full shadow-lg flex items-center justify-center hover:scale-110 transition-all duration-300 group"
        title="Chọn Theme Trang Trí">
        <i class="fas fa-palette text-lg"></i>
    </button>
    
    {{-- Dropdown Menu --}}
    <div id="theme-dropdown" class="hidden absolute bottom-16 left-0 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden min-w-[200px] transform scale-95 opacity-0 transition-all duration-200">
        <div class="px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
            <p class="text-xs font-bold uppercase tracking-wider">🎨 Chọn Theme</p>
        </div>
        <div class="py-2">
            <button onclick="setTheme('auto')" class="theme-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center gap-3 {{ !$overrideTheme || $overrideTheme === 'auto' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                <span class="text-lg">🔄</span>
                <div>
                    <span class="font-medium">Tự động</span>
                    <span class="text-xs text-gray-400 block">Theo thời gian</span>
                </div>
            </button>
            <button onclick="setTheme('default')" class="theme-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center gap-3 {{ $overrideTheme === 'default' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                <span class="text-lg">📚</span>
                <div>
                    <span class="font-medium">Mặc định</span>
                    <span class="text-xs text-gray-400 block">Không trang trí</span>
                </div>
            </button>
            <div class="border-t border-gray-100 my-1"></div>
            <button onclick="setTheme('christmas')" class="theme-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center gap-3 {{ $overrideTheme === 'christmas' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                <span class="text-lg">🎄</span>
                <div>
                    <span class="font-medium">Giáng Sinh</span>
                    <span class="text-xs text-gray-400 block">Bông tuyết, cây thông</span>
                </div>
            </button>
            <button onclick="setTheme('tet')" class="theme-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center gap-3 {{ $overrideTheme === 'tet' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                <span class="text-lg">🧧</span>
                <div>
                    <span class="font-medium">Tết Nguyên Đán</span>
                    <span class="text-xs text-gray-400 block">Hoa đào, phong bao</span>
                </div>
            </button>
            <button onclick="setTheme('valentine')" class="theme-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center gap-3 {{ $overrideTheme === 'valentine' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                <span class="text-lg">💕</span>
                <div>
                    <span class="font-medium">Valentine</span>
                    <span class="text-xs text-gray-400 block">Trái tim, hoa hồng</span>
                </div>
            </button>
            <button onclick="setTheme('halloween')" class="theme-option w-full px-4 py-2.5 text-left hover:bg-gray-50 flex items-center gap-3 {{ $overrideTheme === 'halloween' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                <span class="text-lg">🎃</span>
                <div>
                    <span class="font-medium">Halloween</span>
                    <span class="text-xs text-gray-400 block">Bí ngô, dơi bay</span>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
    // Toggle dropdown
    document.getElementById('theme-toggle-btn').addEventListener('click', function() {
        const dropdown = document.getElementById('theme-dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
                dropdown.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            dropdown.classList.add('scale-95', 'opacity-0');
            dropdown.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    });

    // Close dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        const selector = document.getElementById('admin-theme-selector');
        const dropdown = document.getElementById('theme-dropdown');
        if (selector && !selector.contains(e.target) && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('scale-95', 'opacity-0');
            dropdown.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    });

    // Set theme via AJAX
    function setTheme(theme) {
        fetch('{{ route("admin.set-theme") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ theme: theme })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endif

@if($theme)
<div id="seasonal-decoration" class="fixed inset-0 pointer-events-none z-[9990] overflow-hidden">
    
    @if($theme === 'christmas')
        {{-- ❄️ Bông tuyết rơi --}}
        <div class="snowflakes" aria-hidden="true">
            @for($i = 0; $i < 12; $i++)
                <div class="snowflake">
                    <div class="inner">❄</div>
                </div>
            @endfor
        </div>
        {{-- 🎄 Cây thông góc trái --}}
        <div class="absolute bottom-0 left-0 text-6xl opacity-20 transform -translate-x-1/4">🎄</div>
        {{-- 🎅 Ông già Noel góc phải --}}
        <div class="absolute top-20 right-4 text-4xl opacity-30 animate-bounce">🎅</div>
    @endif

    @if($theme === 'tet')
        {{-- 🌸 Hoa đào/mai rơi --}}
        <div class="petals" aria-hidden="true">
            @for($i = 0; $i < 15; $i++)
                <div class="petal">🌸</div>
            @endfor
        </div>
        {{-- 🧧 Phong bao góc --}}
        <div class="absolute top-20 right-4 text-4xl opacity-40 animate-pulse">🧧</div>
        <div class="absolute bottom-10 left-4 text-5xl opacity-25">🏮</div>
    @endif

    @if($theme === 'valentine')
        {{-- 💕 Trái tim bay --}}
        <div class="hearts" aria-hidden="true">
            @for($i = 0; $i < 10; $i++)
                <div class="heart">💕</div>
            @endfor
        </div>
        {{-- 🌹 Hoa hồng góc --}}
        <div class="absolute bottom-0 right-0 text-5xl opacity-25 transform translate-x-1/4">🌹</div>
    @endif

    @if($theme === 'halloween')
        {{-- 🦇 Dơi bay --}}
        <div class="bats" aria-hidden="true">
            @for($i = 0; $i < 8; $i++)
                <div class="bat">🦇</div>
            @endfor
        </div>
        {{-- 🎃 Bí ngô góc --}}
        <div class="absolute bottom-0 left-4 text-6xl opacity-30">🎃</div>
        <div class="absolute top-20 right-4 text-4xl opacity-40">👻</div>
    @endif

</div>

<style>
/* ============================================
   CHRISTMAS - Bông tuyết rơi
============================================ */
.snowflakes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.snowflake {
    position: absolute;
    top: -10%;
    color: #a8d4ff;
    font-size: 1.5rem;
    animation: snowfall linear infinite;
    opacity: 0.7;
}

.snowflake:nth-child(1) { left: 5%; animation-duration: 10s; animation-delay: 0s; font-size: 1.2rem; }
.snowflake:nth-child(2) { left: 15%; animation-duration: 12s; animation-delay: 1s; font-size: 1.8rem; }
.snowflake:nth-child(3) { left: 25%; animation-duration: 8s; animation-delay: 2s; font-size: 1rem; }
.snowflake:nth-child(4) { left: 35%; animation-duration: 14s; animation-delay: 0.5s; font-size: 1.5rem; }
.snowflake:nth-child(5) { left: 45%; animation-duration: 9s; animation-delay: 3s; font-size: 1.3rem; }
.snowflake:nth-child(6) { left: 55%; animation-duration: 11s; animation-delay: 1.5s; font-size: 1.6rem; }
.snowflake:nth-child(7) { left: 65%; animation-duration: 13s; animation-delay: 2.5s; font-size: 1.1rem; }
.snowflake:nth-child(8) { left: 75%; animation-duration: 10s; animation-delay: 0.8s; font-size: 1.4rem; }
.snowflake:nth-child(9) { left: 85%; animation-duration: 15s; animation-delay: 3.5s; font-size: 1.7rem; }
.snowflake:nth-child(10) { left: 92%; animation-duration: 7s; animation-delay: 1.2s; font-size: 1rem; }
.snowflake:nth-child(11) { left: 10%; animation-duration: 16s; animation-delay: 4s; font-size: 1.9rem; }
.snowflake:nth-child(12) { left: 50%; animation-duration: 11s; animation-delay: 2s; font-size: 1.2rem; }

@keyframes snowfall {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 0.7;
    }
    100% {
        transform: translateY(110vh) rotate(360deg);
        opacity: 0.3;
    }
}

/* ============================================
   TET - Hoa đào/mai rơi
============================================ */
.petals {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.petal {
    position: absolute;
    top: -10%;
    font-size: 1.2rem;
    animation: petalfall linear infinite;
    opacity: 0.8;
}

.petal:nth-child(1) { left: 8%; animation-duration: 12s; animation-delay: 0s; }
.petal:nth-child(2) { left: 18%; animation-duration: 10s; animation-delay: 1s; }
.petal:nth-child(3) { left: 28%; animation-duration: 14s; animation-delay: 2s; }
.petal:nth-child(4) { left: 38%; animation-duration: 11s; animation-delay: 0.5s; }
.petal:nth-child(5) { left: 48%; animation-duration: 13s; animation-delay: 3s; }
.petal:nth-child(6) { left: 58%; animation-duration: 9s; animation-delay: 1.5s; }
.petal:nth-child(7) { left: 68%; animation-duration: 15s; animation-delay: 2.5s; }
.petal:nth-child(8) { left: 78%; animation-duration: 10s; animation-delay: 0.8s; }
.petal:nth-child(9) { left: 88%; animation-duration: 12s; animation-delay: 3.5s; }
.petal:nth-child(10) { left: 95%; animation-duration: 8s; animation-delay: 1.2s; }
.petal:nth-child(11) { left: 3%; animation-duration: 16s; animation-delay: 4s; }
.petal:nth-child(12) { left: 33%; animation-duration: 11s; animation-delay: 2s; }
.petal:nth-child(13) { left: 63%; animation-duration: 13s; animation-delay: 1s; }
.petal:nth-child(14) { left: 73%; animation-duration: 14s; animation-delay: 3s; }
.petal:nth-child(15) { left: 83%; animation-duration: 10s; animation-delay: 0s; }

@keyframes petalfall {
    0% {
        transform: translateY(0) rotate(0deg) translateX(0);
        opacity: 0.8;
    }
    50% {
        transform: translateY(50vh) rotate(180deg) translateX(30px);
    }
    100% {
        transform: translateY(110vh) rotate(360deg) translateX(-30px);
        opacity: 0.4;
    }
}

/* ============================================
   VALENTINE - Trái tim bay lên
============================================ */
.hearts {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.heart {
    position: absolute;
    bottom: -10%;
    font-size: 1.5rem;
    animation: heartrise linear infinite;
    opacity: 0.6;
}

.heart:nth-child(1) { left: 10%; animation-duration: 12s; animation-delay: 0s; }
.heart:nth-child(2) { left: 20%; animation-duration: 10s; animation-delay: 1s; }
.heart:nth-child(3) { left: 30%; animation-duration: 14s; animation-delay: 2s; }
.heart:nth-child(4) { left: 40%; animation-duration: 11s; animation-delay: 0.5s; }
.heart:nth-child(5) { left: 50%; animation-duration: 13s; animation-delay: 3s; }
.heart:nth-child(6) { left: 60%; animation-duration: 9s; animation-delay: 1.5s; }
.heart:nth-child(7) { left: 70%; animation-duration: 15s; animation-delay: 2.5s; }
.heart:nth-child(8) { left: 80%; animation-duration: 10s; animation-delay: 0.8s; }
.heart:nth-child(9) { left: 90%; animation-duration: 12s; animation-delay: 3.5s; }
.heart:nth-child(10) { left: 5%; animation-duration: 8s; animation-delay: 1.2s; }

@keyframes heartrise {
    0% {
        transform: translateY(0) scale(0.8);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-50vh) scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: translateY(-110vh) scale(0.5);
        opacity: 0;
    }
}

/* ============================================
   HALLOWEEN - Dơi bay
============================================ */
.bats {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.bat {
    position: absolute;
    font-size: 1.8rem;
    animation: batfly linear infinite;
    opacity: 0.5;
}

.bat:nth-child(1) { top: 10%; left: -10%; animation-duration: 8s; animation-delay: 0s; }
.bat:nth-child(2) { top: 20%; left: -10%; animation-duration: 10s; animation-delay: 1s; }
.bat:nth-child(3) { top: 30%; left: -10%; animation-duration: 7s; animation-delay: 2s; }
.bat:nth-child(4) { top: 15%; left: -10%; animation-duration: 9s; animation-delay: 0.5s; }
.bat:nth-child(5) { top: 25%; left: -10%; animation-duration: 11s; animation-delay: 3s; }
.bat:nth-child(6) { top: 35%; left: -10%; animation-duration: 8s; animation-delay: 1.5s; }
.bat:nth-child(7) { top: 5%; left: -10%; animation-duration: 12s; animation-delay: 2.5s; }
.bat:nth-child(8) { top: 40%; left: -10%; animation-duration: 6s; animation-delay: 0.8s; }

@keyframes batfly {
    0% {
        transform: translateX(0) translateY(0) rotate(0deg);
        opacity: 0.5;
    }
    25% {
        transform: translateX(25vw) translateY(-20px) rotate(-5deg);
    }
    50% {
        transform: translateX(50vw) translateY(10px) rotate(5deg);
    }
    75% {
        transform: translateX(75vw) translateY(-15px) rotate(-3deg);
    }
    100% {
        transform: translateX(110vw) translateY(0) rotate(0deg);
        opacity: 0.3;
    }
}

/* Giảm hiệu ứng trên mobile để tối ưu performance */
@media (max-width: 768px) {
    .snowflake:nth-child(n+7),
    .petal:nth-child(n+8),
    .heart:nth-child(n+6),
    .bat:nth-child(n+5) {
        display: none;
    }
    
    .snowflake, .petal, .heart, .bat {
        font-size: 1rem !important;
    }
}
</style>
@endif
