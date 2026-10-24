<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->string('employer_bn')->nullable();
            $table->string('employer_en')->nullable();
            $table->string('location_bn')->nullable();
            $table->string('location_en')->nullable();
            $table->text('eligibility_bn')->nullable();
            $table->text('eligibility_en')->nullable();
            $table->longText('description_bn')->nullable();
            $table->longText('description_en')->nullable();
            $table->date('deadline')->nullable();
            $table->string('source_url')->nullable();
            $table->string('application_url')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
