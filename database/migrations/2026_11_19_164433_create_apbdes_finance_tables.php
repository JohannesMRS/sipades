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
        Schema::create('budget_years', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('report_pdf')->nullable();
            $table->timestamps();
        });

        Schema::create('budget_fields', function (Blueprint $table): void {
            $table->id();
            $table->unsignedTinyInteger('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('budget_incomes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('budget_year_id')->constrained()->cascadeOnDelete();
            $table->string('group');
            $table->string('name');
            $table->unsignedBigInteger('budget_amount');
            $table->unsignedBigInteger('realized_amount')->default(0);
            $table->timestamps();
        });

        Schema::create('budget_financing', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('budget_year_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('name');
            $table->unsignedBigInteger('budget_amount');
            $table->unsignedBigInteger('realized_amount')->default(0);
            $table->timestamps();
        });

        Schema::create('budget_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('budget_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('budget_field_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('budget_amount');
            $table->unsignedBigInteger('realized_amount')->default(0);
            $table->string('status')->default('Belum Dimulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_activities');
        Schema::dropIfExists('budget_financing');
        Schema::dropIfExists('budget_incomes');
        Schema::dropIfExists('budget_fields');
        Schema::dropIfExists('budget_years');
    }
};
