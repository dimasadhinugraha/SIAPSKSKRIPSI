<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\LetterType;
use App\Models\LetterRequest;
use App\Services\PdfService;
use Illuminate\Console\Command;

class TestPdfGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf-generation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation for letter requests';

    /**
     * Execute the console command.
     */
    public function handle(PdfService $pdfService)
    {
        $this->info('Creating test letter request...');

        // Get or create test user
        $user = User::where('email', 'warga@example.com')->first();
        if (!$user) {
            $this->error('Test user not found. Please run database seeder first.');
            return 1;
        }

        // Get letter type
        $letterType = LetterType::where('name', 'Surat Keterangan Domisili')->first();
        if (!$letterType) {
            $this->error('Letter type not found. Please run database seeder first.');
            return 1;
        }

        // Create test letter request
        $letterRequest = LetterRequest::create([
            'request_number' => 'TEST-' . date('Ymd') . '-' . time(),
            'user_id' => $user->id,
            'letter_type_id' => $letterType->id,
            'form_data' => [
                'kampung' => 'Parabakti',
                'keperluan' => 'Test PDF Generation'
            ],
            'status' => 'approved_final',
            'submitted_at' => now(),
            'rt_processed_at' => now(),
            'rw_processed_at' => now(),
            'final_processed_at' => now(),
        ]);

        $this->info("Letter request created with ID: {$letterRequest->id}");

        // Generate PDF binary (on-demand). We do not persist to storage by default.
        try {
            $this->info('Generating PDF (in-memory)...');
            $pdfBinary = $pdfService->generateLetterPdfBinary($letterRequest);
            $this->info('PDF generated in-memory, size: ' . strlen($pdfBinary) . ' bytes');

            // Optional: write a temp file for quick manual checking (doesn't update DB)
            $tempPath = storage_path('app/temp');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }
            $fileName = 'test_letter_' . $letterRequest->id . '.pdf';
            $fullPath = $tempPath . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents($fullPath, $pdfBinary);
            $this->info("Temporary PDF written to: {$fullPath}");

        } catch (\Exception $e) {
            $this->error('PDF generation failed: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        $this->info('Test completed successfully!');
        return 0;
    }
}
