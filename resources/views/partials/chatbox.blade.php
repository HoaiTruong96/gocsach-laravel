{{-- AI Chatbox Component --}}
<div id="chatbox-container" class="fixed bottom-6 right-6 z-[9998] sm:bottom-6 sm:right-6">
    
    {{-- Chat Window - Responsive: compact on mobile, larger on desktop --}}
    <div id="chatbox-window" class="hidden absolute bottom-14 right-0 w-[90vw] sm:w-[420px] max-w-[420px] h-[70vh] sm:h-auto sm:max-h-[600px] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 origin-bottom-right scale-95 opacity-0 flex flex-col">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand-green to-emerald-600 text-white p-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-robot text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Trợ lý Góc Sách</h4>
                    <p class="text-[10px] text-white/80 flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Đang hoạt động
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @auth
                <button onclick="clearChatHistory()" title="Xóa lịch sử" class="w-8 h-8 rounded-full hover:bg-white/20 flex items-center justify-center transition">
                    <i class="fas fa-trash-alt text-sm"></i>
                </button>
                @endauth
                <button onclick="toggleChatbox()" class="w-10 h-10 sm:w-8 sm:h-8 rounded-full hover:bg-white/20 flex items-center justify-center transition">
                    <i class="fas fa-times text-lg sm:text-base"></i>
                </button>
            </div>
        </div>

        {{-- Messages Area - Flexible height --}}
        <div id="chatbox-messages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 min-h-0">
            {{-- Welcome Message --}}
            <div class="flex gap-3">
                <div class="w-8 h-8 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-xs"></i>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm max-w-[85%] sm:max-w-[80%]">
                    <p class="text-sm text-gray-700">Xin chào! Tôi là trợ lý AI của Góc Sách. Tôi có thể giúp bạn tìm sách hay, gợi ý đọc theo sở thích. Bạn cần gì nào?</p>
                </div>
            </div>
            
            {{-- Quick Replies - Gợi ý nhanh --}}
            <div id="quick-replies" class="flex flex-wrap gap-2 mt-2">
                <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Gợi ý sách hay">
                    Gợi ý sách hay
                </button>
                <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Có bao nhiêu sách">
                    Thống kê
                </button>
                <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Làm sao để viết review">
                    Cách viết review
                </button>
                <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Tủ sách cá nhân là gì">
                    Về tủ sách
                </button>
            </div>
        </div>

        {{-- Typing Indicator (hidden by default) --}}
        <div id="typing-indicator" class="hidden px-4 py-2 bg-gray-50 flex-shrink-0">
            <div class="flex gap-3 items-center">
                <div class="w-8 h-8 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-xs"></i>
                </div>
                <div class="flex gap-1">
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="p-4 bg-white border-t border-gray-100 flex-shrink-0 safe-area-bottom">
            <form id="chatbox-form" class="flex gap-2">
                @csrf
                <input type="text" id="chatbox-input" 
                    placeholder="Nhập tin nhắn..." 
                    autocomplete="off"
                    class="flex-1 px-4 py-3 bg-gray-100 rounded-xl text-base sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/30 transition">
                <button type="submit" id="chatbox-send"
                    class="w-12 h-12 bg-brand-green hover:bg-emerald-700 text-white rounded-xl flex items-center justify-center transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 text-center mt-2">Powered by Gemini AI</p>
        </div>

        {{-- Custom Confirm Modal --}}
        <div id="chatbox-confirm-modal" class="hidden absolute inset-0 bg-black/50 flex items-center justify-center z-50 rounded-2xl">
            <div class="bg-white rounded-xl p-5 mx-4 max-w-[280px] shadow-xl transform transition-all">
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-trash-alt text-red-500 text-lg"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Xóa lịch sử?</h4>
                    <p class="text-sm text-gray-500 mb-4">Bạn có chắc muốn xóa toàn bộ lịch sử trò chuyện?</p>
                    <div class="flex gap-3">
                        <button onclick="hideConfirmModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                            Hủy
                        </button>
                        <button onclick="confirmClearHistory()" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-medium">
                            Xóa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Floating Button - Smaller size --}}
    <button onclick="toggleChatbox()" id="chatbox-toggle"
        class="w-11 h-11 bg-gradient-to-br from-brand-green to-emerald-600 text-white rounded-full shadow-lg flex items-center justify-center hover:shadow-xl hover:scale-110 transition-all duration-300 relative">
        <i id="chatbox-icon-open" class="fas fa-comments text-base"></i>
        <i id="chatbox-icon-close" class="fas fa-times text-base hidden"></i>
        {{-- Pulse Animation - only shows when closed --}}
        <span id="chatbox-pulse" class="absolute w-full h-full rounded-full bg-brand-green animate-ping opacity-20"></span>
    </button>
