<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LogChatAnalyticsJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Allow both array and string input.
     */
    public function __construct(public array|string $data)
    {
        // If a string is passed, convert it into an array automatically.
        if (is_string($this->data)) {
            $this->data = [
                'message' => $this->data,
            ];
        }
    }

    public function handle(): void
    {
        // Store analytics in DB or log
        // Example:
        // \Log::info('Chat Analytics', $this->data);
    }
}