<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FamilyMemberApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = FamilyMember::with(['user', 'approver'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('approval_status', $request->status);
        }

        // Search by name or NIK
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $familyMembers = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => FamilyMember::count(),
            'pending' => FamilyMember::pending()->count(),
            'approved' => FamilyMember::approved()->count(),
            'rejected' => FamilyMember::rejected()->count(),
        ];

        return view('admin.family-member-approvals.index', compact('familyMembers', 'stats'));
    }

    public function show(FamilyMember $familyMember)
    {
        $familyMember->load(['user', 'approver']);

        return view('admin.family-member-approvals.show', compact('familyMember'));
    }

    public function approve(Request $request, FamilyMember $familyMember)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $familyMember->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => null
        ]);

        return redirect()->route('admin.family-member-approvals.index')
            ->with('success', "Anggota keluarga {$familyMember->name} telah disetujui!");
    }

    public function reject(Request $request, FamilyMember $familyMember)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi'
        ]);

        $familyMember->update([
            'approval_status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->route('admin.family-member-approvals.index')
            ->with('success', "Anggota keluarga {$familyMember->name} telah ditolak!");
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'family_member_ids' => 'required|array',
            'family_member_ids.*' => 'exists:family_members,id'
        ]);

        $count = FamilyMember::whereIn('id', $request->family_member_ids)
            ->where('approval_status', 'pending')
            ->update([
                'approval_status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'rejection_reason' => null
            ]);

        return redirect()->route('admin.family-member-approvals.index')
            ->with('success', "{$count} anggota keluarga telah disetujui!");
    }

    public function downloadDocument(FamilyMember $familyMember)
    {
        if (!$familyMember->supporting_document) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $familyMember->supporting_document);

        if (!file_exists($filePath)) {
            abort(404, 'File dokumen tidak ditemukan');
        }

        return response()->download($filePath);
    }
}
