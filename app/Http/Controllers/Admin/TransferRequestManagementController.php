<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferRequestManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $requests = TransferRequest::with(['familyMember', 'requester'])->latest()->get();
        return view('admin.transfer-requests.index', compact('requests'));
    }

    public function show(TransferRequest $transferRequest)
    {
        return view('admin.transfer-requests.show', compact('transferRequest'));
    }

    public function approve(Request $request, TransferRequest $transferRequest)
    {
        if ($transferRequest->status !== 'pending') {
            return back()->with('warning', 'Permintaan sudah diproses.');
        }

        $transferRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->id,
            'approved_at' => now(),
        ]);

        // Optionally, mark the family member as inactive or handle other business logic
        $transferRequest->familyMember->update(['is_active' => false]);

        return redirect()->route('admin.transfer-requests.index')->with('success', 'Pengajuan perpindahan disetujui.');
    }

    public function reject(Request $request, TransferRequest $transferRequest)
    {
        $request->validate(['rejection_reason' => 'nullable|string|max:2000']);

        if ($transferRequest->status !== 'pending') {
            return back()->with('warning', 'Permintaan sudah diproses.');
        }

        $transferRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::user()->id,
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.transfer-requests.index')->with('success', 'Pengajuan perpindahan ditolak.');
    }
}
