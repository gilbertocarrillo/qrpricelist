<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . auth()->user()->id],
        ]);

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('deleteProfile', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete directory in storage if exists
        if (Storage::exists($user->pricelist->id)) {
            Storage::deleteDirectory($user->pricelist->id);
        }

        Auth::logout();

        $user->pricelist()->delete();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login')->with('status', 'account-deleted');
    }
}
