<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\LetterType;
use App\Models\LetterRequest;
use App\Services\PdfService;
use Illuminate\Console\Command;

class CreateAllLetterTypesDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:create-all-letters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create demo letter requests for all letter types';

    /**
     * Execute the console command.
     */
    public function handle(PdfService $pdfService)
    {
        $this->info('Creating demo letter requests for all types...');

        // Get test user
        $user = User::where('email', 'warga@example.com')->first();
        if (!$user) {
            $this->error('Test user not found. Please run database seeder first.');
            return 1;
        }

        // Get all letter types
        $letterTypes = LetterType::where('is_active', true)->get();
        if ($letterTypes->isEmpty()) {
            $this->error('No letter types found. Please run database seeder first.');
            return 1;
        }

        $this->info("Found {$letterTypes->count()} letter types");

        foreach ($letterTypes as $index => $letterType) {
            $this->info("Creating: {$letterType->name}");

            $requestNumber = 'DEMO-' . date('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            // Prepare form data based on letter type
            $formData = $this->getFormDataForLetterType($letterType);

            $letterRequest = LetterRequest::create([
                'request_number' => $requestNumber,
                'user_id' => $user->id,
                'letter_type_id' => $letterType->id,
                'form_data' => $formData,
                'status' => 'approved_final',
                'submitted_at' => now(),
                'rt_processed_at' => now(),
                'rw_processed_at' => now(),
                'final_processed_at' => now(),
            ]);

            // Generate PDF
            try {
                $filename = $pdfService->generateLetterPdf($letterRequest);
                $this->info("✅ PDF generated: {$filename}");
            } catch (\Exception $e) {
                $this->error("❌ PDF generation failed: " . $e->getMessage());
            }
        }

        $this->info("\n🎉 Demo completed! All letter types created with PDFs.");
        $this->info("You can view them at:");
        $this->info("- Dashboard: http://127.0.0.1:8000/dashboard");
        $this->info("- Letter Requests: http://127.0.0.1:8000/letter-requests");

        return 0;
    }

    private function getFormDataForLetterType(LetterType $letterType): array
    {
        $baseData = [
            'keperluan' => 'Demo keperluan untuk ' . $letterType->name,
        ];

        switch ($letterType->name) {
            case 'Surat Keterangan Domisili':
                return array_merge($baseData, [
                    'kampung' => 'Parabakti',
                ]);

            case 'Surat Pengantar SKCK':
                return array_merge($baseData, [
                    'kepolisian_tujuan' => 'Polres Bogor',
                ]);

            case 'Surat Keterangan Usaha':
                return [
                    'status_usaha' => 'Pemilik',
                    'jenis_usaha' => 'Warung Kelontong',
                    'tahun_usaha' => 5,
                    'wilayah_usaha' => 'Desa Ciasmara',
                ];

            case 'Surat Keterangan Kelahiran':
            case 'Surat Keterangan Kelahiran Laki-laki':
                return [
                    'nama_anakbaru' => 'Ahmad Bayu Pratama',
                    'jeniskelamin' => 'Laki-laki',
                    'angka' => 1,
                    'huruf' => 'Satu',
                    'nama_ayah' => 'Budi Santoso',
                    'tempat_lahir_ayah' => 'Bogor',
                    'tanggal_lahir_ayah' => '1985-05-15',
                    'pekerjaan_ayah' => 'Petani',
                    'agama_ayah' => 'Islam',
                    'nik_ayah' => '3201051505850001',
                    'alamat_ayah' => 'RT 01/RW 01 Desa Ciasmara',
                    'nama_ibu' => 'Siti Nurhaliza',
                    'tempat_lahir_ibu' => 'Bogor',
                    'tanggal_lahir_ibu' => '1990-08-20',
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'agama_ibu' => 'Islam',
                    'nik_ibu' => '3201052008900002',
                    'alamat_ibu' => 'RT 01/RW 01 Desa Ciasmara',
                    'tempat_lahir' => 'RSUD Cibinong',
                    'hari_lahir' => 'Senin',
                    'tanggal_lahir' => '2025-01-15',
                    'waktu_lahir' => '08:30',
                ];

            case 'Surat Keterangan Kehilangan':
                return array_merge($baseData, [
                    'barang_hilang' => 'KTP',
                    'tempat_hilang' => 'Pasar Ciasmara',
                    'tanggal_hilang' => '2025-01-01',
                    'kronologi' => 'Hilang saat berbelanja di pasar, kemungkinan jatuh dari dompet',
                ]);

            case 'Surat Keterangan Kematian':
                return [
                    'nama_almarhum' => 'H. Slamet Riyadi',
                    'tempat_lahir_almarhum' => 'Bogor',
                    'tanggal_lahir_almarhum' => '1950-12-25',
                    'umur_almarhum' => 74,
                    'agama_almarhum' => 'Islam',
                    'pekerjaan_almarhum' => 'Pensiunan',
                    'alamat_almarhum' => 'RT 02/RW 01 Desa Ciasmara',
                    'tempat_meninggal' => 'Rumah',
                    'tanggal_meninggal' => '2025-01-10',
                    'waktu_meninggal' => '15:30',
                    'sebab_meninggal' => 'Sakit',
                    'nama_pelapor' => 'Ahmad Riyadi',
                    'hubungan_pelapor' => 'Anak',
                ];

            case 'Surat Keterangan Tidak Mampu':
                return array_merge($baseData, [
                    'penghasilan_perbulan' => 500000,
                    'jumlah_tanggungan' => 4,
                    'kondisi_rumah' => 'Sederhana',
                    'pekerjaan_utama' => 'Buruh Tani',
                ]);

            default:
                return $baseData;
        }
    }
}
