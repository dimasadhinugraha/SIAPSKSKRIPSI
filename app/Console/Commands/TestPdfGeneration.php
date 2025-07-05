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

        // Generate PDF
        try {
            $this->info('Generating PDF...');
            $filename = $pdfService->generateLetterPdf($letterRequest);
            $this->info("PDF generated successfully: {$filename}");

            // Check if file exists
            $fullPath = storage_path('app/public/' . $filename);
            if (file_exists($fullPath)) {
                $this->info("PDF file exists at: {$fullPath}");
                $this->info("File size: " . filesize($fullPath) . " bytes");
            } else {
                $this->error("PDF file not found at: {$fullPath}");
            }

        } catch (\Exception $e) {
            $this->error('PDF generation failed: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        $this->info('Test completed successfully!');
        return 0;
    }
}
