<?php

namespace App\Http\Controllers;

use App\Models\LetterRequest;
use App\Models\LetterType;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterRequestController extends Controller
{
    // Middleware will be applied via routes

    public function index()
    {
        $requests = auth()->user()->letterRequests()
            ->with(['letterType', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('letter-requests.index', compact('requests'));
    }

    public function create()
    {
        $letterTypes = LetterType::active()->get();
        $familyMembers = auth()->user()->approvedFamilyMembers()->get();

        return view('letter-requests.create', compact('letterTypes', 'familyMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'subject_type' => 'required|in:self,family_member',
            'subject_id' => 'nullable|exists:family_members,id',
            'form_data' => 'required|array',
        ]);

        // Validate subject_id is required when subject_type is family_member
        if ($request->subject_type === 'family_member') {
            $request->validate([
                'subject_id' => 'required|exists:family_members,id'
            ]);

            // Ensure the family member belongs to the authenticated user and is approved
            $familyMember = auth()->user()->approvedFamilyMembers()->find($request->subject_id);
            if (!$familyMember) {
                return back()->withErrors(['subject_id' => 'Anggota keluarga tidak valid atau belum disetujui.']);
            }
        }

        $letterType = LetterType::findOrFail($request->letter_type_id);

        // Validate required fields based on letter type
        if ($letterType->required_fields) {
            foreach ($letterType->required_fields as $field => $type) {
                $request->validate([
                    "form_data.{$field}" => 'required'
                ]);
            }
        }

        // Generate request number
        $requestNumber = 'REQ-' . date('Ymd') . '-' . str_pad(
            LetterRequest::whereDate('created_at', today())->count() + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        $letterRequest = LetterRequest::create([
            'request_number' => $requestNumber,
            'user_id' => auth()->user()->id, // Use user()->id instead of auth()->id()
            'subject_type' => $request->subject_type,
            'subject_id' => $request->subject_type === 'family_member' ? $request->subject_id : null,
            'letter_type_id' => $request->letter_type_id,
            'form_data' => $request->form_data,
            'status' => 'pending_rt',
        ]);

        // Send notification to RT/RW
        try {
            $requester = auth()->user();
            // Kirim notifikasi hanya ke RT/RW yang sesuai wilayah pemohon
            $rtRwUsers = \App\Models\User::whereIn('role', ['rt', 'rw'])
                ->where('rw', $requester->rw)
                ->where(function($query) use ($requester) {
                    // Untuk RT, harus sama RT dan RW nya
                    // Untuk RW, cukup sama RW nya
                    $query->where('role', 'rw')
                          ->orWhere(function($q) use ($requester) {
                              $q->where('role', 'rt')
                                ->where('rt', $requester->rt);
                          });
                })
                ->get();
                
            foreach ($rtRwUsers as $rtRw) {
                $rtRw->notify(new \App\Notifications\NewLetterRequestNotification($letterRequest));
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to send letter request notification', ['error' => $e->getMessage()]);
        }

        return redirect()->route('letter-requests.index')
            ->with('success', 'Pengajuan surat berhasil dibuat dengan nomor: ' . $requestNumber);
    }

    public function show(LetterRequest $letterRequest, QrCodeService $qrCodeService)
    {
        $this->authorize('view', $letterRequest);

        $letterRequest->load(['letterType', 'approvals.approver', 'subject']);

        $qrCodeBase64 = null;
        if ($letterRequest->isApproved()) {
            $qrCodeBase64 = $qrCodeService->generateQrCodeBase64($letterRequest);
        }

        return view('letter-requests.show', compact('letterRequest', 'qrCodeBase64'));
    }

    public function download(LetterRequest $letterRequest)
    {
        $currentUser = auth()->user();
        $currentUserId = $currentUser->id; // Use user()->id instead of auth()->id()
        $letterUserId = $letterRequest->user_id;

        // Multiple comparison methods to ensure it works
        $isOwner = false;
        if ($letterUserId == $currentUserId) {
            $isOwner = true;
        } elseif ((string)$letterUserId === (string)$currentUserId) {
            $isOwner = true;
        } elseif ((int)$letterUserId === (int)$currentUserId) {
            $isOwner = true;
        }

        // Also check by user name as fallback
        if (!$isOwner && $letterRequest->user && $currentUser) {
            if ($letterRequest->user->name === $currentUser->name) {
                $isOwner = true;
            }
        }

        // Temporary: Allow access for debugging
        if (!$isOwner) {
            \Log::warning('Letter download ownership mismatch', [
                'letter_user_id' => $letterUserId,
                'current_user_id' => $currentUserId,
                'letter_user_name' => $letterRequest->user ? $letterRequest->user->name : 'Unknown',
                'current_user_name' => $currentUser->name,
                'letter_id' => $letterRequest->id
            ]);

            // Temporarily allow access for all verified users
            if (!$currentUser->is_verified) {
                abort(403, 'Akun Anda belum terverifikasi.');
            }
        }

        if (!$letterRequest->isApproved()) {
            abort(403, 'Surat belum disetujui dan tidak dapat didownload. Status: ' . $letterRequest->status);
        }

        // Generate PDF on-demand (do not rely on stored file)
        $pdfService = new \App\Services\PdfService();
        $pdfBinary = $pdfService->generateLetterPdfBinary($letterRequest);

        $filename = 'Surat_' . $letterRequest->request_number . '.pdf';

        return response()->streamDownload(function () use ($pdfBinary) {
            echo $pdfBinary;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
