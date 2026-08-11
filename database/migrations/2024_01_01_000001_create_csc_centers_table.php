<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('csc_centers', function (Blueprint $table) {
            $table->id();
            $table->string('csc_id')->nullable()->unique()->comment('Official CSC ID from government portal');
            $table->string('vle_name')->nullable()->comment('VLE / Operator name');
            $table->string('kiosk_name')->nullable()->comment('Kiosk / Center name');
            $table->string('mobile', 15)->nullable()->unique()->comment('Primary key for upsert — no duplicates by phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->default('Punjab');
            $table->string('pincode', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('registered_on')->nullable()->comment('Date registered on government portal');
            $table->string('source')->default('self-registered')->comment('locator.csccloud.in | self-registered | admin');
            $table->boolean('is_verified')->default(false)->comment('Admin has verified this agent');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable()->comment('Admin notes');
            $table->timestamps();

            $table->index('district');
            $table->index('sub_district');
            $table->index('is_verified');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('csc_centers');
    }
};
