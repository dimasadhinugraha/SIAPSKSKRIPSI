<?php

namespace App\Http\Controllers;

use App\Models\LetterRequest;
use App\Models\LetterApproval;
use App\Jobs\GenerateLetterPdf;
use App\Services\PdfService;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    // Middleware will be applied via routes

    public function index()
    {
        $user = auth()->user();

        if ($user->isRT()) {
            // RT hanya lihat surat dari warga yang rt_id nya sama dengan user ini
            $requests = LetterRequest::with(['user.biodata', 'letterType', 'subject'])
                ->where('status', 'pending_rt')
                ->whereHas('user.biodata', function($query) use ($user) {
                    $query->where('rt_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($user->isRW()) {
            // RW hanya lihat surat dari warga yang rw_id nya sama dengan user ini
            $requests = LetterRequest::with(['user.biodata', 'letterType', 'subject'])
                ->where('status', 'pending_rw')
                ->whereHas('user.biodata', function($query) use ($user) {
                    $query->where('rw_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            abort(403);
        }

        return view('approvals.index', compact('requests'));
    }

    public function history()
    {
        $user = auth()->user();

        if ($user->isRT()) {
            // Get letters that have been processed by this RT
            $requests = LetterRequest::with(['user', 'letterType', 'approvals.approver'])
                ->whereHas('approvals', function($query) use ($user) {
                    $query->where('approved_by', $user->id)
                          ->where('approval_level', 'rt');
                })
                ->whereIn('status', ['pending_rw', 'approved_final', 'rejected_rt'])
                ->orderBy('rt_processed_at', 'desc')
                ->paginate(10);
        } elseif ($user->isRW()) {
            // Get letters that have been processed by this RW
            $requests = LetterRequest::with(['user', 'letterType', 'approvals.approver'])
                ->whereHas('approvals', function($query) use ($user) {
                    $query->where('approved_by', $user->id)
                          ->where('approval_level', 'rw');
                })
                ->whereIn('status', ['approved_final', 'rejected_rw'])
                ->orderBy('rw_processed_at', 'desc')
                ->paginate(10);
        } else {
            abort(403);
        }

        return view('approvals.history', compact('requests'));
    }

    public function show(LetterRequest $letterRequest)
    {
        $user = auth()->user();

        // Check if user has permission to view this request
        $canView = false;

        if ($user->isRT()) {
            // RT can view pending_rt requests or requests they have processed
            $canView = in_array($letterRequest->status, ['pending_rt', 'pending_rw', 'approved_final', 'rejected_rt']) ||
                      $letterRequest->approvals()->where('approved_by', $user->id)
                                                 ->where('approval_level', 'rt')
                                                 ->exists();
        }

        if ($user->isRW()) {
            // RW can view pending_rw requests or requests they have processed
            $canView = in_array($letterRequest->status, ['pending_rw', 'approved_final', 'rejected_rw']) ||
                      $letterRequest->approvals()->where('approved_by', $user->id)
                                                 ->where('approval_level', 'rw')
                                                 ->exists();
        }

        if (!$canView) {
            abort(403);
        }

        $letterRequest->load(['user.biodata', 'letterType', 'approvals.approver', 'subject']);

        return view('approvals.show', compact('letterRequest'));
    }

    public function approve(Request $request, LetterRequest $letterRequest)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $user = auth()->user();
        $approvalLevel = $user->isRT() ? 'rt' : ($user->isRW() ? 'rw' : null);

        if (!$approvalLevel) {
            abort(403);
        }

        // Check if already approved at this level
        $existingApproval = LetterApproval::where('letter_request_id', $letterRequest->id)
            ->where('approval_level', $approvalLevel)
            ->first();

        if ($existingApproval) {
            return redirect()->back()->with('error', 'Surat sudah diproses sebelumnya.');
        }

        // Create approval record
        LetterApproval::create([
            'letter_request_id' => $letterRequest->id,
            'approved_by' => $user->id,
            'approval_level' => $approvalLevel,
            'status' => 'approved',
            'notes' => $request->notes,
        ]);

        // Update letter request status
        if ($approvalLevel === 'rt') {
            $letterRequest->update([
                'status' => 'pending_rw',
                'rt_processed_at' => now(),
            ]);
            
            $message = 'Surat berhasil disetujui. Menunggu persetujuan RW.';
        } elseif ($approvalLevel === 'rw') {
            $letterRequest->update([
                'status' => 'approved_final',
                'rw_processed_at' => now(),
                'final_processed_at' => now(),
            ]);

            // Send notification to user that their letter is approved
            try {
                // Email + Database notification
                $letterRequest->user->notify(new \App\Notifications\LetterApprovedNotification($letterRequest));
                
                // WhatsApp notification
                $whatsapp = app(\App\Services\WhatsAppService::class);
                if ($whatsapp->isConfigured() && $letterRequest->user->phone) {
                    $whatsapp->sendLetterApprovedNotification($letterRequest->user, $letterRequest);
                }
            } catch (\Throwable $e) {
                \Log::warning('Failed to send letter approved notification', [
                    'letter_request_id' => $letterRequest->id,
                    'user_id' => $letterRequest->user_id,
                    'error' => $e->getMessage()
                ]);
            }

            $message = 'Surat berhasil disetujui. Notifikasi telah dikirim ke pemohon.';
        }

        return redirect()->route('approvals.index')
            ->with('success', $message ?? 'Surat berhasil disetujui.');
    }

    public function reject(Request $request, LetterRequest $letterRequest)
    {
        $request->validate([
            'notes' => 'required|string|max:500'
        ]);

        $user = auth()->user();
        $approvalLevel = $user->isRT() ? 'rt' : ($user->isRW() ? 'rw' : null);

        if (!$approvalLevel) {
            abort(403);
        }

        // Check if already processed at this level
        $existingApproval = LetterApproval::where('letter_request_id', $letterRequest->id)
            ->where('approval_level', $approvalLevel)
            ->first();

        if ($existingApproval) {
            return redirect()->back()->with('error', 'Surat sudah diproses sebelumnya.');
        }

        // Create rejection record
        LetterApproval::create([
            'letter_request_id' => $letterRequest->id,
            'approved_by' => $user->id,
            'approval_level' => $approvalLevel,
            'status' => 'rejected',
            'notes' => $request->notes,
        ]);

        // Update letter request status
        $letterRequest->update([
            'status' => $approvalLevel === 'rt' ? 'rejected_rt' : 'rejected_rw',
            'rejection_reason' => $request->notes,
            $approvalLevel . '_processed_at' => now(),
        ]);

        return redirect()->route('approvals.index')
            ->with('success', 'Surat berhasil ditolak.');
    }
}
