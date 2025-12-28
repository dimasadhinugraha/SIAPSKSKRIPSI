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
        // Tampilkan user yang belum diverifikasi admin ATAU yang belum verify email
        $pendingUsers = User::where(function($query) {
                $query->whereNull('email_verified_at')
                      ->orWhereNull('email_verified_at');
            })
            ->where('role', 'user')
            ->with('biodata')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistics
        $stats = [
            'pending' => User::whereNull('email_verified_at')->where('role', 'user')->count(),
            'verified' => User::whereNotNull('email_verified_at')->where('role', 'user')->count(),
            'total' => User::where('role', 'user')->count(),
            'today' => User::where('role', 'user')->whereDate('created_at', today())->count(),
        ];

        return view('admin.user-verification.index', compact('pendingUsers', 'stats'));
    }

    public function show(User $user)
    {
        $user->load('biodata');
        return view('admin.user-verification.show', compact('user'));
    }

    public function verify(Request $request, User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('admin.user-verification.index')
                ->with('error', 'User sudah terverifikasi.');
        }

        // Cek apakah user sudah verify email
        if (!$user->hasVerifiedEmail()) {
            return redirect()->back()
                ->with('error', 'User belum melakukan verifikasi email. Tidak dapat disetujui.');
        }

        // Mark email/admin verification and approval
        $user->email_verified_at = now();
        $user->is_approved = true;
        $user->save();

        // Log for debugging
        \Log::info('User verified', [
            'user_id' => $user->id,
            'email_verified_at' => $user->email_verified_at,
            'is_approved' => $user->is_approved
        ]);

        // Send activation notification to the user
        try {
            $user->notify(new \App\Notifications\AccountActivated());
        } catch (\Throwable $e) {
            logger()->warning('Failed to send account activation notification', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        return redirect()->route('admin.user-verification.index')
            ->with('success', "User {$user->name} berhasil disetujui dan notifikasi telah dikirim.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $userName = $user->name;
        $reason = $request->reason;

        // Send rejection notification email
        try {
            $user->notify(new \App\Notifications\AccountRejected($reason));
            logger()->info('Account rejection notification sent', ['user_id' => $user->id, 'email' => $user->email]);
        } catch (\Throwable $e) {
            logger()->warning('Failed to send account rejection notification', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        // Delete the user after sending notification
        $user->delete();

        return redirect()->route('admin.user-verification.index')
            ->with('success', "Pendaftaran user {$userName} ditolak dan notifikasi telah dikirim ke email.");
    }
}
