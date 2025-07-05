<?php

namespace App\Services;

use App\Models\LetterRequest;
use App\Services\QrCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    public function generateLetterPdf(LetterRequest $letterRequest): string
    {
        $letterRequest->load(['user', 'letterType', 'approvals.approver']);
        
        // Generate PDF content
        $html = $this->generateLetterHtml($letterRequest);
        
        // Create PDF
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'letters/' . $letterRequest->request_number . '_' . time() . '.pdf';
        
        // Save PDF to storage
        Storage::disk('public')->put($filename, $pdf->output());
        
        // Update letter request with file path
        $letterRequest->update(['letter_file' => $filename]);
        
        return $filename;
    }
    
    private function generateLetterHtml(LetterRequest $letterRequest): string
    {
        $user = $letterRequest->user;
        $letterType = $letterRequest->letterType;
        $formData = $letterRequest->form_data;

        // Generate QR Code for digital signature
        $qrCodeService = app(QrCodeService::class);
        $qrCodeBase64 = $qrCodeService->generateQrCodeBase64($letterRequest);

        // Prepare data for template (merge user data with form data)
        $surat = (object) array_merge([
            'nomor_surat' => $letterRequest->request_number . '/DESA/' . $letterRequest->created_at->format('m/Y'),
            'nama' => $user->name,
            'nik' => $user->nik,
            'tempat_lahir' => $user->birth_place ?? 'Bogor',
            'tanggal_lahir' => $user->birth_date,
            'jeniskelamin' => $user->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'agama' => $user->religion ?? 'Islam',
            'pekerjaan' => $user->job ?? 'Wiraswasta',
            'alamat' => $user->address,
            'created_at' => $letterRequest->created_at,
        ], $formData ?? []);

        // Use specific template if available, otherwise use generic template
        $templateName = $letterType->template ?? 'pdf.letter-template';

        // Check if specific template exists in surat directory
        if ($letterType->template && view()->exists('surat.' . $letterType->template)) {
            return view('surat.' . $letterType->template, compact('surat', 'qrCodeBase64'))->render();
        }

        // Fallback to generic template
        return view('pdf.letter-template', compact('letterRequest', 'user', 'letterType', 'formData', 'qrCodeBase64'))->render();
    }

    // Old template methods (kept for reference but not used)
    private function generateLetterHtmlOld(LetterRequest $letterRequest): string
    {
        // This method contains the old hardcoded template
        // Now we use Blade template instead
        return '';
    }
}
