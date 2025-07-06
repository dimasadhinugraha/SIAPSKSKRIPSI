<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FamilyMemberController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familyMembers = Auth::user()->activeFamilyMembers()
            ->orderBy('approval_status')
            ->orderBy('relationship')
            ->orderBy('date_of_birth')
            ->get();

        // Statistics
        $stats = [
            'total' => $familyMembers->count(),
            'pending' => $familyMembers->where('approval_status', 'pending')->count(),
            'approved' => $familyMembers->where('approval_status', 'approved')->count(),
            'rejected' => $familyMembers->where('approval_status', 'rejected')->count(),
        ];

        return view('family-members.index', compact('familyMembers', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('family-members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]{16}$/',
                Rule::unique('family_members')->where(function ($query) {
                    return $query->where('is_active', true);
                })
            ],
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'relationship' => 'required|in:' . implode(',', array_keys(FamilyMember::getRelationshipOptions())),
            'religion' => 'required|in:' . implode(',', array_keys(FamilyMember::getReligionOptions())),
            'education' => 'nullable|in:' . implode(',', array_keys(FamilyMember::getEducationOptions())),
            'occupation' => 'nullable|string|max:255',
            'marital_status' => 'required|in:' . implode(',', array_keys(FamilyMember::getMaritalStatusOptions())),
            'nationality' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'supporting_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.regex' => 'NIK harus berupa angka 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'name.required' => 'Nama wajib diisi',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'place_of_birth.required' => 'Tempat lahir wajib diisi',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini',
            'relationship.required' => 'Hubungan keluarga wajib dipilih',
            'religion.required' => 'Agama wajib dipilih',
            'marital_status.required' => 'Status perkawinan wajib dipilih',
            'supporting_document.required' => 'Dokumen pendukung wajib diupload',
            'supporting_document.mimes' => 'Format dokumen harus JPG, PNG, atau PDF',
            'supporting_document.max' => 'Ukuran dokumen maksimal 2MB'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['nationality'] = $validated['nationality'] ?? 'WNI';
        $validated['approval_status'] = 'pending'; // Default status

        // Handle file upload
        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('family-member-documents', $filename, 'public');
            $validated['supporting_document'] = $path;
        }

        FamilyMember::create($validated);

        return redirect()->route('family-members.index')
            ->with('success', 'Anggota keluarga berhasil ditambahkan! Menunggu persetujuan admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyMember $familyMember)
    {
        $this->authorize('view', $familyMember);

        return view('family-members.show', compact('familyMember'));
    }

    // Edit and Update methods removed - data cannot be edited after submission for data integrity

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyMember $familyMember)
    {
        $this->authorize('delete', $familyMember);

        // Soft delete by setting is_active to false
        $familyMember->update(['is_active' => false]);

        return redirect()->route('family-members.index')
            ->with('success', 'Anggota keluarga berhasil dihapus!');
    }
}
