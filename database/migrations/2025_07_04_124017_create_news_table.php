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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Ringkasan berita
            $table->longText('content');
            $table->string('featured_image')->nullable(); // Gambar utama berita
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->enum('category', ['news', 'announcement', 'event'])->default('news');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Add indexes
            $table->index(['status', 'published_at']);
            $table->index(['category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
