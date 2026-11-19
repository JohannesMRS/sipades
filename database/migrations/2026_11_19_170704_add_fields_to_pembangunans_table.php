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
        Schema::table('pembangunans', function (Blueprint $table) {
            $table->string('name');
            $table->string('location');
            $table->string('category');
            $table->unsignedBigInteger('budget');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->unsignedTinyInteger('progress')->default(0);
            $table->string('source')->nullable();
            $table->string('executor')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembangunans', function (Blueprint $table) {
            $table->dropColumn(['name', 'location', 'category', 'budget', 'start_date', 'end_date', 'status', 'progress', 'source', 'executor', 'image', 'description']);
        });
    }
};
