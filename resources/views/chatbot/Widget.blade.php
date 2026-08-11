{{-- resources/views/chatbot/widget.blade.php --}}
{{-- Include in your layout: @include('chatbot.widget') --}}

<style>
/* ── Punjab Seva Kendra Chatbot Widget ── */
:root {
  --psk-primary:   #1a3a6b;
  --psk-accent:    #f47920;
  --psk-light:     #eef2f9;
  --psk-text:      #1f2937;
  --psk-muted:     #6b7280;
  --psk-border:    #d1d5db;
  --psk-radius:    14px;
  --psk-shadow:    0 8px 40px rgba(26,58,107,0.18);
}

#psk-chatbot-btn {
  position: fixed; bottom: 28px; right: 28px; z-index: 9998;
  width: 60px; height: 60px; border-radius: 50%;
  background: var(--psk-primary);
  border: none; cursor: pointer;
  box-shadow: 0 4px 20px rgba(26,58,107,0.4);
  display: flex; align-items: center; justify-content: center;
  transition: transform 0.2s, box-shadow 0.2s;
}
#psk-chatbot-btn:hover { transform: scale(1.08); box-shadow: 0 6px 28px rgba(26,58,107,0.5); }
#psk-chatbot-btn svg { width: 28px; height: 28px; fill: #fff; }

#psk-chatbot-window {
  position: fixed; bottom: 100px; right: 28px; z-index: 9999;
  width: 390px; max-height: 600px;
  background: #fff;
  border-radius: var(--psk-radius);
  box-shadow: var(--psk-shadow);
  display: flex; flex-direction: column;
  transition: opacity 0.25s, transform 0.25s;
  font-family: 'Segoe UI', sans-serif;
  overflow: hidden;
}
#psk-chatbot-window[x-show] { transform: translateY(16px) scale(0.97); }

