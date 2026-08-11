<?php

// ─────────────────────────────────────────────────────────
// Save as: database/migrations/2025_01_01_000001_create_gov_jobs_tables.php
// Run:     php artisan migrate
// ─────────────────────────────────────────────────────────

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Categories ──────────────────────────────────
        Schema::create('gov_job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();         // FontAwesome class e.g. fa-building
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── 2. Jobs ────────────────────────────────────────
        Schema::create('gov_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('gov_job_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department');
            $table->string('ad_number')->nullable();            // Advertisement number
            $table->string('location')->nullable();
            $table->unsignedInteger('total_posts')->default(0);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Eligibility
            $table->string('qualification')->nullable();
            $table->unsignedSmallInteger('age_min')->nullable();
            $table->unsignedSmallInteger('age_max')->nullable();
            $table->text('age_relaxation')->nullable();
            $table->text('experience_required')->nullable();

            // Salary
            $table->string('salary_pay_scale')->nullable();

            // Dates
            $table->date('publish_date')->nullable();
            $table->date('apply_start')->nullable();
            $table->date('apply_end')->nullable();
            $table->date('exam_date')->nullable();

            // Application
            $table->enum('application_mode', ['online', 'offline', 'both'])->default('online');
            $table->string('official_website')->nullable();

            // Fee (stored as JSON: {"general": 500, "sc_st": 250, "female": 0, "ex_serviceman": 0})
            $table->json('application_fee')->nullable();

            // Selection & Application process (JSON arrays)
            $table->json('selection_process')->nullable();   // ["Written Exam","Interview","Document Verification"]
            $table->json('application_steps')->nullable();   // ["Visit official website","Fill form","Pay fee","Submit"]
            $table->json('required_documents')->nullable();  // ["Aadhaar","10th Certificate","Photo","Signature"]

            // Exam pattern & Syllabus (JSON)
            $table->json('exam_pattern')->nullable();
            $table->json('syllabus')->nullable();            // {"Mathematics": "Algebra, Trigonometry...", "English": "..."}

            // Important links
            $table->string('notification_link')->nullable();
            $table->string('apply_link')->nullable();
            $table->string('syllabus_link')->nullable();
            $table->string('correction_form_link')->nullable();
            $table->string('merit_list_link')->nullable();
            $table->string('cutoff_link')->nullable();
            $table->string('previous_papers_link')->nullable();

            // Status & featured
            $table->enum('status', ['active', 'upcoming', 'expired'])->default('upcoming');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->index(['status', 'is_published']);
            $table->index('category_id');
            $table->index('apply_end');
        });

        // ── 3. Admit Cards ─────────────────────────────────
        Schema::create('gov_job_admit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('gov_jobs')->cascadeOnDelete();
            $table->string('title');
            $table->date('release_date')->nullable();
            $table->date('exam_date')->nullable();
            $table->string('download_link');
            $table->text('instructions')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // ── 4. Answer Keys ─────────────────────────────────
        Schema::create('gov_job_answer_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('gov_jobs')->cascadeOnDelete();
            $table->string('title');
            $table->date('release_date')->nullable();
            $table->date('objection_end_date')->nullable();
            $table->string('download_link');
            $table->text('objection_details')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // ── 5. Results ─────────────────────────────────────
        Schema::create('gov_job_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('gov_jobs')->cascadeOnDelete();
            $table->string('title');
            $table->date('result_date')->nullable();
            $table->string('download_link');
            $table->string('merit_list_link')->nullable();
            $table->string('cutoff_marks')->nullable();
            $table->string('scorecard_link')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // ── 6. Documents / Downloads ────────────────────────
        Schema::create('gov_job_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('gov_jobs')->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', [
                'notification', 'syllabus', 'admit_card', 'answer_key',
                'result', 'merit_list', 'cutoff', 'previous_paper',
                'correction_form', 'other'
            ])->default('other');
            $table->string('file_url');
            $table->string('file_size')->nullable();         // "2.4 MB"
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // ── 7. FAQs ────────────────────────────────────────
        Schema::create('gov_job_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('gov_jobs')->cascadeOnDelete();
            $table->text('question');
            $table->text('answer');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // ── 8. Updates / Timeline ──────────────────────────
        Schema::create('gov_job_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('gov_jobs')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('update_date');
            $table->enum('type', [
                'notification', 'admit_card', 'answer_key', 'result',
                'date_extended', 'correction', 'general'
            ])->default('general');
            $table->timestamps();
        });

        // ── 9. Form Filling Requests ───────────────────────
        Schema::create('gov_job_form_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained('gov_jobs')->nullOnDelete();
            $table->string('name');
            $table->string('phone', 15);
            $table->string('email')->nullable();
            $table->string('job_name')->nullable();
            $table->enum('service_type', ['job_form', 'admit_card', 'result', 'answer_key', 'other'])->default('job_form');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'contacted', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gov_job_form_requests');
        Schema::dropIfExists('gov_job_updates');
        Schema::dropIfExists('gov_job_faqs');
        Schema::dropIfExists('gov_job_documents');
        Schema::dropIfExists('gov_job_results');
        Schema::dropIfExists('gov_job_answer_keys');
        Schema::dropIfExists('gov_job_admit_cards');
        Schema::dropIfExists('gov_jobs');
        Schema::dropIfExists('gov_job_categories');
    }
};
