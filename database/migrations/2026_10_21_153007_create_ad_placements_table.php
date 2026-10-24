<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_placements', function (Blueprint $table) {
            $table->id();
            $table->string('slot_key')->unique(); // e.g. header-banner, sidebar-top
            $table->string('label'); // Human-readable admin label
            $table->text('html_code')->nullable(); // Admin-pasted Adsterra script
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_placements');
    }
};
