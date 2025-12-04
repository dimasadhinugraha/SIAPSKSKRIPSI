<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class GuestVerifyEmailController extends Controller
{
    /**
     * Handle an incoming guest verification request.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        // Ensure the URL signature is valid
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired verification link.');
        }

        $user = User::findOrFail($id);

        // Validate the hash matches the user's email
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification data.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email sudah terverifikasi. Silakan login.');
        }

        // Mark verified
        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Silakan tunggu persetujuan admin jika diperlukan.');
    }

    /**
     * Resend verification email for a guest user (not logged in)
     */
    public function resend(Request $request): RedirectResponse
    {
        \Log::info('Resend verification method called', ['email' => $request->email]);
        
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            \Log::warning('Resend verification failed: User not found', ['email' => $request->email]);
            return back()->withErrors([
                'email' => 'User tidak ditemukan.'
            ])->withInput();
        }

        \Log::info('User found for resend', ['user_id' => $user->id, 'email' => $user->email]);

        if ($user->hasVerifiedEmail()) {
            \Log::info('Resend verification skipped: Email already verified', ['user_id' => $user->id]);
            return back()->with('info', 'Email sudah terverifikasi. Silakan tunggu persetujuan admin.');
        }

        // Kirim ulang email verifikasi
        try {
            $user->sendEmailVerificationNotification();
            \Log::info('Verification email sent successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors([
                'email' => 'Gagal mengirim email. Silakan coba lagi.'
            ]);
        }

        return back()->with('status', 'Email verifikasi telah dikirim ulang. Silakan cek inbox Anda.');
    }
}

