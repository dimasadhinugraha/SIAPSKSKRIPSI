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
        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique(); // Nomor pengajuan otomatis
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('letter_type_id')->constrained()->onDelete('cascade');
            $table->json('form_data'); // Data form yang diisi user
            $table->enum('status', [
                'pending_rt', 'approved_rt', 'rejected_rt',
                'pending_rw', 'approved_rw', 'rejected_rw',
                'approved_final', 'rejected_final'
            ])->default('pending_rt');
            $table->text('rejection_reason')->nullable();
            $table->string('letter_file')->nullable(); // Path ke file PDF surat yang sudah jadi
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('rt_processed_at')->nullable();
            $table->timestamp('rw_processed_at')->nullable();
            $table->timestamp('final_processed_at')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_requests');
    }
};
