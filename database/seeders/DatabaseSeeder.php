<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LetterType;
use App\Models\News;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Desa Ciasmara',
            'email' => 'admin@ciasmara.desa.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123456',
            'gender' => 'L',
            'birth_date' => '1980-01-01',
            'address' => 'Kantor Desa Ciasmara',
            'phone' => '081234567890',
            'kk_number' => '1234567890123456',
            'role' => 'admin',
            'rt_rw' => null,
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // Create RT User
        User::create([
            'name' => 'RT 01 Ciasmara',
            'email' => 'rt01@ciasmara.desa.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123457',
            'gender' => 'L',
            'birth_date' => '1975-01-01',
            'address' => 'RT 01 Desa Ciasmara',
            'phone' => '081234567891',
            'kk_number' => '1234567890123457',
            'role' => 'rt',
            'rt_rw' => 'RT 01/RW 01',
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => 1,
        ]);

        // Create RW User
        User::create([
            'name' => 'RW 01 Ciasmara',
            'email' => 'rw01@ciasmara.desa.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123458',
            'gender' => 'L',
            'birth_date' => '1970-01-01',
            'address' => 'RW 01 Desa Ciasmara',
            'phone' => '081234567892',
            'kk_number' => '1234567890123458',
            'role' => 'rw',
            'rt_rw' => 'RW 01',
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => 1,
        ]);

        // Create Sample User
        User::create([
            'name' => 'Warga Desa Ciasmara',
            'email' => 'warga@example.com',
            'password' => Hash::make('password'),
            'nik' => '1234567890123459',
            'gender' => 'P',
            'birth_date' => '1990-01-01',
            'address' => 'RT 01/RW 01 Desa Ciasmara',
            'phone' => '081234567893',
            'kk_number' => '1234567890123459',
            'role' => 'user',
            'rt_rw' => 'RT 01/RW 01',
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => 1,
        ]);

        // Create Letter Types
        LetterType::create([
            'name' => 'Surat Keterangan Domisili',
            'description' => 'Surat keterangan tempat tinggal/domisili',
            'required_fields' => [
                'keperluan' => 'text',
                'alamat_domisili' => 'textarea'
            ],
            'template' => 'Surat Keterangan Domisili untuk {nama} dengan NIK {nik}',
            'is_active' => true,
        ]);

        LetterType::create([
            'name' => 'Surat Pengantar SKCK',
            'description' => 'Surat pengantar untuk pembuatan SKCK',
            'required_fields' => [
                'keperluan' => 'text',
                'kepolisian_tujuan' => 'text'
            ],
            'template' => 'Surat Pengantar SKCK untuk {nama} dengan NIK {nik}',
            'is_active' => true,
        ]);

        LetterType::create([
            'name' => 'Surat Keterangan Usaha',
            'description' => 'Surat keterangan untuk usaha/bisnis',
            'required_fields' => [
                'nama_usaha' => 'text',
                'jenis_usaha' => 'text',
                'alamat_usaha' => 'textarea',
                'modal_usaha' => 'number'
            ],
            'template' => 'Surat Keterangan Usaha untuk {nama_usaha} milik {nama}',
            'is_active' => true,
        ]);

        // Create Sample News
        News::create([
            'title' => 'Selamat Datang di Portal Desa Ciasmara',
            'excerpt' => 'Portal resmi untuk layanan administrasi desa Ciasmara telah diluncurkan',
            'content' => 'Dengan bangga kami mengumumkan peluncuran portal resmi Desa Ciasmara yang memungkinkan warga untuk mengajukan berbagai surat administrasi secara online. Portal ini dibuat untuk mempermudah pelayanan kepada masyarakat.',
            'status' => 'published',
            'category' => 'announcement',
            'author_id' => 1,
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Cara Menggunakan Layanan Online Desa',
            'excerpt' => 'Panduan lengkap menggunakan layanan administrasi online',
            'content' => 'Berikut adalah panduan lengkap untuk menggunakan layanan administrasi online Desa Ciasmara: 1. Daftar akun, 2. Verifikasi oleh admin, 3. Login dan ajukan surat, 4. Tunggu persetujuan RT/RW, 5. Download surat yang sudah jadi.',
            'status' => 'published',
            'category' => 'news',
            'author_id' => 1,
            'published_at' => now()->subDays(1),
        ]);
    }
}