</div>

<script>
    let chatHistory = [];
    let isOpen = false;
    let historyLoaded = false;
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

    // Tải lịch sử chat từ database
    async function loadChatHistory() {
        if (!isLoggedIn || historyLoaded) return;
        
        try {
            const response = await fetch('{{ route("chatbot.history") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const data = await response.json();
            
            if (data.success && data.messages.length > 0) {
                // Ẩn quick replies nếu có lịch sử
                document.getElementById('quick-replies').style.display = 'none';
                
                // Hiển thị các tin nhắn cũ
                data.messages.forEach(msg => {
                    addMessage(msg.content, msg.role === 'user', msg.created_at);
                    chatHistory.push({ role: msg.role, content: msg.content });
                });
            }
            historyLoaded = true;
        } catch (error) {
            console.error('Error loading chat history:', error);
        }
    }

    // Hiển thị modal xác nhận xóa
    function clearChatHistory() {
        document.getElementById('chatbox-confirm-modal').classList.remove('hidden');
    }

    // Ẩn modal
    function hideConfirmModal() {
        document.getElementById('chatbox-confirm-modal').classList.add('hidden');
    }

    // Xác nhận xóa lịch sử
    async function confirmClearHistory() {
        hideConfirmModal();
        
        try {
            const response = await fetch('{{ route("chatbot.clear") }}', {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const data = await response.json();
            
            if (data.success) {
                // Reset UI
                chatHistory = [];
                historyLoaded = false;
                const container = document.getElementById('chatbox-messages');
                container.innerHTML = `
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-robot text-white text-xs"></i>
                        </div>
                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm max-w-[85%] sm:max-w-[80%]">
                            <p class="text-sm text-gray-700">Xin chào! Tôi là trợ lý AI của Góc Sách. Tôi có thể giúp bạn tìm sách hay, gợi ý đọc theo sở thích. Bạn cần gì nào?</p>
                        </div>
                    </div>
                    <div id="quick-replies" class="flex flex-wrap gap-2 mt-2">
                        <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Gợi ý sách hay">Gợi ý sách hay</button>
                        <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Có bao nhiêu sách">Thống kê</button>
                        <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Làm sao để viết review">Cách viết review</button>
                        <button class="quick-reply-btn px-3 py-1.5 bg-white border border-brand-green text-brand-green rounded-full text-xs hover:bg-brand-green hover:text-white transition-all duration-200" data-message="Tủ sách cá nhân là gì">Về tủ sách</button>
                    </div>
                `;
                // Re-attach quick reply listeners
                attachQuickReplyListeners();
            }
        } catch (error) {
            console.error('Error clearing chat history:', error);
        }
    }

    function toggleChatbox() {
        const window = document.getElementById('chatbox-window');
        const toggle = document.getElementById('chatbox-toggle');
        const iconOpen = document.getElementById('chatbox-icon-open');
        const iconClose = document.getElementById('chatbox-icon-close');
        const pulse = document.getElementById('chatbox-pulse');
        isOpen = !isOpen;

        if (isOpen) {
            window.classList.remove('hidden');
            setTimeout(() => {
                window.classList.remove('scale-95', 'opacity-0');
                window.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.getElementById('chatbox-input').focus();
            // Switch to X icon
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            pulse.classList.add('hidden');
            // Load lịch sử chat khi mở
            loadChatHistory();
        } else {
            window.classList.remove('scale-100', 'opacity-100');
            window.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                window.classList.add('hidden');
            }, 300);
            // Switch back to comments icon
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
            pulse.classList.remove('hidden');
        }
    }

    function addMessage(content, isUser = false, timestamp = null) {
        const container = document.getElementById('chatbox-messages');
        const timeStr = formatTime(timestamp);
        const messageHtml = isUser 
            ? `<div class="flex gap-3 justify-end">
                    <div class="max-w-[80%]">
                        <div class="bg-brand-green text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-sm">
                            <p class="text-sm">${escapeHtml(content)}</p>
                        </div>
                        <p class="text-[10px] text-gray-400 text-right mt-1">${timeStr}</p>
                    </div>
               </div>`
            : `<div class="flex gap-3">
                    <div class="w-8 h-8 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-robot text-white text-xs"></i>
                    </div>
                    <div class="max-w-[80%]">
                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                            <p class="text-sm text-gray-700">${formatMessage(content)}</p>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">${timeStr}</p>
                    </div>
               </div>`;
        
        container.insertAdjacentHTML('beforeend', messageHtml);
        container.scrollTop = container.scrollHeight;
    }

    // Format thời gian hiển thị
    function formatTime(timestamp) {
        if (!timestamp) {
            // Tin nhắn mới - lấy thời gian hiện tại
            const now = new Date();
            return now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        }
        // Tin nhắn từ lịch sử
        const date = new Date(timestamp);
        const now = new Date();
        const isToday = date.toDateString() === now.toDateString();
        
        if (isToday) {
            return date.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        } else {
            return date.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' }) + ' ' + 
                   date.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatMessage(text) {
        // Convert markdown-like formatting
        return escapeHtml(text)
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');
    }

    function showTyping() {
        document.getElementById('typing-indicator').classList.remove('hidden');
        document.getElementById('chatbox-messages').scrollTop = document.getElementById('chatbox-messages').scrollHeight;
    }

    function hideTyping() {
        document.getElementById('typing-indicator').classList.add('hidden');
    }

    document.getElementById('chatbox-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const input = document.getElementById('chatbox-input');
        const sendBtn = document.getElementById('chatbox-send');
        const message = input.value.trim();
        
        if (!message) return;

        // Display user message
        addMessage(message, true);
        chatHistory.push({ role: 'user', content: message });
        
        // Clear input and disable
        input.value = '';
        sendBtn.disabled = true;
        showTyping();

        try {
            const response = await fetch('{{ route("chatbot.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: message,
                    history: chatHistory.slice(-10) // Send last 10 messages for context
                })
            });

            const data = await response.json();
            hideTyping();
            
            if (data.success) {
                addMessage(data.reply, false);
                chatHistory.push({ role: 'assistant', content: data.reply });
            } else {
                addMessage(data.reply || 'Xin lỗi, có lỗi xảy ra!', false);
            }
        } catch (error) {
            hideTyping();
            addMessage('Không thể kết nối. Vui lòng thử lại! 🙏', false);
            console.error('Chatbot error:', error);
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    });

    // Quick Reply buttons - wrapped in a function for re-attachment
    function attachQuickReplyListeners() {
        document.querySelectorAll('.quick-reply-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const message = this.getAttribute('data-message');
                document.getElementById('chatbox-input').value = message;
                document.getElementById('chatbox-form').dispatchEvent(new Event('submit'));
                // Ẩn quick replies sau khi click
                const quickReplies = document.getElementById('quick-replies');
                if (quickReplies) quickReplies.style.display = 'none';
            });
        });
    }
    // Initial attachment
    attachQuickReplyListeners();

    // Close on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) {
            toggleChatbox();
        }
    });
</script>

<style>
    #chatbox-window.scale-100 {
        transform: scale(1);
    }
    #chatbox-window.scale-95 {
        transform: scale(0.95);
    }
    #chatbox-window.opacity-100 {
        opacity: 1;
    }
    #chatbox-window.opacity-0 {
        opacity: 0;
    }
</style>
