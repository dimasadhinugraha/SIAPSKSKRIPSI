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
            // Add fields for village administration system
            $table->string('nik', 16)->unique()->after('email');
            $table->enum('gender', ['L', 'P'])->after('nik'); // L = Laki-laki, P = Perempuan
            $table->date('birth_date')->after('gender');
            $table->text('address')->after('birth_date');
            $table->string('phone', 15)->after('address');
            $table->string('kk_number', 16)->after('phone'); // Nomor Kartu Keluarga
            $table->string('ktp_photo')->nullable()->after('kk_number'); // Path to KTP photo
            $table->string('kk_photo')->nullable()->after('ktp_photo'); // Path to KK photo
            $table->enum('role', ['user', 'rt', 'rw', 'admin'])->default('user')->after('kk_photo');
            $table->string('rt_rw')->nullable()->after('role'); // RT/RW area (e.g., "RT 01/RW 02")
            $table->boolean('is_verified')->default(false)->after('rt_rw'); // Admin verification status
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');

            // Add foreign key for verified_by
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'nik', 'gender', 'birth_date', 'address', 'phone', 'kk_number',
                'ktp_photo', 'kk_photo', 'role', 'rt_rw', 'is_verified',
                'verified_at', 'verified_by'
            ]);
        });
    }
};
