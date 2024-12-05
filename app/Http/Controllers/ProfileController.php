<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        // Update basic profile fields
        $user->fill($request->except('profile_photo', 'remove_photo'));

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::delete('public/images/profiles/' . $user->profile_photo);
            }

            // Simpan foto baru
            $fileName = time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $request->file('profile_photo')->storeAs('public/images/profiles', $fileName);
            $user->profile_photo = $fileName;
        }

        // If removing profile photo
        if ($request->input('remove_photo') === '1') {
            if ($user->profile_photo) {
                Storage::delete('public/profile_photo/' . $user->profile_photo);
            }
            $user->profile_photo = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
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
