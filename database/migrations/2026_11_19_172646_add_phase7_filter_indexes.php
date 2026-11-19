<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->index(['status', 'published_at'], 'beritas_status_published_at_index');
            $table->index('berita_category_id', 'beritas_category_id_index');
        });

        Schema::table('dokumens', function (Blueprint $table) {
            $table->index(['is_published', 'category', 'year'], 'dokumens_published_category_year_index');
        });

        Schema::table('pembangunans', function (Blueprint $table) {
            $table->index(['status', 'start_date'], 'pembangunans_status_start_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembangunans', function (Blueprint $table) {
            $table->dropIndex('pembangunans_status_start_date_index');
        });
        Schema::table('dokumens', function (Blueprint $table) {
            $table->dropIndex('dokumens_published_category_year_index');
        });
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex('beritas_status_published_at_index');
            $table->dropIndex('beritas_category_id_index');
        });
    }
};
