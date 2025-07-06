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
        $letterRequest->load(['user', 'letterType', 'approvals.approver', 'subject']);

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
        $subjectDetails = $letterRequest->subject_details;

        // Generate QR Code for digital signature
        $qrCodeService = new \App\Services\QrCodeService();
        $qrCodeBase64 = $qrCodeService->generateQrCodeBase64($letterRequest);

        // Prepare data for template (merge user data with subject data and form data)
        $surat = (object) array_merge([
            'nomor_surat' => $letterRequest->request_number . '/DESA/' . $letterRequest->created_at->format('m/Y'),
            'nama_pengaju' => $user->name,
            'nik_pengaju' => $user->nik,
            'nama' => $subjectDetails['name'], // Subject of the letter
            'nik' => $subjectDetails['nik'],
            'tempat_lahir' => $subjectDetails['birth_place'] ?? $user->birth_place ?? 'Bogor',
            'tanggal_lahir' => $subjectDetails['birth_date'] ?? $user->birth_date,
            'jeniskelamin' => $subjectDetails['gender'] == 'L' ? 'Laki-laki' : 'Perempuan',
            'agama' => $user->religion ?? 'Islam',
            'pekerjaan' => $user->job ?? 'Wiraswasta',
            'alamat' => $subjectDetails['address'] ?? $user->address,
            'hubungan' => $subjectDetails['relationship'],
            'created_at' => $letterRequest->created_at,
        ], $formData ?? []);

        // Use specific template if available, otherwise use generic template
        $templateName = $letterType->template ?? 'pdf.letter-template';

        // Check if specific template exists in surat directory
        if ($letterType->template && view()->exists('surat.' . $letterType->template)) {
            return view('surat.' . $letterType->template, compact('surat', 'qrCodeBase64', 'letterRequest'))->render();
        }

        // Fallback to generic template
        return view('pdf.letter-template', compact('letterRequest', 'user', 'letterType', 'formData', 'qrCodeBase64', 'subjectDetails'))->render();
    }

    private function createPlaceholderQrCode(LetterRequest $letterRequest): string
    {
        // Create a simple SVG placeholder
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
        <svg width="120" height="120" xmlns="http://www.w3.org/2000/svg">
            <rect width="120" height="120" fill="#f9fafb" stroke="#d1d5db" stroke-width="1"/>
            <text x="60" y="40" text-anchor="middle" font-family="Arial" font-size="10" fill="#374151">QR CODE</text>
            <text x="60" y="55" text-anchor="middle" font-family="Arial" font-size="8" fill="#6b7280">' . $letterRequest->request_number . '</text>
            <text x="60" y="70" text-anchor="middle" font-family="Arial" font-size="7" fill="#9ca3af">Scan untuk verifikasi</text>
            <text x="60" y="85" text-anchor="middle" font-family="Arial" font-size="6" fill="#d1d5db">GD Extension Required</text>
        </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    // Old template methods (kept for reference but not used)
    private function generateLetterHtmlOld(LetterRequest $letterRequest): string
    {
        // This method contains the old hardcoded template
        // Now we use Blade template instead
        return '';
    }
}
