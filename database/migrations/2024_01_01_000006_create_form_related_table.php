<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_related', function (Blueprint $table) {
            $table->foreignId('gov_form_id')->constrained('gov_forms')->cascadeOnDelete();
            $table->foreignId('related_form_id')->constrained('gov_forms')->cascadeOnDelete();
            $table->primary(['gov_form_id', 'related_form_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_related');
    }
};
