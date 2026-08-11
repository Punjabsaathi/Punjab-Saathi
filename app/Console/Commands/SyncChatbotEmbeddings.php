<?php
namespace App\Console\Commands;

    use App\Services\Embedding\EmbeddingService;
    use Illuminate\Console\Command;

    class SyncChatbotEmbeddings extends Command
    {
        protected $signature   = 'chatbot:sync-embeddings {--type= : Specific source type to sync}';
        protected $description = 'Sync knowledge embeddings for the RAG chatbot';

        public function handle(EmbeddingService $embeddingService): void
        {
            $types = $this->option('type')
                ? [$this->option('type')]
                : config('chatbot.source_types');

            foreach ($types as $type) {
                $this->info("Syncing embeddings for: {$type}");
                $embeddingService->syncSource($type);

                // ✅ FIX: added delay between each source type
                // Prevents hitting the 15 requests/minute free tier limit
                // when syncing multiple source types back to back
                $this->info("✓ Done: {$type} — waiting 5 seconds before next type...");
                sleep(5);
            }

            $this->info('All embeddings synced successfully.');
        }
    }