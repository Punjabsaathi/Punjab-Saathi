<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tag');                        // e.g. "UIDAI / Aadhaar"
            $table->string('category');                   // identity | certificates | registrations | schemes | jobs
            $table->string('icon')->default('fa-file');   // Font Awesome class
            $table->string('color')->default('#fc5e28');  // Hex color for icon bg
            $table->text('short_desc');                   // Card description
            $table->longText('overview');                 // Full HTML overview for detail page
            $table->string('processing_time');            // "3–7 Days"
            $table->string('fee_range')->nullable();      // "₹99 – ₹299"
            $table->text('fee_note')->nullable();         // Additional fee note
            $table->text('eligibility')->nullable();      // Who can apply
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
