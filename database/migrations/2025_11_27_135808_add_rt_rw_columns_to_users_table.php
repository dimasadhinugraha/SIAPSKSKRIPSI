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
            $table->string('rt', 10)->nullable()->after('role');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('address')->nullable()->after('rw');
            $table->string('phone', 20)->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'address', 'phone']);
        });
    }
};
