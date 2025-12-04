<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    public function notice()
    {
        // Jika tidak ada user terautentikasi, arahkan ke login
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Admin tidak perlu melihat halaman verifikasi
        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verification-notice');
    }

    /**
     * Show a simple form where user can request a verification email.
     */
    public function showVerifyEmailForm()
    {
        return view('auth.verify-email');
    }

    /**
     * Send verification email to the provided address (if it exists).
     */
    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'Alamat email tidak ditemukan di sistem.');
        }

        if ($user->email_verified_at) {
            return back()->with('success', 'Alamat email ini sudah terverifikasi.');
        }

        // Send the verification notification using the built-in method.
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi telah dikirim ke email tersebut. Silakan cek inbox (atau folder spam).');
    }
}
