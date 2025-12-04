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
        if (Schema::hasTable('letter_requests') && Schema::hasColumn('letter_requests', 'letter_file')) {
            Schema::table('letter_requests', function (Blueprint $table) {
                $table->dropColumn('letter_file');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('letter_requests') && !Schema::hasColumn('letter_requests', 'letter_file')) {
            Schema::table('letter_requests', function (Blueprint $table) {
                $table->string('letter_file')->nullable()->after('rejection_reason');
            });
        }
    }
};
