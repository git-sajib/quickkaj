<?php

use Illuminate\Database\Migrations\Migration;

// This migration is intentionally empty.
// The queue jobs table already exists from 0001_01_01_000002_create_jobs_table.php
// Our portal uses job_listings table (see 2026_10_21_152824_create_jobs_table.php)
return new class extends Migration
{
    public function up(): void
    {
        // no-op
    }

    public function down(): void
    {
        // no-op
    }
};
