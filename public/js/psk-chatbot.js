/**
 * Punjab Saathi — Chatbot Widget JS
 * File: public/js/psk-chatbot.js
 * Load AFTER: alpine.min.js
 */
function pskChatbot() {
  return {
    open: false,
    loading: false,
    inputText: '',
    sessionToken: null,
    currentLang: 'en',
    messages: [],
    quickReplies: [],

    // Cooldown prevents users spamming messages and burning through API
    // quota — complementary to the server-side rate limiter, not a
    // replacement for it.
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
      // Try saved token first — only create a new session if none exists.
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

        // A resumed session may already have a pinned language server-side
        // (e.g. the user picked Hindi yesterday) — reflect that in the UI
        // instead of always defaulting to English on reload.
        if (data.language) {
          this.currentLang = data.language;
        }

        return data;
      } catch (e) {
        console.error('Session init failed', e);
      }
    },

    addGreeting() {
      const greetings = {
        en: "Hello! 👋 I'm the Punjab Saathi AI Assistant.\n\nI can help you with:\n• Government services & schemes\n• Required documents\n• Application status (share your reference number)\n• Processing time & fees\n\nHow can I assist you today?",
        hi: "नमस्ते! 👋 मैं Punjab Saathi AI सहायक हूं।\n\nमैं आपकी मदद कर सकता हूं:\n• सरकारी सेवाएं और योजनाएं\n• आवश्यक दस्तावेज़\n• आवेदन स्थिति\n\nआज मैं आपकी कैसे सहायता करूं?",
        pa: "ਸਤ ਸ੍ਰੀ ਅਕਾਲ! 👋 ਮੈਂ Punjab Saathi AI ਸਹਾਇਕ ਹਾਂ।\n\nਮੈਂ ਤੁਹਾਡੀ ਮਦਦ ਕਰ ਸਕਦਾ ਹਾਂ:\n• ਸਰਕਾਰੀ ਸੇਵਾਵਾਂ ਅਤੇ ਸਕੀਮਾਂ\n• ਲੋੜੀਂਦੇ ਦਸਤਾਵੇਜ਼\n• ਅਰਜ਼ੀ ਸਥਿਤੀ\n\nਅੱਜ ਮੈਂ ਤੁਹਾਡੀ ਕਿਵੇਂ ਸੇਵਾ ਕਰਾਂ?",
      };

      this.addMessage('bot', greetings[this.currentLang] || greetings.en, []);
      this.quickReplies = this.currentLang === 'hi'
        ? ['सेवाएं देखें', 'आवेदन स्थिति', 'दस्तावेज़ सूची', 'हेल्पलाइन']
        : this.currentLang === 'pa'
          ? ['ਸੇਵਾਵਾਂ ਵੇਖੋ', 'ਅਰਜ਼ੀ ਸਥਿਤੀ', 'ਦਸਤਾਵੇਜ਼ ਸੂਚੀ', 'ਹੈਲਪਲਾਈਨ']
          : ['View services', 'Check application status', 'Document checklist', 'Helpline number'];
    },

    async sendMessage() {
      const text = this.inputText.trim();
      if (!text || this.loading) return;

      const now = Date.now();
      const secondsSinceLast = (now - this.lastMessageTime) / 1000;
      if (this.lastMessageTime > 0 && secondsSinceLast < this.cooldownSeconds) {
        const wait = Math.ceil(this.cooldownSeconds - secondsSinceLast);
        this.addMessage('bot', `Please wait ${wait} second(s) before sending another message.`);
        return;
      }
      this.lastMessageTime = now;

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
            // The user's explicit language choice is authoritative on
            // the backend — sending it here is what makes the language
            // selector actually stick instead of being re-detected from
            // message script on every turn.
            language:      this.currentLang,
          }),
        });

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

    escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    },

    formatMessage(text) {
      // Escape raw HTML FIRST — this text can come from an AI response
      // or a retrieved DB chunk, and is rendered via x-html below, so
      // any literal <script>/<img onerror> etc. must be neutralized
      // before the markdown-style replacements run.
      return this.escapeHtml(text)
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/•\s/g, '• ')
        .replace(/\n/g, '<br>')
        .replace(/APPROVED|COMPLETED/g, '<span class="psk-status-approved">$&</span>')
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
