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
        Schema::create('letter_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('approved_by')->constrained('users')->onDelete('cascade');
            $table->enum('approval_level', ['rt', 'rw', 'admin']); // Level persetujuan
            $table->enum('status', ['approved', 'rejected']);
            $table->text('notes')->nullable(); // Catatan dari approver
            $table->timestamp('processed_at')->useCurrent();
            $table->timestamps();

            // Ensure one approval per level per request
            $table->unique(['letter_request_id', 'approval_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_approvals');
    }
};
