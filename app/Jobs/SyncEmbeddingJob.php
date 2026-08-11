<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncEmbeddingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The content type to sync embeddings for.
     *
     * Examples: service, faq, document, blog
     */
    public function __construct(public string $type)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // TODO: Replace this with your actual embedding sync logic.
        // Example:
        // app(\App\Services\AI\EmbeddingService::class)->syncByType($this->type);

        Log::info('SyncEmbeddingJob executed.', [
            'type' => $this->type,
        ]);
    }
}