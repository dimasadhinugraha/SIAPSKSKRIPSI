<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
    $requests = TransferRequest::where('requested_by', Auth::user()->id)->with('familyMember')->latest()->get();
        return view('transfer-requests.index', compact('requests'));
    }

    public function create(FamilyMember $familyMember)
    {
        // Ensure the current user owns the family member
        $this->authorize('view', $familyMember);
        return view('transfer-requests.create', compact('familyMember'));
    }

    public function store(Request $request, FamilyMember $familyMember)
    {
        $this->authorize('view', $familyMember);

        $validated = $request->validate([
            'to_address' => 'required|string|max:500',
            'to_kk_number' => 'nullable|string|size:16',
            'reason' => 'nullable|string|max:2000',
            'supporting_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $data = [
            'family_member_id' => $familyMember->id,
            'requested_by' => Auth::user()->id,
            'to_address' => $validated['to_address'],
            'to_kk_number' => $validated['to_kk_number'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending'
        ];

        if ($request->hasFile('supporting_document')) {
            $data['supporting_document'] = $request->file('supporting_document')->store('transfer-documents', 'public');
        }

        TransferRequest::create($data);

        return redirect()->route('family-members.show', $familyMember)
            ->with('success', 'Pengajuan perpindahan berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(TransferRequest $transferRequest)
    {
        $this->authorize('view', $transferRequest->familyMember);
        return view('transfer-requests.show', compact('transferRequest'));
    }
}
