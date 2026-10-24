<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('route_name', 100)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('device_type', 20)->nullable(); // mobile, tablet, desktop
            $table->string('country', 5)->nullable();      // BD, US, etc.
            $table->timestamp('viewed_at')->useCurrent();

            $table->index(['route_name', 'viewed_at']);
            $table->index('viewed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
