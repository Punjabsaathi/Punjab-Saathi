<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\ServiceFaq;
use App\Models\ServiceDocument;

class KnowledgeChunkSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing chunks first
        DB::table('knowledge_chunks')->truncate();
        $this->command->info('🗑️  Cleared existing knowledge chunks');

        $services = Service::where('is_active', true)->get();
        $this->command->info("📦 Found {$services->count()} active services");

        foreach ($services as $service) {
            // ── Chunk 1: Service Overview ────────────────────────────────
            $overview = strip_tags($service->overview ?? '');
            $eligibility = strip_tags($service->eligibility ?? '');

            DB::table('knowledge_chunks')->insert([
                'source_type' => 'service',
                'source_id'   => $service->id,
                'chunk_index' => 0,
                'title'       => $service->title,
                'content'     => implode("\n", array_filter([
                    "Service: {$service->title}",
                    "Category: {$service->category}",
                    "Tag: {$service->tag}",
                    "Description: {$service->short_desc}",
                    "Overview: {$overview}",
                    "Eligibility: {$eligibility}",
                ])),
                'metadata'    => json_encode([
                    'slug'     => $service->slug,
                    'category' => $service->category,
                ]),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // ── Chunk 2: Fees & Processing Time ─────────────────────────
            DB::table('knowledge_chunks')->insert([
                'source_type' => 'service',
                'source_id'   => $service->id,
                'chunk_index' => 1,
                'title'       => $service->title . ' — Fees & Processing Time',
                'content'     => implode("\n", array_filter([
                    "Service: {$service->title}",
                    "Processing Time: {$service->processing_time}",
                    "Fee Range: {$service->fee_range}",
                    "Fee Note: {$service->fee_note}",
                ])),
                'metadata'    => json_encode([
                    'slug'     => $service->slug,
                    'category' => $service->category,
                ]),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // ── Chunk 3: Required Documents ──────────────────────────────
            $documents = ServiceDocument::where('service_id', $service->id)
                ->orderBy('sort_order')
                ->get();

            if ($documents->isNotEmpty()) {
                $docLines = $documents->map(function ($doc) {
                    $mandatory = $doc->is_mandatory ? '(Required)' : '(Optional)';
                    $note = $doc->note ? " — {$doc->note}" : '';
                    return "• {$doc->label} {$mandatory}{$note}";
                })->implode("\n");

                DB::table('knowledge_chunks')->insert([
                    'source_type' => 'service',
                    'source_id'   => $service->id,
                    'chunk_index' => 2,
                    'title'       => $service->title . ' — Required Documents',
                    'content'     => implode("\n", [
                        "Service: {$service->title}",
                        "Required Documents:",
                        $docLines,
                    ]),
                    'metadata'    => json_encode([
                        'slug'     => $service->slug,
                        'category' => $service->category,
                    ]),
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            // ── Chunk 4+: FAQs (one chunk per FAQ) ──────────────────────
            $faqs = ServiceFaq::where('service_id', $service->id)
                ->orderBy('sort_order')
                ->get();

            foreach ($faqs as $index => $faq) {
                DB::table('knowledge_chunks')->insert([
                    'source_type' => 'faq',
                    'source_id'   => $service->id,
                    'chunk_index' => $index,
                    'title'       => $service->title . ' — FAQ: ' . $faq->question,
                    'content'     => implode("\n", [
                        "Service: {$service->title}",
                        "Question: {$faq->question}",
                        "Answer: {$faq->answer}",
                    ]),
                    'metadata'    => json_encode([
                        'slug'     => $service->slug,
                        'category' => $service->category,
                    ]),
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            $this->command->info("✅ Chunked: {$service->title}");
        }

        $total = DB::table('knowledge_chunks')->count();
        $this->command->info("🎉 Total chunks created: {$total}");
    }
}