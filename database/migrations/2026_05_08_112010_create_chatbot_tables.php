<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Chat Sessions: Using UUID as primary key for better security
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_token', 64)->unique();
            $table->enum('language', ['en', 'hi', 'pa'])->default('en');
            $table->string('user_ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index(['session_token']);
            $table->index(['user_id']);
        });

        // 2. Chat Messages: Linked to UUID session
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id');
            $table->enum('role', ['user', 'assistant', 'system']);
            $table->text('content');
            $table->string('language', 8)->default('en');
            $table->string('intent', 64)->nullable();
            $table->integer('tokens_used')->default(0);
            $table->integer('latency_ms')->default(0);
            $table->boolean('was_cached')->default(false);
            $table->float('similarity_score')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('chat_sessions')->cascadeOnDelete();
            $table->index(['session_id', 'created_at']);
            $table->index('intent');
        });

        // 3. Knowledge Chunks: Optimized for MySQL RAG
        Schema::create('knowledge_chunks', function (Blueprint $table) {
            $table->id();
            $table->enum('source_type', ['service', 'faq', 'document', 'scheme', 'blog']);
            $table->unsignedBigInteger('source_id');
            $table->unsignedInteger('chunk_index')->default(0);
            $table->text('content'); // English content for embedding search
            
            // Fixed: Added JSON column to store Gemini Embeddings (768 dimensions)
            $table->json('embedding')->nullable(); 

            $table->string('title')->nullable();
            $table->text('content_hi')->nullable(); // Hindi version
            $table->text('content_pa')->nullable(); // Punjabi version
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('embedded_at')->nullable();
            $table->timestamps();

            $table->index(['source_type', 'source_id']);
            $table->index('is_active');
            
            // Fulltext search index for backup keyword matching
            $table->fullText('content'); 
        });

        // 4. Analytics: Performance & User Satisfaction tracking
        Schema::create('chat_analytics', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id');
            $table->foreignId('user_message_id')->constrained('chat_messages');
            $table->foreignId('assistant_message_id')->constrained('chat_messages');
            $table->string('intent', 64)->nullable();
            $table->string('language', 8);
            $table->integer('latency_ms');
            $table->boolean('was_status_check')->default(false);
            $table->integer('chunks_retrieved')->default(0);
            $table->float('top_similarity')->nullable();
            $table->boolean('user_rated')->default(false);
            $table->tinyInteger('rating')->nullable();
            $table->timestamps();

            $table->index('intent');
            $table->index('language');
            $table->index('created_at');
        });

        // 5. Rate Limiting: Essential for shared hosting to prevent API abuse
        Schema::create('chatbot_rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 64); // IP or Session Token
            $table->unsignedInteger('request_count')->default(0);
            $table->timestamp('window_start');
            $table->timestamps();

            $table->unique('identifier');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_rate_limits');
        Schema::dropIfExists('chat_analytics');
        Schema::dropIfExists('knowledge_chunks');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_sessions');
    }
};