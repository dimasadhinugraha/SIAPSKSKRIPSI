<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'string', 'size:16', 'unique:users'],
            'gender' => ['required', 'in:L,P'],
            'birth_date' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'kk_number' => ['required', 'string', 'size:16'],
            'rt_rw' => ['required', 'string'],
            'ktp_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'kk_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Handle file uploads
        $ktpPath = null;
        $kkPath = null;

        if ($request->hasFile('ktp_photo')) {
            $ktpPath = $request->file('ktp_photo')->store('documents/ktp', 'public');
        }

        if ($request->hasFile('kk_photo')) {
            $kkPath = $request->file('kk_photo')->store('documents/kk', 'public');
        }

        // Check: apakah NIK tersebut sudah terdaftar dalam anggota keluarga di KK yang sama?
        $existsInKK = FamilyMember::where('nik', $request->nik)
            ->whereHas('user', function ($q) use ($request) {
                $q->where('kk_number', $request->kk_number);
            })->exists();

        if (! $existsInKK) {
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['kk_number' => 'NIK tidak ditemukan dalam Kartu Keluarga yang Anda masukkan. Pastikan NIK dan No. KK benar atau tambahkan anggota keluarga terlebih dahulu.']);
        }

        // Validate that the provided RT/RW exists as an account (role rt or rw)
        $rtRwExists = \App\Models\User::whereIn('role', ['rt', 'rw'])
            ->where('rt_rw', $request->rt_rw)
            ->exists();

        if (! $rtRwExists) {
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['rt_rw' => 'RT/RW yang Anda masukkan tidak ditemukan. Pastikan Anda memilih RT/RW yang valid.']);
        }

        // Resolve RT and RW user ids from the provided rt_rw string
        $rtId = null;
        $rwId = null;
        $parts = explode('/', $request->rt_rw);
        $rtPart = isset($parts[0]) ? trim($parts[0]) : null;
        $rwPart = isset($parts[1]) ? trim($parts[1]) : null;

        if ($rtPart) {
            $rtUser = User::where('role', 'rt')->where('rt_rw', 'like', "%{$rtPart}%")->first();
            if ($rtUser) $rtId = $rtUser->id;
        }

        if ($rwPart) {
            $rwUser = User::where('role', 'rw')->where('rt_rw', 'like', "%{$rwPart}%")->first();
            if ($rwUser) $rwId = $rwUser->id;
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => $request->phone,
            'kk_number' => $request->kk_number,
            'rt_rw' => $request->rt_rw,
            'rt_id' => $rtId,
            'rw_id' => $rwId,
            'ktp_photo' => $ktpPath,
            'kk_photo' => $kkPath,
            'role' => 'user',
            'is_verified' => false,
            'is_approved' => false,
        ]);

        // Login the newly registered user so we can show the verification notice
        Auth::login($user);

        // Send email verification link
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            logger()->warning('Failed to send verification email to new user', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        // Redirect to verification notice so the user is prompted to verify their email
        return redirect()->route('verification.notice');
    }
}
