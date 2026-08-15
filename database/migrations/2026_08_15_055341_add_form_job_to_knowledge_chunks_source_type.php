<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * knowledge_chunks.source_type is a DB enum — MySQL requires a raw
     * MODIFY COLUMN to add new enum values, Laravel's schema builder has
     * no portable "add enum value" helper.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE knowledge_chunks MODIFY COLUMN source_type ENUM('service','faq','document','scheme','blog','form','job') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE knowledge_chunks MODIFY COLUMN source_type ENUM('service','faq','document','scheme','blog') NOT NULL");
    }
};
