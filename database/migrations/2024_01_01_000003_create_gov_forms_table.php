<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gov_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('form_categories')->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('form_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_mime')->default('application/pdf');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->date('published_date')->nullable();
            // SEO
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index(['is_featured', 'is_active']);
            $table->index(['is_popular', 'is_active']);
            $table->index('download_count');
            $table->index('published_date');
            $table->fullText(['title', 'short_description', 'meta_keywords']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gov_forms');
    }
};
