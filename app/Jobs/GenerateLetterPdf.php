<?php

namespace App\Jobs;

use App\Models\LetterRequest;
use App\Services\PdfService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateLetterPdf implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public LetterRequest $letterRequest
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PdfService $pdfService): void
    {
        // Only generate PDF for approved letters
        if ($this->letterRequest->status === 'approved_final') {
            $pdfService->generateLetterPdf($this->letterRequest);
        }
    }
}
