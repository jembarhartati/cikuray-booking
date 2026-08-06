<div class="fixed bottom-4 right-4 left-4 sm:left-auto sm:bottom-6 sm:right-6 z-[150] flex flex-col items-end">
    <!-- Chat Window -->
    <div id="chatbot-window" class="hidden w-full sm:w-96 h-[400px] sm:h-[480px] bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-mountain-100 flex flex-col overflow-hidden mb-4 transition-all duration-300 transform translate-y-4 opacity-0 scale-95">
        <!-- Header -->
        <div class="bg-gradient-to-r from-forest-800 to-forest-900 p-4 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">
                    🤖
                </div>
                <div>
                    <h3 class="font-display font-bold text-sm leading-tight">Asisten Cikuray</h3>
                    <p class="text-xs text-forest-300">Tanya seputar pendakian & booking</p>
                </div>
            </div>
            <button onclick="toggleChat()" class="text-white/60 hover:text-white text-lg font-bold">
                ✕
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto space-y-3 bg-mountain-50">
            <!-- Bot Welcome message -->
            <div class="flex items-start gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-forest-100 flex items-center justify-center text-sm flex-shrink-0">
                    🤖
                </div>
                <div class="bg-white px-3.5 py-2.5 rounded-2xl rounded-tl-none border border-mountain-100 text-sm text-mountain-800 max-w-[80%] shadow-sm">
                    Halo! Saya Asisten Gunung Cikuray via Cintanagara. Ada yang bisa saya bantu terkait info tiket, kuota, aturan, atau perlengkapan?
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <form id="chatbot-form" onsubmit="sendMessage(event)" class="p-3 border-t border-mountain-100 bg-white flex gap-2">
            <input type="text" id="chatbot-input" placeholder="Tulis pertanyaan Anda..." 
                   class="flex-1 px-4 py-2.5 bg-mountain-50 border border-mountain-200 rounded-xl text-sm text-mountain-800 placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white transition-all duration-200"
                   autocomplete="off">
            <button type="submit" class="p-2.5 bg-forest-600 hover:bg-forest-500 text-white rounded-xl active:scale-95 transition-all duration-200 flex items-center justify-center">
                ➔
            </button>
        </form>
    </div>

    <!-- Floating Toggle Button -->
    <button onclick="toggleChat()" class="px-4 sm:px-5 h-12 sm:h-14 bg-gradient-to-r from-forest-600 to-forest-700 hover:from-forest-500 hover:to-forest-600 text-white rounded-xl sm:rounded-2xl shadow-xl flex items-center gap-2 active:scale-95 transition-all duration-255 border border-forest-500/20 group relative overflow-hidden">
        <span class="text-[10px] sm:text-xs font-bold tracking-wide font-display uppercase whitespace-nowrap">💬 Tanya Info Pendakian (Chatbot AI) 🤖</span>
        <!-- Pulsing ring effect -->
        <span class="absolute inset-0 border-2 border-white/30 rounded-xl sm:rounded-2xl animate-ping opacity-60 pointer-events-none scale-105"></span>
    </button>
</div>

<script>
    function toggleChat() {
        const windowEl = document.getElementById('chatbot-window');
        sessionStorage.setItem('chatbot_opened_once', 'true');
        if (windowEl.classList.contains('hidden')) {
            windowEl.classList.remove('hidden');
            setTimeout(() => {
                windowEl.classList.remove('opacity-0', 'scale-95', 'translate-y-4');
                windowEl.classList.add('opacity-100', 'scale-100', 'translate-y-0');
            }, 10);
        } else {
            windowEl.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
            windowEl.classList.add('opacity-0', 'scale-95', 'translate-y-4');
            setTimeout(() => {
                windowEl.classList.add('hidden');
            }, 300);
        }
    }

    async function sendMessage(e) {
        e.preventDefault();
        const inputEl = document.getElementById('chatbot-input');
        const message = inputEl.value.trim();
        if (!message) return;

        inputEl.value = '';
        appendMessage(message, true);

        // typing indicator
        const typingId = appendTypingIndicator();

        try {
            const response = await fetch("{{ route('chatbot.ask') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            removeTypingIndicator(typingId);
            appendMessage(data.jawaban, false);
        } catch (error) {
            removeTypingIndicator(typingId);
            appendMessage("Maaf, terjadi kesalahan pada server. Silakan coba lagi.", false);
        }
    }

    function appendMessage(text, isUser) {
        const container = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.className = isUser ? 'flex items-start gap-2.5 justify-end' : 'flex items-start gap-2.5';

        const avatar = isUser 
            ? `<div class="w-8 h-8 rounded-lg bg-mountain-200 flex items-center justify-center text-sm flex-shrink-0">👤</div>`
            : `<div class="w-8 h-8 rounded-lg bg-forest-100 flex items-center justify-center text-sm flex-shrink-0">🤖</div>`;

        const bubble = isUser
            ? `<div class="bg-forest-600 text-white px-3.5 py-2.5 rounded-2xl rounded-tr-none text-sm max-w-[80%] shadow-sm">${escapeHtml(text)}</div>`
            : `<div class="bg-white px-3.5 py-2.5 rounded-2xl rounded-tl-none border border-mountain-100 text-sm text-mountain-800 max-w-[80%] shadow-sm">${text}</div>`;

        div.innerHTML = isUser ? bubble + avatar : avatar + bubble;
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function appendTypingIndicator() {
        const id = 'typing-' + Date.now();
        const container = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.id = id;
        div.className = 'flex items-start gap-2.5';
        div.innerHTML = `
            <div class="w-8 h-8 rounded-lg bg-forest-100 flex items-center justify-center text-sm flex-shrink-0">🤖</div>
            <div class="bg-white px-3.5 py-2.5 rounded-2xl rounded-tl-none border border-mountain-100 text-sm text-mountain-400 max-w-[80%] shadow-sm flex items-center gap-1">
                <span class="w-1.5 h-1.5 bg-mountain-400 rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-mountain-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                <span class="w-1.5 h-1.5 bg-mountain-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
            </div>
        `;
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
        return id;
    }

    function removeTypingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    function escapeHtml(string) {
        return String(string).replace(/[&<>"']/g, function (s) {
            return {
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#039;"
            }[s];
        });
    }
</script>
