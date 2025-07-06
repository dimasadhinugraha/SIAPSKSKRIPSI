<?php

namespace App\Http\Controllers;

use App\Models\LetterRequest;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class QrVerificationController extends Controller
{
    public function verify($requestNumber)
    {
        $letterRequest = LetterRequest::where('request_number', $requestNumber)
            ->with(['user', 'letterType', 'approvals.approver', 'subject'])
            ->first();

        if (!$letterRequest) {
            return view('qr-verification.result', [
                'valid' => false,
                'message' => 'Surat tidak ditemukan',
                'letterRequest' => null
            ]);
        }

        // Debug mode - show detailed status info
        if (request()->has('debug')) {
            dd([
                'request_number' => $letterRequest->request_number,
                'status' => $letterRequest->status,
                'status_label' => $letterRequest->status_label,
                'is_approved' => $letterRequest->isApproved(),
                'rt_processed_at' => $letterRequest->rt_processed_at,
                'rw_processed_at' => $letterRequest->rw_processed_at,
                'final_processed_at' => $letterRequest->final_processed_at,
                'approvals' => $letterRequest->approvals->map(function($approval) {
                    return [
                        'level' => $approval->approval_level,
                        'status' => $approval->status,
                        'approver' => $approval->approver->name,
                        'notes' => $approval->notes,
                        'created_at' => $approval->created_at
                    ];
                })
            ]);
        }

        // Check if letter is approved (final status is 'approved_final')
        if ($letterRequest->status !== 'approved_final') {
            return view('qr-verification.result', [
                'valid' => false,
                'message' => 'Surat belum disetujui final atau masih dalam proses. Status saat ini: ' . $letterRequest->status_label,
                'letterRequest' => $letterRequest
            ]);
        }

        // Get additional verification data
        $qrCodeService = new \App\Services\QrCodeService();
        $verificationData = $qrCodeService->getLetterDataForVerification($letterRequest);

        return view('qr-verification.result', [
            'valid' => true,
            'message' => 'Surat valid dan telah disetujui',
            'letterRequest' => $letterRequest,
            'verificationData' => $verificationData
        ]);
    }

    public function scan()
    {
        return view('qr-verification.scan');
    }

    public function verifyQrContent(Request $request, QrCodeService $qrCodeService)
    {
        $request->validate([
            'qr_content' => 'required|string'
        ]);

        $result = $qrCodeService->verifyQrData($request->qr_content);

        return response()->json($result);
    }
}
