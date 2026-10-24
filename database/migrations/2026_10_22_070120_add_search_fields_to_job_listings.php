<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            // Job search/filter fields
            $table->string('employment_type')->nullable()->after('application_url'); // full-time, part-time, contract, internship
            $table->string('education_level')->nullable()->after('employment_type'); // ssc, hsc, graduate, postgraduate, any
            $table->unsignedBigInteger('category_id')->nullable()->after('education_level');
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();

            // Verification & reporting
            $table->boolean('is_verified')->default(false)->after('is_published');
            $table->boolean('is_outdated')->default(false)->after('is_verified');
            $table->timestamp('reported_at')->nullable()->after('is_outdated');
            $table->text('report_reason')->nullable()->after('reported_at');

            // Index for search performance
            $table->index(['is_published', 'deadline', 'employment_type']);
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['is_published', 'deadline', 'employment_type']);
            $table->dropIndex(['category_id']);
            $table->dropColumn([
                'employment_type', 'education_level', 'category_id',
                'is_verified', 'is_outdated', 'reported_at', 'report_reason',
            ]);
        });
    }
};
