{{-- resources/views/chatbot/Widget.blade.php --}}
{{-- Include in your layout: @include('chatbot.Widget') --}}

<link rel="stylesheet" href="{{ asset('css/psk-chatbot.css') }}">

<div x-data="pskChatbot()" x-init="init()">
  {{-- Floating toggle button --}}
  <button id="psk-chatbot-btn" @click="toggle()" :aria-label="open ? 'Close chat' : 'Open Punjab Saathi Assistant'">
    <svg x-show="!open" viewBox="0 0 24 24"><path d="M20 2H4a2 2 0 00-2 2v18l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zm-2 10H6v-2h12v2zm0-4H6V6h12v2z"/></svg>
    <svg x-show="open" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
  </button>

  {{-- Chat Window --}}
  <div id="psk-chatbot-window" x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    {{-- Header --}}
    <div class="psk-header">
      <div class="psk-header-logo">
        <img src="{{ asset('images/punjab_seva_kendra.png') }}" alt="Punjab Saathi">
      </div>
      <div class="psk-header-info">
        <p class="psk-header-title">Punjab Saathi</p>
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
            <div class="psk-avatar" x-text="msg.role === 'user' ? 'You' : 'PS'"></div>
            <div class="psk-msg-content">
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
        <div class="psk-avatar">PS</div>
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
        <textarea class="psk-chat-input" x-model="inputText" rows="1"
                  :placeholder="placeholder"
                  @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                  @input="autoResize($event.target)"
                  :disabled="loading"></textarea>
        <button class="psk-send-btn" @click="sendMessage()" :disabled="loading || !inputText.trim()">
          <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
      </div>
      <p class="psk-input-hint">Powered by Punjab Saathi</p>
    </div>
  </div>
</div>
<script defer src="{{ asset('js/alpine.min.js') }}"></script>
<script src="{{ asset('js/psk-chatbot.js') }}"></script>
