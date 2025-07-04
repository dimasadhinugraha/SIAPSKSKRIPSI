<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'gender' => ['required', 'in:L,P'],
            'birth_date' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:15'],
            'kk_number' => ['required', 'string', 'size:16'],
            'rt_rw' => ['required', 'string', 'max:20'],
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

        event(new Registered($user));

        // Don't auto-login, redirect to verification notice
        return redirect()->route('verification.notice');
    }
}
