<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gov_form_id')->constrained('gov_forms')->cascadeOnDelete();
            $table->string('question');
            $table->text('answer');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['gov_form_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_faqs');
    }
};
