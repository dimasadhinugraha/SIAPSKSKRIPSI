<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('biodata:id,user_id,profile_photo');

        // Filter by role
        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        // Search by name, email, or NIK
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->status === 'not_verified') {
                $query->where('is_verified', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'not_approved') {
                $query->where('is_approved', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $statistics = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'rt' => User::where('role', 'rt')->count(),
            'rw' => User::where('role', 'rw')->count(),
            'user' => User::where('role', 'user')->count(),
            'verified' => User::where('is_verified', true)->count(),
        ];

        return view('admin.users.index', compact('users', 'statistics'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'rt', 'rw', 'user'])],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'kk_number' => ['nullable', 'string', 'size:16'],
            'rt_rw' => ['nullable', 'string'],
            'ktp_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'kk_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_verified' => true, // Auto-verified by admin
                'is_approved' => true, // Auto-approved by admin
                'email_verified_at' => now(),
            ]);

            // Handle file uploads
            $ktpPath = null;
            $kkPath = null;

            if ($request->hasFile('ktp_photo')) {
                $ktpPath = $request->file('ktp_photo')->store('documents', 'public');
            }

            if ($request->hasFile('kk_photo')) {
                $kkPath = $request->file('kk_photo')->store('documents', 'public');
            }

            // Parse RT/RW if provided
            $rt = null;
            $rw = null;
            if ($request->rt_rw) {
                if (preg_match('/RT\s*(\d+).*RW\s*(\d+)/i', $request->rt_rw, $matches)) {
                    $rt = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                    $rw = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                }
            }

            // Create biodata
            $user->biodata()->create([
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'phone' => $request->phone,
                'kk_number' => $request->kk_number,
                'rt_rw' => $request->rt_rw,
                'rt' => $rt,
                'rw' => $rw,
                'ktp_photo' => $ktpPath,
                'kk_photo' => $kkPath,
                'is_verified' => true,
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded files if exists
            if (isset($ktpPath)) Storage::disk('public')->delete($ktpPath);
            if (isset($kkPath)) Storage::disk('public')->delete($kkPath);

            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('biodata', 'letterRequests', 'family');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load('biodata');
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'rt', 'rw', 'user'])],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'kk_number' => ['nullable', 'string', 'size:16'],
            'rt_rw' => ['nullable', 'string'],
            'is_verified' => ['boolean'],
            'is_approved' => ['boolean'],
            'ktp_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'kk_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        try {
            DB::beginTransaction();

            // Update user
            $userData = [
                'name' => $request->name,
                'nik' => $request->nik,
                'email' => $request->email,
                'role' => $request->role,
                'is_verified' => $request->boolean('is_verified'),
                'is_approved' => $request->boolean('is_approved'),
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Handle file uploads
            $ktpPath = $user->biodata->ktp_photo ?? null;
            $kkPath = $user->biodata->kk_photo ?? null;

            if ($request->hasFile('ktp_photo')) {
                // Delete old file
                if ($ktpPath) Storage::disk('public')->delete($ktpPath);
                $ktpPath = $request->file('ktp_photo')->store('documents', 'public');
            }

            if ($request->hasFile('kk_photo')) {
                // Delete old file
                if ($kkPath) Storage::disk('public')->delete($kkPath);
                $kkPath = $request->file('kk_photo')->store('documents', 'public');
            }

            // Parse RT/RW if provided
            $rt = null;
            $rw = null;
            if ($request->rt_rw) {
                if (preg_match('/RT\s*(\d+).*RW\s*(\d+)/i', $request->rt_rw, $matches)) {
                    $rt = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                    $rw = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                }
            }

            // Update or create biodata
            $user->biodata()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'gender' => $request->gender,
                    'birth_date' => $request->birth_date,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'kk_number' => $request->kk_number,
                    'rt_rw' => $request->rt_rw,
                    'rt' => $rt,
                    'rw' => $rw,
                    'ktp_photo' => $ktpPath,
                    'kk_photo' => $kkPath,
                ]
            );

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal mengupdate user: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri!']);
        }

        try {
            DB::beginTransaction();

            // Delete associated files
            if ($user->biodata) {
                if ($user->biodata->ktp_photo) {
                    Storage::disk('public')->delete($user->biodata->ktp_photo);
                }
                if ($user->biodata->kk_photo) {
                    Storage::disk('public')->delete($user->biodata->kk_photo);
                }
                $user->biodata->delete();
            }

            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus user: ' . $e->getMessage()]);
        }
    }

    /**
     * Toggle user verification status
     */
    public function toggleVerification(User $user)
    {
        $user->update([
            'is_verified' => !$user->is_verified,
            'email_verified_at' => !$user->is_verified ? null : now(),
        ]);

        $status = $user->is_verified ? 'diverifikasi' : 'dibatalkan verifikasinya';
        return back()->with('success', "User berhasil {$status}!");
    }

    /**
     * Toggle user approval status
     */
    public function toggleApproval(User $user)
    {
        $user->update([
            'is_approved' => !$user->is_approved,
        ]);

        $status = $user->is_approved ? 'disetujui' : 'dibatalkan persetujuannya';
        return back()->with('success', "User berhasil {$status}!");
    }
}
