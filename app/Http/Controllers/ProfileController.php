<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('biodata');
        
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload profile photo
     */
    public function uploadPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user = $request->user();
        
        // Delete old photo if exists
        if ($user->biodata && $user->biodata->profile_photo) {
            \Storage::disk('public')->delete($user->biodata->profile_photo);
        }

        // Upload new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        
        // Update biodata
        if ($user->biodata) {
            $user->biodata->update(['profile_photo' => $path]);
        } else {
            $user->biodata()->create(['profile_photo' => $path]);
        }

        return Redirect::route('profile.edit')->with('status', 'Photo profile berhasil diupload!');
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->biodata && $user->biodata->profile_photo) {
            \Storage::disk('public')->delete($user->biodata->profile_photo);
            $user->biodata->update(['profile_photo' => null]);
        }

        return Redirect::route('profile.edit')->with('status', 'Photo profile berhasil dihapus!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
