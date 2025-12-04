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
        Schema::table('biodatas', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['verified_by']);
            // Then drop columns
            $table->dropColumn(['is_verified', 'verified_at', 'verified_by', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('user_id');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->boolean('is_active')->default(true)->after('verified_by');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }
};
