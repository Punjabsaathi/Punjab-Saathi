<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\ServiceFaq;
use App\Models\ServiceDocument;
use App\Models\GovForm;
use App\Models\GovJob;
use App\Models\Blog;

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
                    "URL: " . route('services.show', $service->slug),
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

        // ── GovForm + FormFaq ────────────────────────────────────────
        $forms = GovForm::where('is_active', true)->with('category', 'faqs')->get();
        $this->command->info("📦 Found {$forms->count()} active gov forms");

        foreach ($forms as $form) {
            DB::table('knowledge_chunks')->insert([
                'source_type' => 'form',
                'source_id'   => $form->id,
                'chunk_index' => 0,
                'title'       => $form->title,
                'content'     => implode("\n", array_filter([
                    "Form: {$form->title}",
                    "Category: {$form->category?->name}",
                    "Description: {$form->short_description}",
                    "Details: " . strip_tags($form->full_description ?? ''),
                    "URL: " . route('forms.show', $form->slug),
                ])),
                'metadata'    => json_encode(['slug' => $form->slug]),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ($form->faqs as $index => $faq) {
                DB::table('knowledge_chunks')->insert([
                    'source_type' => 'form',
                    'source_id'   => $form->id,
                    'chunk_index' => $index + 1,
                    'title'       => $form->title . ' — FAQ: ' . $faq->question,
                    'content'     => implode("\n", [
                        "Form: {$form->title}",
                        "Question: {$faq->question}",
                        "Answer: {$faq->answer}",
                    ]),
                    'metadata'    => json_encode(['slug' => $form->slug]),
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            $this->command->info("✅ Chunked form: {$form->title}");
        }

        // ── GovJob + GovJobFaq ───────────────────────────────────────
        $jobs = GovJob::where('is_published', true)->with('faqs')->get();
        $this->command->info("📦 Found {$jobs->count()} published gov jobs");

        foreach ($jobs as $job) {
            $feeLines = collect($job->application_fee ?? [])
                ->map(fn($v, $k) => is_array($v) ? null : "• {$k}: {$v}")
                ->filter()
                ->implode("\n");

            $stepsLines = collect($job->application_steps ?? [])
                ->map(fn($v) => is_string($v) ? "• {$v}" : null)
                ->filter()
                ->implode("\n");

            $docsLines = collect($job->required_documents ?? [])
                ->map(fn($v) => is_string($v) ? "• {$v}" : null)
                ->filter()
                ->implode("\n");

            DB::table('knowledge_chunks')->insert([
                'source_type' => 'job',
                'source_id'   => $job->id,
                'chunk_index' => 0,
                'title'       => $job->title,
                'content'     => implode("\n", array_filter([
                    "Job: {$job->title}",
                    "Department: {$job->department}",
                    "Description: {$job->short_description}",
                    "Qualification: {$job->qualification}",
                    "Salary / Pay Scale: {$job->salary_pay_scale}",
                    $docsLines ? "Required Documents:\n{$docsLines}" : null,
                    "URL: " . route('jobs.show', $job->slug),
                ])),
                'metadata'    => json_encode(['slug' => $job->slug]),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            DB::table('knowledge_chunks')->insert([
                'source_type' => 'job',
                'source_id'   => $job->id,
                'chunk_index' => 1,
                'title'       => $job->title . ' — Dates & How to Apply',
                'content'     => implode("\n", array_filter([
                    "Job: {$job->title}",
                    "Apply Start: " . ($job->apply_start?->format('d M Y') ?? 'N/A'),
                    "Apply End: " . ($job->apply_end?->format('d M Y') ?? 'N/A'),
                    "Exam Date: " . ($job->exam_date?->format('d M Y') ?? 'N/A'),
                    "Application Mode: {$job->application_mode}",
                    $feeLines ? "Application Fee:\n{$feeLines}" : null,
                    $stepsLines ? "How to Apply:\n{$stepsLines}" : null,
                ])),
                'metadata'    => json_encode(['slug' => $job->slug]),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ($job->faqs as $index => $faq) {
                DB::table('knowledge_chunks')->insert([
                    'source_type' => 'job',
                    'source_id'   => $job->id,
                    'chunk_index' => $index + 2,
                    'title'       => $job->title . ' — FAQ: ' . $faq->question,
                    'content'     => implode("\n", [
                        "Job: {$job->title}",
                        "Question: {$faq->question}",
                        "Answer: {$faq->answer}",
                    ]),
                    'metadata'    => json_encode(['slug' => $job->slug]),
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            $this->command->info("✅ Chunked job: {$job->title}");
        }

        // ── Blog ─────────────────────────────────────────────────────
        $blogs = Blog::published()->get();
        $this->command->info("📦 Found {$blogs->count()} published blog posts");

        foreach ($blogs as $blog) {
            DB::table('knowledge_chunks')->insert([
                'source_type' => 'blog',
                'source_id'   => $blog->id,
                'chunk_index' => 0,
                'title'       => $blog->title,
                'content'     => implode("\n", array_filter([
                    "Blog: {$blog->title}",
                    "Excerpt: {$blog->excerpt}",
                    "Content: " . strip_tags($blog->content ?? ''),
                    "URL: " . route('blog.show', $blog->slug),
                ])),
                'metadata'    => json_encode(['slug' => $blog->slug]),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $this->command->info("✅ Chunked blog: {$blog->title}");
        }

        $total = DB::table('knowledge_chunks')->count();
        $this->command->info("🎉 Total chunks created: {$total}");
    }
}