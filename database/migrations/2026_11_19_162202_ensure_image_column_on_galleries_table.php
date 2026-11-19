<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Image column already exists in the original galleries migration.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback action; image belongs to the original schema.
    }
};
