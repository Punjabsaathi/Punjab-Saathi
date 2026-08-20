<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gov_jobs', function (Blueprint $table) {
            // JobPosting schema fields — override the free-text department/
            // official_website when the schema needs a cleaner value than
            // what reads well in the UI (e.g. "PSSSB" vs the full legal name).
            $table->string('employment_type')->default('FULL_TIME')->after('application_mode');
            $table->string('hiring_organization_name')->nullable()->after('employment_type');
            $table->string('hiring_organization_url')->nullable()->after('hiring_organization_name');
            $table->unsignedBigInteger('salary_min')->nullable()->after('salary_pay_scale');
            $table->unsignedBigInteger('salary_max')->nullable()->after('salary_min');
            $table->string('salary_currency', 10)->default('INR')->after('salary_max');
            $table->string('og_image')->nullable()->after('meta_keywords');
            // Lets the admin turn off JobPosting/FAQ JSON-LD for a specific
            // job (e.g. a draft entry still missing required fields) without
            // unpublishing the page itself.
            $table->boolean('schema_enabled')->default(true)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('gov_jobs', function (Blueprint $table) {
            $table->dropColumn([
                'employment_type', 'hiring_organization_name', 'hiring_organization_url',
                'salary_min', 'salary_max', 'salary_currency', 'og_image', 'schema_enabled',
            ]);
        });
    }
};
