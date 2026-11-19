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
        Schema::create('village_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedInteger('population')->nullable();
            $table->unsignedInteger('family_count')->nullable();
            $table->unsignedInteger('hamlet_count')->nullable();
            $table->decimal('area_size', 12, 2)->nullable();
            $table->string('area_unit')->default('km²');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('operational_hours')->nullable();
            $table->text('map_embed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_settings');
    }
};
