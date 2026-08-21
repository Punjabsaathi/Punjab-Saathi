<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gov_updates', function (Blueprint $table) {
            $table->id();

            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('content');

            // Classification / cross-linking
            $table->foreignId('category_id')->nullable()->constrained('gov_update_categories')->nullOnDelete();
            $table->foreignId('related_service_id')->nullable()->constrained('services')->nullOnDelete();

            // Media
            $table->string('featured_image')->nullable();
            $table->string('image_alt')->nullable();
            $table->boolean('is_important')->default(false);

            // Publishing
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();

            // Stats
            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gov_updates');
    }
};
