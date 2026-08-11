<?php

namespace App\Services\Embedding;

use App\Models\KnowledgeChunk;
use App\Services\AI\GeminiService;
use App\Services\RAG\VectorSearchService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    public function __construct(
        protected GeminiService     $gemini,
        protected VectorSearchService $vectorSearch,
    ) {}

    /**
     * Sync embeddings for a given source type.
     * Called by: php artisan chatbot:sync-embeddings
     */
    public function syncSource(string $type): void
    {
        $chunks = KnowledgeChunk::active()->ofType($type)->get();

        if ($chunks->isEmpty()) {
            Log::info("No active chunks found for type: {$type}");
            return;
        }

        foreach ($chunks as $chunk) {
            try {
                $this->embedChunk($chunk);
            } catch (\Exception $e) {
                Log::error("Failed to embed chunk #{$chunk->id}", [
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Embed a single KnowledgeChunk and store the vector.
     */
    public function embedChunk(KnowledgeChunk $chunk): void
    {
        // Build text to embed: title + content
        $text = trim(($chunk->title ? $chunk->title . "\n" : '') . $chunk->content);

        $vector = $this->gemini->embed($text);

        if (empty($vector)) {
            Log::warning("Empty embedding returned for chunk #{$chunk->id}");
            return;
        }

        // $this->vectorSearch->upsertVector($chunk->id, $vector, [
        //     'source_type' => $chunk->source_type,
        //     'source_id'   => $chunk->source_id,
        //     'title'       => $chunk->title,
        // ]);
        $this->vectorSearch->upsertEmbedding($chunk->id, $vector);
        $chunk->markEmbedded();

        Log::info("Embedded chunk #{$chunk->id} ({$chunk->source_type})");
    }

    /**
     * Embed raw text and return vector (used by RAG pipeline for query embedding).
     */
    public function embedText(string $text): array
    {
        return $this->gemini->embed($text);
    }

    /**
     * Re-embed all chunks (force refresh, ignores embedded_at).
     */
    public function syncAll(): void
    {
        $types = config('chatbot.source_types', []);

        foreach ($types as $type) {
            $this->syncSource($type);
        }
    }

    /**
     * Create or update a knowledge chunk and immediately embed it.
     */
    public function upsertChunk(array $data): KnowledgeChunk
    {
        $chunk = KnowledgeChunk::updateOrCreate(
            [
                'source_type'  => $data['source_type'],
                'source_id'    => $data['source_id'],
                'chunk_index'  => $data['chunk_index'] ?? 0,
            ],
            [
                'content'     => $data['content'],
                'title'       => $data['title'] ?? null,
                'content_hi'  => $data['content_hi'] ?? null,
                'content_pa'  => $data['content_pa'] ?? null,
                'metadata'    => $data['metadata'] ?? [],
                'is_active'   => true,
            ]
        );

        $this->embedChunk($chunk);

        return $chunk;
    }

    /**
     * Chunk a long text into overlapping segments and embed each.
     */
    public function chunkAndEmbed(
        string $text,
        string $sourceType,
        int    $sourceId,
        string $title = '',
        int    $chunkSize  = 500,
        int    $overlap    = 50
    ): void {
        $words  = explode(' ', $text);
        $total  = count($words);
        $index  = 0;
        $step   = $chunkSize - $overlap;

        for ($i = 0; $i < $total; $i += $step) {
            $slice   = array_slice($words, $i, $chunkSize);
            $content = implode(' ', $slice);

            $this->upsertChunk([
                'source_type' => $sourceType,
                'source_id'   => $sourceId,
                'chunk_index' => $index++,
                'title'       => $title,
                'content'     => $content,
            ]);
            if ($i + $chunkSize >= $total) break;
        }
    }
}