{{-- AI Chatbox Component --}}
<div id="chatbox-container" class="fixed bottom-6 right-6 z-[9999]">
    
    {{-- Chat Window --}}
    <div id="chatbox-window" class="hidden absolute bottom-20 right-0 w-[360px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 origin-bottom-right scale-95 opacity-0">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand-green to-emerald-600 text-white p-4 flex items-center justify-between">
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
            <button onclick="toggleChatbox()" class="w-8 h-8 rounded-full hover:bg-white/20 flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Messages Area --}}
        <div id="chatbox-messages" class="h-[350px] overflow-y-auto p-4 space-y-4 bg-gray-50">
            {{-- Welcome Message --}}
            <div class="flex gap-3">
                <div class="w-8 h-8 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-xs"></i>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm max-w-[80%]">
                    <p class="text-sm text-gray-700">Xin chào! 📚 Tôi là trợ lý AI của Góc Sách. Tôi có thể giúp bạn tìm sách hay, gợi ý đọc theo sở thích. Bạn cần gì nào?</p>
                </div>
            </div>
        </div>

        {{-- Typing Indicator (hidden by default) --}}
        <div id="typing-indicator" class="hidden px-4 py-2 bg-gray-50">
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
        <div class="p-4 bg-white border-t border-gray-100">
            <form id="chatbox-form" class="flex gap-2">
                @csrf
                <input type="text" id="chatbox-input" 
                    placeholder="Nhập tin nhắn..." 
                    autocomplete="off"
                    class="flex-1 px-4 py-3 bg-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/30 transition">
                <button type="submit" id="chatbox-send"
                    class="w-12 h-12 bg-brand-green hover:bg-emerald-700 text-white rounded-xl flex items-center justify-center transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 text-center mt-2">Powered by Gemini AI</p>
        </div>
    </div>

    {{-- Floating Button --}}
    <button onclick="toggleChatbox()" id="chatbox-toggle"
        class="w-14 h-14 bg-gradient-to-br from-brand-green to-emerald-600 text-white rounded-full shadow-lg flex items-center justify-center hover:shadow-xl hover:scale-110 transition-all duration-300 group">
        <i class="fas fa-comments text-xl group-hover:hidden"></i>
        <i class="fas fa-times text-xl hidden group-hover:block"></i>
        {{-- Pulse Animation --}}
        <span class="absolute w-full h-full rounded-full bg-brand-green animate-ping opacity-30"></span>
    </button>
</div>

<script>
    let chatHistory = [];
    let isOpen = false;

    function toggleChatbox() {
        const window = document.getElementById('chatbox-window');
        const toggle = document.getElementById('chatbox-toggle');
        isOpen = !isOpen;

        if (isOpen) {
            window.classList.remove('hidden');
            setTimeout(() => {
                window.classList.remove('scale-95', 'opacity-0');
                window.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.getElementById('chatbox-input').focus();
        } else {
            window.classList.remove('scale-100', 'opacity-100');
            window.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                window.classList.add('hidden');
            }, 300);
        }
    }

    function addMessage(content, isUser = false) {
        const container = document.getElementById('chatbox-messages');
        const messageHtml = isUser 
            ? `<div class="flex gap-3 justify-end">
                    <div class="bg-brand-green text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-sm max-w-[80%]">
                        <p class="text-sm">${escapeHtml(content)}</p>
                    </div>
               </div>`
            : `<div class="flex gap-3">
                    <div class="w-8 h-8 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-robot text-white text-xs"></i>
                    </div>
                    <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm max-w-[80%]">
                        <p class="text-sm text-gray-700">${formatMessage(content)}</p>
                    </div>
               </div>`;
        
        container.insertAdjacentHTML('beforeend', messageHtml);
        container.scrollTop = container.scrollHeight;
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
