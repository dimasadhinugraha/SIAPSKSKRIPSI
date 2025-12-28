<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration removes columns from the 'users' table that are now in the 'biodatas' table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraints before dropping the columns
            // We can drop them directly because the previous migrations in a fresh run will have created them.
            $table->dropForeign(['rt_id']);
            $table->dropForeign(['rw_id']);
            $table->dropForeign(['verified_by']);

            $columnsToDrop = [
                // 'name', // Keep for display and identification
                // 'nik', // Keep for authentication
                // 'is_verified', // Keep for user verification status
                // 'kk_number', // Keep for family card number
                'gender',
                'birth_date',
                'address',
                'phone',
                'rt_rw',
                'verified_at',
                'verified_by',
                'rt_id',
                'rw_id',
            ];

            // Drop only the columns that exist
            $existingColumns = Schema::getColumnListing('users');
            $columnsToDrop = array_intersect($columnsToDrop, $existingColumns);
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     * This method restores the columns to the 'users' table.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore only the columns that were dropped
            $table->string('kk_number')->nullable()->after('nik');
            $table->enum('gender', ['L', 'P'])->nullable()->after('kk_number');
            $table->date('birth_date')->nullable()->after('gender');
            $table->text('address')->nullable()->after('birth_date');
            $table->string('phone')->nullable()->after('address');
            $table->string('rt_rw')->nullable()->after('phone');
            $table->foreignId('rt_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('rw_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_verified')->default(false)->after('rw_id');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }
};
