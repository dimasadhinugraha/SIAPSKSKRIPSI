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
        Schema::table('family_members', function (Blueprint $table) {
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_active');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
            $table->string('supporting_document')->nullable()->after('rejection_reason'); // Path to uploaded document

            // Add indexes
            $table->index(['approval_status', 'user_id']);
            $table->index('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_members', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['approval_status', 'user_id']);
            $table->dropIndex(['approved_by']);
            $table->dropColumn([
                'approval_status',
                'approved_by',
                'approved_at',
                'rejection_reason',
                'supporting_document'
            ]);
        });
    }
};
