<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            $request->user()->save();
            return response()->json([
                'data' => $request->user(),
            ]);
        }

        return response()->json([
            'data' => $request->user(),
        ]);;
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete directory in storage if exists
        if (Storage::exists($user->pricelist->id)) {
            Storage::deleteDirectory($user->pricelist->id);
        }

        //Delete all tokens
        $user->tokens()->delete();

        $user->pricelist()->delete();
        $user->delete();

        return response()->noContent();
    }
}
