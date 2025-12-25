<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RtRw;
use Illuminate\Http\Request;

class RtRwManagementController extends Controller
{
    public function index()
    {
        // Get all RT and RW users
        $rtUsers = \App\Models\User::where('role', 'rt')
            ->with('biodata')
            ->orderBy('email')
            ->get();
            
        $rwUsers = \App\Models\User::where('role', 'rw')
            ->with('biodata')
            ->orderBy('email')
            ->get();
        
        $stats = [
            'total_rt' => $rtUsers->count(),
            'total_rw' => $rwUsers->count(),
            'total' => $rtUsers->count() + $rwUsers->count(),
        ];
        
        return view('admin.rt-rw.index', compact('rtUsers', 'rwUsers', 'stats'));
    }

    public function create()
    {
        // Find the next available RT and RW numbers
        $existingRtNumbers = \App\Models\User::where('role', 'rt')
            ->get()
            ->map(function($user) {
                preg_match('/rt(\d+)@/', $user->email, $matches);
                return isset($matches[1]) ? (int)ltrim($matches[1], '0') : 0;
            })
            ->filter()
            ->sort()
            ->values();
            
        $existingRwNumbers = \App\Models\User::where('role', 'rw')
            ->get()
            ->map(function($user) {
                preg_match('/rw(\d+)@/', $user->email, $matches);
                return isset($matches[1]) ? (int)ltrim($matches[1], '0') : 0;
            })
            ->filter()
            ->sort()
            ->values();
        
        return view('admin.rt-rw.create', compact('existingRtNumbers', 'existingRwNumbers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:rt,rw',
            'number' => 'required|integer|min:1|max:999',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $role = $request->role;
        $number = str_pad($request->number, 3, '0', STR_PAD_LEFT);
        $email = "{$role}{$number}@siappsk.local";

        // Check if email already exists
        if (\App\Models\User::where('email', $email)->exists()) {
            return back()->withErrors(['number' => ucfirst($role) . " {$request->number} sudah terdaftar."])->withInput();
        }

        $nik = '32' . str_pad($role === 'rt' ? '02' : '01', 2, '0') . str_pad($request->number, 12, '0', STR_PAD_LEFT);

        \App\Models\User::create([
            'name' => $request->name,
            'nik' => $nik,
            'email' => $email,
            'password' => \Hash::make($request->password),
            'role' => $role,
            'is_verified' => true,
            'is_approved' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.rt-rw.index')
            ->with('success', "Akun " . strtoupper($role) . " {$request->number} berhasil ditambahkan.");
    }

    public function edit($id)
    {
        $user = \App\Models\User::whereIn('role', ['rt', 'rw'])->findOrFail($id);
        
        // Extract number from email
        preg_match('/(rt|rw)(\d+)@/', $user->email, $matches);
        $number = isset($matches[2]) ? (int)ltrim($matches[2], '0') : 0;
        
        return view('admin.rt-rw.edit', compact('user', 'number'));
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::whereIn('role', ['rt', 'rw'])->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        
        if ($request->filled('password')) {
            $user->password = \Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.rt-rw.index')
            ->with('success', 'Data ' . strtoupper($user->role) . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::whereIn('role', ['rt', 'rw'])->findOrFail($id);
        
        // Check if any users are using this RT/RW
        $role = $user->role;
        $column = $role . '_id';
        
        $userCount = \App\Models\Biodata::where($column, $user->id)->count();

        if ($userCount > 0) {
            return back()->with('error', "Tidak dapat menghapus akun ini karena masih digunakan oleh {$userCount} warga.");
        }

        $user->delete();

        return redirect()->route('admin.rt-rw.index')
            ->with('success', 'Akun ' . strtoupper($role) . ' berhasil dihapus.');
    }
}
