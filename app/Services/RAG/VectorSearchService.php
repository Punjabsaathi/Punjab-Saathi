<?php

namespace App\Services\RAG;

use Illuminate\Support\Facades\DB;
use App\Models\KnowledgeChunk;

class VectorSearchService
{
    public function search(array $queryVector, int $topK = 6, array $sourceTypes = []): array
    {
        $query = KnowledgeChunk::where('is_active', true)
            ->whereNotNull('embedding');

        if (!empty($sourceTypes)) {
            $query->whereIn('source_type', $sourceTypes);
        }

        $chunks = $query->get();

        $minSimilarity = config('chatbot.rag_min_similarity', 0.55);

        $results = $chunks->map(function ($chunk) use ($queryVector) {

            // ✅ FIX: decode JSON string to array before cosine similarity
            $chunkEmbedding = is_string($chunk->embedding)
                ? json_decode($chunk->embedding, true)
                : $chunk->embedding;

            if (empty($chunkEmbedding) || !is_array($chunkEmbedding)) {
                return null;
            }

            $similarity = $this->calculateCosineSimilarity($queryVector, $chunkEmbedding);

            return [
                'id'          => $chunk->id,
                'source_type' => $chunk->source_type,
                'source_id'   => $chunk->source_id,
                'content'     => $chunk->content,
                'title'       => $chunk->title,
                'similarity'  => round($similarity, 4),
                'metadata'    => $chunk->metadata,
            ];
        })
        ->filter()
        ->filter(fn($item) => $item['similarity'] >= $minSimilarity)
        ->sortByDesc('similarity')
        ->take($topK)
        ->values()
        ->toArray();

        return $results;
    }

    /**
     * Cosine similarity — pure PHP, zero API calls
     */
    private function calculateCosineSimilarity(array $vecA, array $vecB): float
    {
        $dotProduct = 0;
        $normA      = 0;
        $normB      = 0;

        foreach ($vecA as $i => $valA) {
            $valB        = $vecB[$i] ?? 0;
            $dotProduct += $valA * $valB;
            $normA      += $valA ** 2;
            $normB      += $valB ** 2;
        }

        if ($normA == 0 || $normB == 0) return 0;

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    public function upsertEmbedding(int $chunkId, array $vector): void
    {
        DB::table('knowledge_chunks')
            ->where('id', $chunkId)
            ->update([
                'embedding'   => json_encode($vector),
                'embedded_at' => now(),
            ]);
    }

    public function deleteBySource(string $sourceType, int $sourceId): int
    {
        return DB::table('knowledge_chunks')
            ->where('source_type', $sourceType)
            ->where('source_id', $sourceId)
            ->delete();
    }
}