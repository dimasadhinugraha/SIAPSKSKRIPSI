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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kk_number');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth_date');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('rt_rw')->nullable();
            $table->foreignId('rt_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('rw_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ktp_photo')->nullable();
            $table->string('kk_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
