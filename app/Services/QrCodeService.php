<?php

namespace App\Services;

use App\Models\LetterRequest;

class QrCodeService
{
    public function generateLetterQrCode(LetterRequest $letterRequest): string
    {
        try {
            // Prepare data for QR Code
            $qrData = $this->prepareQrData($letterRequest);

            // Simple approach - just create QR code with basic settings
            $qrCode = new \Endroid\QrCode\QrCode($qrData);
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);

            // Save QR Code to storage
            $filename = 'qrcodes/letter_' . $letterRequest->request_number . '_' . time() . '.png';
            $fullPath = storage_path('app/public/' . $filename);

            // Create directory if not exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($fullPath, $result->getString());

            return $filename;
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('QR Code generation failed: ' . $e->getMessage());
            // Return empty string if QR generation fails
            return '';
        }
    }
    
    public function generateQrCodeBase64(LetterRequest $letterRequest): string
    {
        // Prepare data for QR Code
        $qrData = $this->prepareQrData($letterRequest);

        try {
            // Simple approach - just create QR code with basic settings
            $qrCode = new \Endroid\QrCode\QrCode($qrData);
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);

            // Return as base64 for embedding in PDF
            return 'data:image/png;base64,' . base64_encode($result->getString());
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('QR Code generation failed: ' . $e->getMessage());
            // Fallback: create a simple placeholder image
            return $this->createPlaceholderQrCode($letterRequest);
        }
    }

    private function createPlaceholderQrCode(LetterRequest $letterRequest): string
    {
        // Create a simple SVG placeholder
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
        <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
            <rect width="200" height="200" fill="#f3f4f6" stroke="#d1d5db" stroke-width="2"/>
            <text x="100" y="80" text-anchor="middle" font-family="Arial" font-size="12" fill="#374151">QR CODE</text>
            <text x="100" y="100" text-anchor="middle" font-family="Arial" font-size="10" fill="#6b7280">' . $letterRequest->request_number . '</text>
            <text x="100" y="120" text-anchor="middle" font-family="Arial" font-size="8" fill="#9ca3af">Scan untuk verifikasi</text>
            <text x="100" y="140" text-anchor="middle" font-family="Arial" font-size="8" fill="#9ca3af">GD Extension Required</text>
        </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
    
    private function prepareQrData(LetterRequest $letterRequest): string
    {
        $user = $letterRequest->user;
        $letterType = $letterRequest->letterType;

        // Get subject details (who the letter is for)
        $subjectDetails = $letterRequest->subject_details;

        // Create structured data for QR Code
        $qrData = [
            'surat_id' => $letterRequest->request_number,
            'jenis_surat' => $letterType->name,
            'nama_pengaju' => $user->name,
            'nik_pengaju' => $user->nik,
            'nama_subjek' => $subjectDetails['name'],
            'nik_subjek' => $subjectDetails['nik'],
            'hubungan' => $subjectDetails['relationship'],
            'alamat' => $user->address,
            'rt_rw' => $user->rt_rw,
            'tanggal_pengajuan' => $letterRequest->created_at->format('d/m/Y'),
            'tanggal_selesai' => $letterRequest->final_processed_at ? $letterRequest->final_processed_at->format('d/m/Y') : null,
            'status' => $letterRequest->status,
            'verifikasi_url' => route('qr-verification.verify', ['requestNumber' => $letterRequest->request_number]),
            'desa' => 'Desa Ciasmara',
            'timestamp' => now()->timestamp
        ];

        // Convert to JSON for QR Code content
        return json_encode($qrData, JSON_UNESCAPED_UNICODE);
    }
    
    public function verifyQrData(string $qrContent): array
    {
        try {
            $data = json_decode($qrContent, true);
            
            if (!$data || !isset($data['surat_id'])) {
                return ['valid' => false, 'message' => 'QR Code tidak valid'];
            }
            
            // Find letter request
            $letterRequest = LetterRequest::where('request_number', $data['surat_id'])->first();
            
            if (!$letterRequest) {
                return ['valid' => false, 'message' => 'Surat tidak ditemukan'];
            }
            
            if ($letterRequest->status !== 'approved_final') {
                return ['valid' => false, 'message' => 'Surat belum disetujui final'];
            }
            
            return [
                'valid' => true,
                'message' => 'Surat valid',
                'data' => $data,
                'letter_request' => $letterRequest
            ];
            
        } catch (\Exception $e) {
            return ['valid' => false, 'message' => 'Error parsing QR Code: ' . $e->getMessage()];
        }
    }

    public function getQrCodeDataUrl(LetterRequest $letterRequest): string
    {
        return $this->generateQrCodeBase64($letterRequest);
    }
}
