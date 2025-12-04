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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('family_name')->unique(); // Nama keluarga sebagai identifier
            $table->string('kk_number')->unique()->nullable(); // Nomor Kartu Keluarga
            $table->string('address'); // Alamat keluarga
            $table->string('rt', 10);
            $table->string('rw', 10);
            $table->string('rt_rw')->virtualAs('CONCAT("RT ", rt, "/RW ", rw)');
            $table->foreignId('head_of_family_id')->nullable()->constrained('users')->nullOnDelete(); // Kepala keluarga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
