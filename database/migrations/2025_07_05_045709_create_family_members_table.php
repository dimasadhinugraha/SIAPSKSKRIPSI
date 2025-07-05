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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']); // L = Laki-laki, P = Perempuan
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('relationship', [
                'kepala_keluarga',
                'istri',
                'suami',
                'anak',
                'menantu',
                'cucu',
                'orangtua',
                'mertua',
                'famili_lain',
                'pembantu',
                'lainnya'
            ]);
            $table->enum('religion', [
                'islam',
                'kristen',
                'katolik',
                'hindu',
                'buddha',
                'khonghucu',
                'lainnya'
            ]);
            $table->enum('education', [
                'tidak_sekolah',
                'belum_sekolah',
                'tidak_tamat_sd',
                'sd',
                'smp',
                'sma',
                'diploma_i',
                'diploma_ii',
                'diploma_iii',
                'diploma_iv',
                's1',
                's2',
                's3'
            ])->nullable();
            $table->string('occupation')->nullable();
            $table->enum('marital_status', [
                'belum_kawin',
                'kawin',
                'cerai_hidup',
                'cerai_mati'
            ]);
            $table->string('nationality', 50)->default('WNI');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'is_active']);
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
