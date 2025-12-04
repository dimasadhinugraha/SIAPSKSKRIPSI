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
        $this->warn('This command is deprecated: the application now generates PDFs on-demand and does not persist PDF files.');
        $this->info('If you still need to generate PDF files for archiving, consider using a custom script that calls the PdfService and writes files locally.');
        return 0;
    }
}
