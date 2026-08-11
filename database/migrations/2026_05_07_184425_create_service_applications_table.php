<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('reference_no')->unique(); // PSK-2024-XXXXX
            $table->string('name');
            $table->string('phone', 15);
            $table->string('email')->nullable();
            $table->text('address');
            $table->text('message')->nullable();
            $table->json('document_paths')->nullable(); // Array of uploaded file paths
            $table->enum('status', ['pending', 'in_review', 'processing', 'completed', 'rejected'])
                  ->default('pending');
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['service_id', 'status']);
            $table->index('reference_no');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_applications');
    }
};
