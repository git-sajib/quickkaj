<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('short_url_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('short_url_id')->constrained()->cascadeOnDelete();
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('clicked_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('short_url_clicks');
    }
};
