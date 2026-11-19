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
        Schema::create('project_documentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembangunan_id')->constrained('pembangunans')->cascadeOnDelete();
            $table->string('stage');
            $table->date('date');
            $table->text('caption');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_documentations');
    }
};
