<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Singleton table (always exactly one row, id=1) holding the
        // backend-manageable SEO content for the /jobs hub page — title,
        // meta, H1, the intro/how-to-apply/eligibility copy blocks, and
        // the hub-level FAQ list, none of which are tied to any single
        // GovJob record.
        Schema::create('jobs_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('h1')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->longText('intro_content')->nullable();
            $table->longText('how_to_apply_content')->nullable();
            $table->longText('eligibility_content')->nullable();
            $table->json('faqs')->nullable();
            $table->boolean('schema_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs_page_settings');
    }
};
