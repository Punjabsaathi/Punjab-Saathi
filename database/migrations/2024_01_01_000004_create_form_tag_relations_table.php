<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_tag_relations', function (Blueprint $table) {
            $table->foreignId('gov_form_id')->constrained('gov_forms')->cascadeOnDelete();
            $table->foreignId('form_tag_id')->constrained('form_tags')->cascadeOnDelete();
            $table->primary(['gov_form_id', 'form_tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_tag_relations');
    }
};
