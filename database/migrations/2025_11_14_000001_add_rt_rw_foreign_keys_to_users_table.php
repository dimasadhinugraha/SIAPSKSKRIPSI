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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rt_id')->nullable()->after('rt_rw')->constrained('users')->nullOnDelete();
            $table->foreignId('rw_id')->nullable()->after('rt_id')->constrained('users')->nullOnDelete();

            $table->index(['rt_id', 'rw_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rt_id');
            $table->dropConstrainedForeignId('rw_id');
        });
    }
};
