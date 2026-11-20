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
        Schema::table('village_settings', function (Blueprint $table) {
            $table->string('deskripsi_singkat', 400)->nullable();
            $table->string('foto_profil')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->text('letak_geografis')->nullable();
            $table->string('batas_utara')->nullable();
            $table->string('batas_selatan')->nullable();
            $table->string('batas_timur')->nullable();
            $table->string('batas_barat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_settings', function (Blueprint $table) {
            $table->dropColumn([
                'deskripsi_singkat',
                'foto_profil',
                'sejarah',
                'visi',
                'misi',
                'letak_geografis',
                'batas_utara',
                'batas_selatan',
                'batas_timur',
                'batas_barat',
            ]);
        });
    }
};
