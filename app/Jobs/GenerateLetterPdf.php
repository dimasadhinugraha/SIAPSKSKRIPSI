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
        // PDF generation is now on-demand and not persisted.
        // This job is kept for compatibility but will no longer write files.
        if ($this->letterRequest->status === 'approved_final') {
            \Log::info('GenerateLetterPdf job invoked, but generation is now on-demand. LetterRequest id: ' . $this->letterRequest->id);
        }
    }
}
