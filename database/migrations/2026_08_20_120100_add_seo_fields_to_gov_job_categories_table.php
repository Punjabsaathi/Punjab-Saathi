<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gov_job_categories', function (Blueprint $table) {
            // Category pages currently render with no title/meta of their
            // own — they silently inherit the hub page's <title>, so every
            // department page competes with the hub instead of ranking for
            // its own "{Department} Jobs" query.
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('gov_job_categories', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
    }
};
