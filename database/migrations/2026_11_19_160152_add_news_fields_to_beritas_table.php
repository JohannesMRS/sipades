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
            $table->foreignId('berita_category_id')->nullable()->constrained('berita_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->index(['status', 'published_at', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at', 'is_featured']);
            $table->dropConstrainedForeignId('berita_category_id');
            $table->dropColumn(['title', 'slug', 'excerpt', 'content', 'image', 'status', 'published_at', 'is_featured']);
        });
    }
};
