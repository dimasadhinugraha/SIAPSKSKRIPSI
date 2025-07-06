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

            // Create QR code with basic settings
            $qrCode = new \Endroid\QrCode\QrCode($qrData);
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);

            // Add logo to QR code
            $qrCodeWithLogo = $this->addLogoToQrCode($result->getString());

            // Save QR Code to storage
            $filename = 'qrcodes/letter_' . $letterRequest->request_number . '_' . time() . '.png';
            $fullPath = storage_path('app/public/' . $filename);

            // Create directory if not exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($fullPath, $qrCodeWithLogo);

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
            // Create QR code with basic settings
            $qrCode = new \Endroid\QrCode\QrCode($qrData);
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);

            // Add logo to QR code
            $qrCodeWithLogo = $this->addLogoToQrCode($result->getString());

            // Return as base64 for embedding in PDF
            return 'data:image/png;base64,' . base64_encode($qrCodeWithLogo);
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
        // Return direct URL for QR code scanning
        // This allows users to scan QR code directly without needing to visit the website first
        $verificationUrl = route('qr-verification.verify', ['requestNumber' => $letterRequest->request_number]);

        return $verificationUrl;
    }

    /**
     * Get detailed data for verification page (used by verification controller)
     */
    public function getLetterDataForVerification(LetterRequest $letterRequest): array
    {
        $user = $letterRequest->user;
        $letterType = $letterRequest->letterType;

        // Get subject details (who the letter is for)
        $subjectDetails = $letterRequest->subject_details;

        // Create structured data for verification display
        return [
            'surat_id' => $letterRequest->request_number,
            'jenis_surat' => $letterType->name,
            'nama_pengaju' => $user->name,
            'nik_pengaju' => $user->nik,
            'nama_subjek' => $subjectDetails['name'],
            'nik_subjek' => $subjectDetails['nik'],
            'hubungan' => $subjectDetails['relationship'],
            'alamat' => $user->address,
            'rt_rw' => $user->rt_rw,
            'tanggal_pengajuan' => $letterRequest->created_at->format('d/m/Y H:i'),
            'tanggal_selesai' => $letterRequest->final_processed_at ? $letterRequest->final_processed_at->format('d/m/Y H:i') : null,
            'status' => $letterRequest->status,
            'status_display' => $this->getStatusDisplay($letterRequest->status),
            'desa' => 'Desa Ciasmara',
            'timestamp' => now()->timestamp,
            'valid' => true
        ];
    }

    /**
     * Get human-readable status display
     */
    private function getStatusDisplay(string $status): string
    {
        $statusMap = [
            'pending_rt' => 'Menunggu Persetujuan RT',
            'approved_rt' => 'Disetujui RT',
            'rejected_rt' => 'Ditolak RT',
            'pending_rw' => 'Menunggu Persetujuan RW',
            'approved_rw' => 'Disetujui RW',
            'rejected_rw' => 'Ditolak RW',
            'pending_village' => 'Menunggu Persetujuan Desa',
            'approved' => 'Disetujui - Surat Selesai',
            'rejected' => 'Ditolak'
        ];

        return $statusMap[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
    
    public function verifyQrData(string $qrContent): array
    {
        try {
            // Check if QR content is a URL (new format)
            if (filter_var($qrContent, FILTER_VALIDATE_URL)) {
                // Extract request number from URL
                $requestNumber = $this->extractRequestNumberFromUrl($qrContent);
                if (!$requestNumber) {
                    return ['valid' => false, 'message' => 'URL QR Code tidak valid'];
                }

                // Find letter request by request number
                $letterRequest = LetterRequest::where('request_number', $requestNumber)->first();

                if (!$letterRequest) {
                    return ['valid' => false, 'message' => 'Surat tidak ditemukan'];
                }

                // Return verification data
                return [
                    'valid' => true,
                    'message' => 'Surat valid',
                    'data' => $this->getLetterDataForVerification($letterRequest),
                    'letter_request' => $letterRequest
                ];
            }

            // Legacy format: JSON data (for backward compatibility)
            $data = json_decode($qrContent, true);

            if (!$data || !isset($data['surat_id'])) {
                return ['valid' => false, 'message' => 'QR Code tidak valid'];
            }

            // Find letter request
            $letterRequest = LetterRequest::where('request_number', $data['surat_id'])->first();

            if (!$letterRequest) {
                return ['valid' => false, 'message' => 'Surat tidak ditemukan'];
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

    /**
     * Extract request number from verification URL
     */
    private function extractRequestNumberFromUrl(string $url): ?string
    {
        try {
            // Parse URL to get path
            $parsedUrl = parse_url($url);
            $path = $parsedUrl['path'] ?? '';

            // Extract request number from path like /qr-verification/verify/REQ-20250706-0001
            if (preg_match('/\/qr-verification\/verify\/([^\/\?]+)/', $path, $matches)) {
                return $matches[1];
            }

            // Try to get from query parameter
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
                if (isset($queryParams['requestNumber'])) {
                    return $queryParams['requestNumber'];
                }
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('Failed to extract request number from URL: ' . $e->getMessage());
            return null;
        }
    }

    public function getQrCodeDataUrl(LetterRequest $letterRequest): string
    {
        return $this->generateQrCodeBase64($letterRequest);
    }

    /**
     * Add logo to QR code center
     */
    private function addLogoToQrCode(string $qrCodePng): string
    {
        try {
            // Check if GD extension is available
            if (!extension_loaded('gd')) {
                \Log::warning('GD extension not available, returning QR code without logo');
                return $qrCodePng;
            }

            // Create image from QR code PNG data
            $qrImage = imagecreatefromstring($qrCodePng);
            if (!$qrImage) {
                return $qrCodePng;
            }

            // Get QR code dimensions
            $qrWidth = imagesx($qrImage);
            $qrHeight = imagesy($qrImage);

            // Create or get logo
            $logoImage = $this->createLogo();
            if (!$logoImage) {
                return $qrCodePng;
            }

            // Calculate logo size (about 20% of QR code size)
            $logoSize = min($qrWidth, $qrHeight) * 0.2;
            $logoX = ($qrWidth - $logoSize) / 2;
            $logoY = ($qrHeight - $logoSize) / 2;

            // Resize logo to fit
            $resizedLogo = imagecreatetruecolor($logoSize, $logoSize);
            imagecopyresampled(
                $resizedLogo, $logoImage,
                0, 0, 0, 0,
                $logoSize, $logoSize,
                imagesx($logoImage), imagesy($logoImage)
            );

            // Create white background circle for logo
            $white = imagecolorallocate($qrImage, 255, 255, 255);
            $circleSize = $logoSize + 10; // Add padding
            $circleX = ($qrWidth - $circleSize) / 2;
            $circleY = ($qrHeight - $circleSize) / 2;

            imagefilledellipse($qrImage,
                $circleX + $circleSize/2,
                $circleY + $circleSize/2,
                $circleSize, $circleSize,
                $white
            );

            // Overlay logo on QR code
            imagecopymerge($qrImage, $resizedLogo, $logoX, $logoY, 0, 0, $logoSize, $logoSize, 100);

            // Clean up
            imagedestroy($logoImage);
            imagedestroy($resizedLogo);

            // Convert back to PNG string
            ob_start();
            imagepng($qrImage);
            $result = ob_get_contents();
            ob_end_clean();

            // Clean up
            imagedestroy($qrImage);

            return $result;
        } catch (\Exception $e) {
            \Log::error('Failed to add logo to QR code: ' . $e->getMessage());
            return $qrCodePng; // Return original QR code if logo addition fails
        }
    }

    /**
     * Create logo image
     */
    private function createLogo()
    {
        try {
            // Priority order for logo files
            $logoPaths = [
                public_path('images/ciasmara.png'),      // Primary: Desa Ciasmara logo
                public_path('images/logo.png'),          // Alternative: Generic logo
                public_path('images/logo.jpg'),
                public_path('images/logo.jpeg'),
                public_path('images/desa-logo.png'),
                storage_path('app/public/logo.png'),
                storage_path('app/public/ciasmara.png')
            ];

            foreach ($logoPaths as $path) {
                if (file_exists($path)) {
                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    switch ($extension) {
                        case 'png':
                            $logo = imagecreatefrompng($path);
                            if ($logo) {
                                \Log::info('Using logo: ' . $path);
                                return $logo;
                            }
                            break;
                        case 'jpg':
                        case 'jpeg':
                            $logo = imagecreatefromjpeg($path);
                            if ($logo) {
                                \Log::info('Using logo: ' . $path);
                                return $logo;
                            }
                            break;
                        case 'gif':
                            $logo = imagecreatefromgif($path);
                            if ($logo) {
                                \Log::info('Using logo: ' . $path);
                                return $logo;
                            }
                            break;
                    }
                }
            }

            // If no logo file found, create a simple text-based logo
            \Log::info('No logo file found, creating text-based logo');
            return $this->createTextLogo();
        } catch (\Exception $e) {
            \Log::error('Failed to create logo: ' . $e->getMessage());
            return $this->createTextLogo();
        }
    }

    /**
     * Create simple text-based logo
     */
    private function createTextLogo()
    {
        try {
            // Create a simple 120x120 logo with text
            $logoImage = imagecreatetruecolor(120, 120);

            // Colors - using blue theme for Ciasmara
            $blue = imagecolorallocate($logoImage, 30, 64, 175);    // Royal blue
            $white = imagecolorallocate($logoImage, 255, 255, 255);
            $lightBlue = imagecolorallocate($logoImage, 59, 130, 246); // Light blue

            // Fill background with gradient effect
            imagefill($logoImage, 0, 0, $blue);

            // Add decorative border
            imagerectangle($logoImage, 0, 0, 119, 119, $white);
            imagerectangle($logoImage, 1, 1, 118, 118, $white);
            imagerectangle($logoImage, 2, 2, 117, 117, $lightBlue);

            // Add main text "DESA" in center
            $text = 'DESA';
            $fontSize = 3; // Built-in font size
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);
            $x = (120 - $textWidth) / 2;
            $y = (120 - $textHeight) / 2 - 15;

            imagestring($logoImage, $fontSize, $x, $y, $text, $white);

            // Add "CIASMARA" below
            $subText = 'CIASMARA';
            $subFontSize = 2;
            $subTextWidth = imagefontwidth($subFontSize) * strlen($subText);
            $subX = (120 - $subTextWidth) / 2;
            $subY = $y + $textHeight + 2;

            imagestring($logoImage, $subFontSize, $subX, $subY, $subText, $white);

            // Add "DIGITAL" at bottom
            $bottomText = 'DIGITAL';
            $bottomFontSize = 1;
            $bottomTextWidth = imagefontwidth($bottomFontSize) * strlen($bottomText);
            $bottomX = (120 - $bottomTextWidth) / 2;
            $bottomY = $subY + imagefontheight($subFontSize) + 3;

            imagestring($logoImage, $bottomFontSize, $bottomX, $bottomY, $bottomText, $lightBlue);

            return $logoImage;
        } catch (\Exception $e) {
            \Log::error('Failed to create text logo: ' . $e->getMessage());
            return null;
        }
    }
}
