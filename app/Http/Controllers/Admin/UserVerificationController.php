<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    // Middleware will be applied via routes

    public function index()
    {
        $pendingUsers = User::where('is_verified', false)
            ->where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.user-verification.index', compact('pendingUsers'));
    }

    public function show(User $user)
    {
        if ($user->is_verified) {
            return redirect()->route('admin.user-verification.index')
                ->with('error', 'User sudah terverifikasi.');
        }

        return view('admin.user-verification.show', compact('user'));
    }

    public function verify(Request $request, User $user)
    {
        if ($user->is_verified) {
            return redirect()->route('admin.user-verification.index')
                ->with('error', 'User sudah terverifikasi.');
        }

        $user->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        return redirect()->route('admin.user-verification.index')
            ->with('success', "User {$user->name} berhasil diverifikasi.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        // For now, we'll just delete the user. In production, you might want to keep a record
        $user->delete();

        return redirect()->route('admin.user-verification.index')
            ->with('success', 'Pendaftaran user ditolak dan data telah dihapus.');
    }
}
