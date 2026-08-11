<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_download_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gov_form_id')->constrained('gov_forms')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamp('downloaded_at')->useCurrent();

            $table->index(['gov_form_id', 'downloaded_at']);
            $table->index('downloaded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_download_logs');
    }
};
