<?php

namespace App\Services;

use App\Models\LetterRequest;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;

class QrCodeService
{
    public function generateLetterQrCode(LetterRequest $letterRequest): string
    {
        // Prepare data for QR Code
        $qrData = $this->prepareQrData($letterRequest);

        try {
            // Create QR Code (simple approach)
            $qrCode = new QrCode($qrData);

            // Generate PNG
            $writer = new PngWriter();
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
            // Return empty string if QR generation fails
            return '';
        }
    }
    
    public function generateQrCodeBase64(LetterRequest $letterRequest): string
    {
        // Prepare data for QR Code
        $qrData = $this->prepareQrData($letterRequest);

        try {
            // Create QR Code (simple approach)
            $qrCode = new QrCode($qrData);

            // Generate PNG
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Return as base64 for embedding in PDF
            return 'data:image/png;base64,' . base64_encode($result->getString());
        } catch (\Exception $e) {
            // Fallback: return a simple text placeholder
            return 'data:text/plain;base64,' . base64_encode('QR Code: ' . $letterRequest->request_number);
        }
    }
    
    private function prepareQrData(LetterRequest $letterRequest): string
    {
        $user = $letterRequest->user;
        $letterType = $letterRequest->letterType;
        
        // Create structured data for QR Code
        $qrData = [
            'surat_id' => $letterRequest->request_number,
            'jenis_surat' => $letterType->name,
            'nama_pengaju' => $user->name,
            'nik' => $user->nik,
            'alamat' => $user->address,
            'rt_rw' => $user->rt_rw,
            'tanggal_pengajuan' => $letterRequest->created_at->format('Y-m-d'),
            'tanggal_selesai' => $letterRequest->final_processed_at ? $letterRequest->final_processed_at->format('Y-m-d') : null,
            'status' => $letterRequest->status,
            'verifikasi_url' => url('/verify-letter/' . $letterRequest->request_number),
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
}
