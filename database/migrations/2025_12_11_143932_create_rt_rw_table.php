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
        Schema::create('rt_rw', function (Blueprint $table) {
            $table->id();
            $table->integer('rt');
            $table->integer('rw');
            $table->timestamps();
            
            // Ensure unique RT/RW combination
            $table->unique(['rt', 'rw']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt_rw');
    }
};
