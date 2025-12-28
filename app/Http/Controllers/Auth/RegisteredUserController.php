<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Biodata;
use App\Models\FamilyMember;
use App\Models\RtRw;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        // Get RT and RW users
        $rtUsers = User::where('role', 'rt')
            ->orderBy('email')
            ->get()
            ->map(function($user) {
                preg_match('/rt(\d+)@/', $user->email, $matches);
                $rtNumber = isset($matches[1]) ? (int)ltrim($matches[1], '0') : 0;
                return [
                    'number' => $rtNumber,
                    'name' => $user->name,
                ];
            })
            ->sortBy('number')
            ->values();

        $rwUsers = User::where('role', 'rw')
            ->orderBy('email')
            ->get()
            ->map(function($user) {
                preg_match('/rw(\d+)@/', $user->email, $matches);
                $rwNumber = isset($matches[1]) ? (int)ltrim($matches[1], '0') : 0;
                return [
                    'number' => $rwNumber,
                    'name' => $user->name,
                ];
            })
            ->sortBy('number')
            ->values();
        
        return view('auth.register', compact('rtUsers', 'rwUsers'));
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
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik', 'regex:/^[0-9]{16}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'in:L,P'],
            'agama' => ['required', 'string', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'birth_date' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:15'],
            'kk_number' => ['required', 'string', 'size:16'],
            'rt' => ['required', 'integer', 'min:1'],
            'rw' => ['required', 'integer', 'min:1'],
            'ktp_photo' => ['required', 'image', 'mimes:jpeg,png,jpg'],
            'kk_photo' => ['required', 'image', 'mimes:jpeg,png,jpg'],
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

        // Optional: Check if NIK exists in family members (commented out to allow direct registration)
        // $existsInKK = FamilyMember::where('nik', $request->nik)
        //     ->whereHas('user', function ($q) use ($request) {
        //         $q->where('kk_number', $request->kk_number);
        //     })->exists();

        // if (! $existsInKK) {
        //     return back()->withInput($request->except(['password', 'password_confirmation']))
        //         ->withErrors(['kk_number' => 'NIK tidak ditemukan dalam Kartu Keluarga yang Anda masukkan. Pastikan NIK dan No. KK benar atau tambahkan anggota keluarga terlebih dahulu.']);
        // }

        // Cari user RT dan RW berdasarkan nomor
        $rtUser = User::where('role', 'rt')
            ->where('email', 'rt' . str_pad($request->rt, 2, '0', STR_PAD_LEFT) . '@ciasmara.desa.id')
            ->first();
            
        $rwUser = User::where('role', 'rw')
            ->where('email', 'rw' . str_pad($request->rw, 1, '0', STR_PAD_LEFT) . '@ciasmara.desa.id')
            ->first();

        if (!$rtUser) {
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['rt' => 'RT yang Anda pilih tidak tersedia.']);
        }

        if (!$rwUser) {
            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['rw' => 'RW yang Anda pilih tidak tersedia.']);
        }

        // Bentuk string rt_rw seperti "001/001"
        $rtRwString = sprintf('%03d/%03d', $request->rt, $request->rw);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => $request->phone,
            'kk_number' => $request->kk_number,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'ktp_photo' => $ktpPath,
            'kk_photo' => $kkPath,
            'role' => 'user',
            'email_verified_at' => null,
            'is_approved' => false,
        ]);

        // Create biodata with rt_id and rw_id
        $user->biodata()->create([
            'gender' => $request->gender,
            'agama' => $request->agama,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => $request->phone,
            'kk_number' => $request->kk_number,
            'rt_rw' => $rtRwString,
            'rt_id' => $rtUser->id,
            'rw_id' => $rwUser->id,
            'ktp_photo' => $ktpPath,
            'kk_photo' => $kkPath,
        ]);

        // Log the user in so they can see the verification notice page
        try {
            Auth::login($user);
        } catch (\Throwable $e) {
            Log::warning('Failed to auto-login new user after registration', ['error' => $e->getMessage()]);
        }

        event(new Registered($user));

        // Send email verification notification
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            Log::warning('Failed to send verification email to new user', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        // Redirect to verification notice (user is logged in so notice can be shown)
        return redirect()->route('verification.notice');
    }
}