.psk-header {
  background: linear-gradient(135deg, var(--psk-primary), #2d5fa3);
  padding: 14px 16px;
  display: flex; align-items: center; gap: 10px; flex-shrink: 0;
}
.psk-header-logo {
  width: 40px; height: 40px; border-radius: 50%;
  background: rgba(255,255,255,0.15);
  display: flex; align-items: center; justify-content: center;
}
.psk-header-logo svg { width: 22px; height: 22px; fill: #fff; }
.psk-header-info { flex: 1; }
.psk-header-title { color: #fff; font-size: 15px; font-weight: 600; margin: 0; }
.psk-header-sub   { color: rgba(255,255,255,0.75); font-size: 12px; margin: 2px 0 0; }
.psk-header-badge {
  display: flex; align-items: center; gap: 4px;
  background: rgba(255,255,255,0.15); border-radius: 20px;
  padding: 3px 10px; color: #fff; font-size: 11px;
}
.psk-header-badge::before {
  content: ''; display: inline-block;
  width: 6px; height: 6px; border-radius: 50%; background: #4ade80;
}
.psk-close-btn {
  background: none; border: none; cursor: pointer;
  color: rgba(255,255,255,0.8); padding: 4px;
  display: flex; align-items: center; justify-content: center;
}
.psk-close-btn:hover { color: #fff; }

/* Language selector */
.psk-lang-bar {
  background: var(--psk-light); border-bottom: 1px solid var(--psk-border);
  padding: 6px 14px; display: flex; align-items: center; gap: 6px;
}
.psk-lang-btn {
  padding: 3px 10px; border-radius: 20px; border: 1px solid var(--psk-border);
  background: #fff; cursor: pointer; font-size: 12px; color: var(--psk-muted);
  transition: all 0.15s;
}
.psk-lang-btn.active, .psk-lang-btn:hover {
  background: var(--psk-primary); color: #fff; border-color: var(--psk-primary);
}

/* Messages area */
.psk-messages {
  flex: 1; overflow-y: auto; padding: 16px 14px;
  display: flex; flex-direction: column; gap: 10px;
  background: #f8faff;
  scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;
}
.psk-msg-row { display: flex; gap: 8px; align-items: flex-end; }
.psk-msg-row.user { flex-direction: row-reverse; }

.psk-avatar {
  width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
  background: var(--psk-primary); color: #fff;
  font-size: 11px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
}
.psk-msg-row.user .psk-avatar { background: var(--psk-accent); }

.psk-bubble {
  max-width: 78%; padding: 10px 14px; border-radius: 16px;
  font-size: 13.5px; line-height: 1.55; white-space: pre-wrap; word-break: break-word;
}
.psk-bubble.bot  {
  background: #fff; color: var(--psk-text);
  border-radius: 16px 16px 16px 4px;
  box-shadow: 0 1px 6px rgba(0,0,0,0.07);
}
.psk-bubble.user {
  background: var(--psk-primary); color: #fff;
  border-radius: 16px 16px 4px 16px;
}
.psk-bubble strong { font-weight: 600; }
.psk-bubble ul { margin: 6px 0 0 16px; padding: 0; }
.psk-bubble li { margin-bottom: 3px; }

.psk-timestamp {
  font-size: 10px; color: var(--psk-muted); margin-top: 3px;
  text-align: right;
}
.psk-msg-row.bot .psk-timestamp { text-align: left; }

/* Sources pill */
.psk-sources { margin-top: 6px; display: flex; flex-wrap: wrap; gap: 4px; }
.psk-source-pill {
  font-size: 10px; padding: 2px 8px; border-radius: 12px;
  background: var(--psk-light); color: var(--psk-primary);
  border: 1px solid rgba(26,58,107,0.15);
}

/* Quick replies */
.psk-quick-replies { display: flex; flex-wrap: wrap; gap: 6px; padding: 0 14px 10px; }
.psk-quick-btn {
  padding: 6px 12px; border-radius: 20px;
  border: 1.5px solid var(--psk-primary); background: #fff;
  color: var(--psk-primary); font-size: 12px; cursor: pointer;
  transition: all 0.15s;
}
.psk-quick-btn:hover { background: var(--psk-primary); color: #fff; }

/* Typing indicator */
.psk-typing { display: flex; gap: 4px; align-items: center; padding: 10px 14px; }
.psk-typing span {
  width: 7px; height: 7px; border-radius: 50%;
  /* background: var(--psk-primary); opacity: 0.4; */
  animation: psk-bounce 1.2s infinite;
}
.psk-typing span:nth-child(2) { animation-delay: 0.2s; }
.psk-typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes psk-bounce {
  0%, 80%, 100% { transform: translateY(0); opacity: 0.4; }
  40%            { transform: translateY(-6px); opacity: 1; }
}

/* Input area */
.psk-input-area {
  padding: 10px 12px; border-top: 1px solid var(--psk-border);
  background: #fff; flex-shrink: 0;
}
.psk-input-row { display: flex; align-items: center; gap: 8px; }
.psk-input {
  flex: 1; padding: 10px 14px; border-radius: 24px;
  border: 1.5px solid var(--psk-border);
  font-size: 13.5px; outline: none; resize: none;
  font-family: inherit; background: var(--psk-light);
  transition: border-color 0.15s;
  max-height: 100px; overflow-y: auto;
}
.psk-input:focus { border-color: var(--psk-primary); background: #fff; }
.psk-send-btn {
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--psk-primary); border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.15s, transform 0.1s; flex-shrink: 0;
}
.psk-send-btn:hover { background: #2d5fa3; }
.psk-send-btn:active { transform: scale(0.94); }
.psk-send-btn svg { width: 18px; height: 18px; fill: #fff; }
.psk-send-btn:disabled { background: var(--psk-border); cursor: not-allowed; }

.psk-input-hint {
  font-size: 10px; color: var(--psk-muted); margin-top: 6px; text-align: center;
}

/* Status pill in message */
.psk-status-approved { color: #15803d; font-weight: 600; }
.psk-status-pending  { color: #d97706; font-weight: 600; }
.psk-status-rejected { color: #dc2626; font-weight: 600; }

@media (max-width: 480px) {
  #psk-chatbot-window { width: calc(100vw - 24px); right: 12px; bottom: 90px; }
}
</style>

<div x-data="pskChatbot()" x-init="init()">
  {{-- Floating toggle button --}}
  <button id="psk-chatbot-btn" @click="toggle()" :aria-label="open ? 'Close chat' : 'Open Punjab Seva Kendra Assistant'">
    <svg x-show="!open" viewBox="0 0 24 24"><path d="M20 2H4a2 2 0 00-2 2v18l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zm-2 10H6v-2h12v2zm0-4H6V6h12v2z"/></svg>
    <svg x-show="open" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
  </button>

  {{-- Chat Window --}}
  <div id="psk-chatbot-window" x-show="open" x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    {{-- Header --}}
    <div class="psk-header">
      <div class="psk-header-logo">
        <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
      </div>
      <div class="psk-header-info">
        <p class="psk-header-title">Punjab Seva Kendra</p>
        <p class="psk-header-sub">AI Digital Assistant</p>
      </div>
      <div class="psk-header-badge">Online</div>
      <button class="psk-close-btn" @click="open = false" aria-label="Close">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
      </button>
    </div>

    {{-- Language bar --}}
    <div class="psk-lang-bar">
      <span style="font-size:11px;color:#6b7280;margin-right:2px;">Language:</span>
      <template x-for="lang in languages" :key="lang.code">
        <button class="psk-lang-btn" :class="{ active: currentLang === lang.code }"
                @click="setLanguage(lang.code)" x-text="lang.label"></button>
      </template>
    </div>

    {{-- Messages --}}
    <div class="psk-messages" x-ref="messages">
      <template x-for="msg in messages" :key="msg.id">
        <div>
          <div class="psk-msg-row" :class="msg.role">
            <div class="psk-avatar" x-text="msg.role === 'user' ? 'You' : 'PSK'"></div>
            <div>
              <div class="psk-bubble" :class="msg.role" x-html="formatMessage(msg.content)"></div>
              {{-- Sources --}}
              <div x-show="msg.sources && msg.sources.length" class="psk-sources">
                <template x-for="source in (msg.sources || [])" :key="source.id">
                  <span class="psk-source-pill" x-text="'📄 ' + source.type + ': ' + source.title"></span>
                </template>
              </div>
              <div class="psk-timestamp" x-text="msg.time"></div>
            </div>
          </div>
        </div>
      </template>

      {{-- Typing indicator --}}
      <div x-show="loading" class="psk-msg-row bot">
        <div class="psk-avatar">PSK</div>
        <div class="psk-bubble bot">
          <div class="psk-typing">
            <span></span><span></span><span></span>
          </div>
        </div>
      </div>
    </div>

    {{-- Quick replies --}}
    <div class="psk-quick-replies" x-show="quickReplies.length">
      <template x-for="reply in quickReplies" :key="reply">
        <button class="psk-quick-btn" @click="sendQuickReply(reply)" x-text="reply"></button>
      </template>
    </div>

    {{-- Input area --}}
    <div class="psk-input-area">
      <div class="psk-input-row">
        <textarea class="psk-input" x-model="inputText" rows="1"
                  :placeholder="placeholder"
                  @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                  @input="autoResize($event.target)"
                  :disabled="loading"></textarea>
        <button class="psk-send-btn" @click="sendMessage()" :disabled="loading || !inputText.trim()">
          <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
      </div>
      <p class="psk-input-hint">Powered by AI · Punjab Govt. Official Service</p>
    </div>
  </div>
</div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function pskChatbot() {
  return {
    open: false,
    loading: false,
    inputText: '',
    sessionToken: null,
    currentLang: 'en',
    messages: [],
    quickReplies: [],

    // ✅ FIX: cooldown prevents users spamming messages
    // and burning through API quota
    lastMessageTime: 0,
    cooldownSeconds: 5,

    languages: [
      { code: 'en', label: 'English' },
      { code: 'hi', label: 'हिंदी' },
      { code: 'pa', label: 'ਪੰਜਾਬੀ' },
    ],

    get placeholder() {
      return {
        en: 'Type your question here...',
        hi: 'यहाँ अपना प्रश्न टाइप करें...',
        pa: 'ਇੱਥੇ ਆਪਣਾ ਸਵਾਲ ਟਾਈਪ ਕਰੋ...',
      }[this.currentLang] || 'Type your question...';
    },

    async init() {
      // ✅ FIX: try saved token first — only create new session if none exists
      // Old code called startSession() then overwrote token with localStorage
      // causing a race condition where an expired token was used
      const saved = localStorage.getItem('psk_session');
      if (saved) {
        this.sessionToken = saved;
      } else {
        await this.startSession();
      }
    },

    toggle() {
      this.open = !this.open;
      if (this.open && this.messages.length === 0) {
        this.addGreeting();
      }
    },

    async startSession() {
      try {
        const res = await fetch('/api/chatbot/session', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content,
          },
        });

        if (!res.ok) {
          console.error('Session start failed:', res.status);
          return;
        }

        const data = await res.json();
        this.sessionToken = data.session_token;
        localStorage.setItem('psk_session', this.sessionToken);
        return data;
      } catch (e) {
        console.error('Session init failed', e);
      }
    },

    addGreeting() {
      const greetings = {
        en: "Hello! 👋 I'm the Punjab Seva Kendra AI Assistant.\n\nI can help you with:\n• Government services & schemes\n• Required documents\n• Application status (share your reference number)\n• Processing time & fees\n\nHow can I assist you today?",
        hi: "नमस्ते! 👋 मैं Punjab Seva Kendra AI सहायक हूं।\n\nमैं आपकी मदद कर सकता हूं:\n• सरकारी सेवाएं और योजनाएं\n• आवश्यक दस्तावेज़\n• आवेदन स्थिति\n\nआज मैं आपकी कैसे सहायता करूं?",
        pa: "ਸਤ ਸ੍ਰੀ ਅਕਾਲ! 👋 ਮੈਂ Punjab Seva Kendra AI ਸਹਾਇਕ ਹਾਂ।\n\nਮੈਂ ਤੁਹਾਡੀ ਮਦਦ ਕਰ ਸਕਦਾ ਹਾਂ:\n• ਸਰਕਾਰੀ ਸੇਵਾਵਾਂ ਅਤੇ ਸਕੀਮਾਂ\n• ਲੋੜੀਂਦੇ ਦਸਤਾਵੇਜ਼\n• ਅਰਜ਼ੀ ਸਥਿਤੀ\n\nਅੱਜ ਮੈਂ ਤੁਹਾਡੀ ਕਿਵੇਂ ਸੇਵਾ ਕਰਾਂ?",
      };

      this.addMessage('bot', greetings[this.currentLang] || greetings.en, []);
      this.quickReplies = this.currentLang === 'hi'
        ? ['सेवाएं देखें', 'आवेदन स्थिति', 'दस्तावेज़ सूची', 'हेल्पलाइन']
        : ['View services', 'Check application status', 'Document checklist', 'Helpline number'];
    },

    async sendMessage() {
      const text = this.inputText.trim();
      if (!text || this.loading) return;

      // ✅ FIX: cooldown check — stops users burning quota by sending too fast
      const now = Date.now();
      const secondsSinceLast = (now - this.lastMessageTime) / 1000;
      if (this.lastMessageTime > 0 && secondsSinceLast < this.cooldownSeconds) {
        const wait = Math.ceil(this.cooldownSeconds - secondsSinceLast);
        this.addMessage('bot', `Please wait ${wait} second(s) before sending another message.`);
        return;
      }
      this.lastMessageTime = now;

      // ✅ FIX: guard against null session token
      if (!this.sessionToken) {
        await this.startSession();
      }

      if (!this.sessionToken) {
        this.addMessage('bot', 'Unable to start a session. Please refresh the page and try again.');
        return;
      }

      this.addMessage('user', text);
      this.inputText = '';
      this.quickReplies = [];
      this.loading = true;

      try {
        const res = await fetch('/api/chatbot/message', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content,
          },
          body: JSON.stringify({
            message:       text,
            session_token: this.sessionToken,
          }),
        });

        // ✅ FIX: handle expired session gracefully
        if (res.status === 404) {
          localStorage.removeItem('psk_session');
          this.sessionToken = null;
          await this.startSession();
          this.addMessage('bot', 'Your session expired. A new session has started — please send your message again.');
          return;
        }

        if (res.status === 429) {
          this.addMessage('bot', '⏱ Too many requests. Please wait a moment before sending again.');
          return;
        }

        if (!res.ok) {
          const err = await res.json().catch(() => ({}));
          console.error('Chat API error', res.status, err);
          this.addMessage('bot', 'Sorry, something went wrong. Please try again.');
          return;
        }

        const data = await res.json();
        this.addMessage('bot', data.answer, data.sources || []);
        this.quickReplies = data.quick_replies || [];
        this.currentLang  = data.language || this.currentLang;

      } catch (e) {
        console.error('Chat fetch error:', e);
        this.addMessage('bot', 'Sorry, there was a connection error. Please try again.');
      } finally {
        this.loading = false;
        this.$nextTick(() => this.scrollToBottom());
      }
    },

    sendQuickReply(reply) {
      this.inputText = reply;
      this.sendMessage();
    },

    setLanguage(code) {
      this.currentLang = code;
      this.messages    = [];
      this.addGreeting();
    },

    addMessage(role, content, sources = []) {
      this.messages.push({
        id:      Date.now() + Math.random(),
        role,
        content,
        sources,
        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
      });
      this.$nextTick(() => this.scrollToBottom());
    },

    formatMessage(text) {
      return text
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/•\s/g, '• ')
        .replace(/\n/g, '<br>')
        .replace(/APPROVED/g, '<span class="psk-status-approved">APPROVED</span>')
        .replace(/PENDING/g,  '<span class="psk-status-pending">PENDING</span>')
        .replace(/REJECTED/g, '<span class="psk-status-rejected">REJECTED</span>');
    },

    autoResize(el) {
      el.style.height = 'auto';
      el.style.height = Math.min(el.scrollHeight, 100) + 'px';
    },

    scrollToBottom() {
      const el = this.$refs.messages;
      if (el) el.scrollTop = el.scrollHeight;
    },
  };
}
</script>