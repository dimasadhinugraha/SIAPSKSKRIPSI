<?php

namespace App\Console\Commands;

use App\Models\LetterRequest;
use App\Services\PdfService;
use Illuminate\Console\Command;

class GenerateMissingPdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'letters:generate-missing-pdfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PDF files for approved letters that are missing PDF files';

    /**
     * Execute the console command.
     */
    public function handle(PdfService $pdfService)
    {
        $this->info('Searching for approved letters without PDF files...');

        $missingPdfLetters = LetterRequest::where('status', 'approved_final')
            ->whereNull('letter_file')
            ->get();

        if ($missingPdfLetters->isEmpty()) {
            $this->info('No letters found that need PDF generation.');
            return 0;
        }

        $this->info("Found {$missingPdfLetters->count()} letters that need PDF generation.");

        $bar = $this->output->createProgressBar($missingPdfLetters->count());
        $bar->start();

        foreach ($missingPdfLetters as $letter) {
            try {
                $pdfService->generateLetterPdf($letter);
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("\nFailed to generate PDF for letter {$letter->request_number}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info('PDF generation completed!');

        return 0;
    }
}
