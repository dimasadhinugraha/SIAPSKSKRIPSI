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
        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama jenis surat (e.g., "Surat Keterangan Domisili")
            $table->text('description')->nullable(); // Deskripsi jenis surat
            $table->json('required_fields')->nullable(); // Field yang diperlukan untuk jenis surat ini
            $table->text('template')->nullable(); // Template surat
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_types');
    }
};
