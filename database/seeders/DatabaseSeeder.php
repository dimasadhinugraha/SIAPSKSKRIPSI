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
        $letterTypes = [
            [
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Surat keterangan tempat tinggal/domisili',
                'required_fields' => [
                    'kampung' => 'text',
                    'keperluan' => 'text'
                ],
                'template' => 'suratketerangandomisili',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Pengantar SKCK',
                'description' => 'Surat pengantar untuk pembuatan SKCK',
                'required_fields' => [
                    'keperluan' => 'text',
                    'kepolisian_tujuan' => 'text'
                ],
                'template' => 'suratpengantarskck',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'description' => 'Surat keterangan untuk usaha/bisnis',
                'required_fields' => [
                    'status_usaha' => 'select',
                    'jenis_usaha' => 'text',
                    'tahun_usaha' => 'number',
                    'wilayah_usaha' => 'text'
                ],
                'template' => 'suratketeranganusaha',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'description' => 'Surat keterangan kelahiran anak',
                'required_fields' => [
                    'nama_anakbaru' => 'text',
                    'jeniskelamin' => 'select',
                    'angka' => 'number',
                    'huruf' => 'text',
                    'nama_ayah' => 'text',
                    'tempat_lahir_ayah' => 'text',
                    'tanggal_lahir_ayah' => 'date',
                    'pekerjaan_ayah' => 'text',
                    'agama_ayah' => 'text',
                    'nik_ayah' => 'text',
                    'alamat_ayah' => 'textarea',
                    'nama_ibu' => 'text',
                    'tempat_lahir_ibu' => 'text',
                    'tanggal_lahir_ibu' => 'date',
                    'pekerjaan_ibu' => 'text',
                    'agama_ibu' => 'text',
                    'nik_ibu' => 'text',
                    'alamat_ibu' => 'textarea',
                    'tempat_lahir' => 'text',
                    'hari_lahir' => 'text',
                    'tanggal_lahir' => 'date',
                    'waktu_lahir' => 'time'
                ],
                'template' => 'suratketerangankelahiran',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Kelahiran Laki-laki',
                'description' => 'Surat keterangan kelahiran khusus laki-laki',
                'required_fields' => [
                    'nama_anakbaru' => 'text',
                    'angka' => 'number',
                    'huruf' => 'text',
                    'nama_ayah' => 'text',
                    'tempat_lahir_ayah' => 'text',
                    'tanggal_lahir_ayah' => 'date',
                    'pekerjaan_ayah' => 'text',
                    'agama_ayah' => 'text',
                    'nik_ayah' => 'text',
                    'alamat_ayah' => 'textarea',
                    'nama_ibu' => 'text',
                    'tempat_lahir_ibu' => 'text',
                    'tanggal_lahir_ibu' => 'date',
                    'pekerjaan_ibu' => 'text',
                    'agama_ibu' => 'text',
                    'nik_ibu' => 'text',
                    'alamat_ibu' => 'textarea',
                    'tempat_lahir' => 'text',
                    'hari_lahir' => 'text',
                    'tanggal_lahir' => 'date',
                    'waktu_lahir' => 'time'
                ],
                'template' => 'suratkerangankelahiranlakilaki',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Kehilangan',
                'description' => 'Surat keterangan kehilangan dokumen/barang',
                'required_fields' => [
                    'barang_hilang' => 'text',
                    'tempat_hilang' => 'text',
                    'tanggal_hilang' => 'date',
                    'kronologi' => 'textarea',
                    'keperluan' => 'text'
                ],
                'template' => 'suratketerangankehilangan',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'description' => 'Surat keterangan kematian',
                'required_fields' => [
                    'nama_almarhum' => 'text',
                    'tempat_lahir_almarhum' => 'text',
                    'tanggal_lahir_almarhum' => 'date',
                    'umur_almarhum' => 'number',
                    'agama_almarhum' => 'text',
                    'pekerjaan_almarhum' => 'text',
                    'alamat_almarhum' => 'textarea',
                    'tempat_meninggal' => 'text',
                    'tanggal_meninggal' => 'date',
                    'waktu_meninggal' => 'time',
                    'sebab_meninggal' => 'text',
                    'nama_pelapor' => 'text',
                    'hubungan_pelapor' => 'text'
                ],
                'template' => 'suratketerangankematian',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'description' => 'Surat keterangan tidak mampu/miskin',
                'required_fields' => [
                    'keperluan' => 'text',
                    'penghasilan_perbulan' => 'number',
                    'jumlah_tanggungan' => 'number',
                    'kondisi_rumah' => 'text',
                    'pekerjaan_utama' => 'text'
                ],
                'template' => 'suratketerangantidakmampu',
                'is_active' => true,
            ],
        ];

        foreach ($letterTypes as $type) {
            LetterType::create($type);
        }

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
