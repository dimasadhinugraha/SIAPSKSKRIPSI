<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'ktp_photo' => $ktpPath,
            'kk_photo' => $kkPath,
            'role' => 'user',
            'is_verified' => false,
        ]);

        return redirect()->route('verification.notice')
            ->with('success', 'Pendaftaran berhasil! Akun Anda menunggu verifikasi dari admin.');
    }
}
