<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class LogChatAnalyticsJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public string $sessionId,
        public int $userMessageId,
        public int $assistantMessageId,
        public int $latencyMs,
        public ?string $intent = null,
        public ?string $language = null,
        public int $chunksRetrieved = 0,
        public ?float $topSimilarity = null,
        public ?string $provider = null,
    ) {
        // Dispatched to the default queue (no ->onQueue() call) — the
        // scheduled `queue:work --stop-when-empty` worker set up for this
        // project only drains the default queue, not a named 'analytics'
        // queue, so this must stay on default to actually get processed.
    }

    public function handle(): void
    {
        DB::table('chat_analytics')->insert([
            'session_id'            => $this->sessionId,
            'user_message_id'       => $this->userMessageId,
            'assistant_message_id'  => $this->assistantMessageId,
            'intent'                => $this->intent,
            'language'              => $this->language,
            'latency_ms'            => $this->latencyMs,
            'was_status_check'      => $this->intent === 'status_check',
            'chunks_retrieved'      => $this->chunksRetrieved,
            'top_similarity'        => $this->topSimilarity,
            'provider'              => $this->provider,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }
}
