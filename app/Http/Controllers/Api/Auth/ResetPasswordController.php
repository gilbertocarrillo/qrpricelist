<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        $passwordResetToken = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->where('token', $validated['token'])
            ->first();

        if (!$passwordResetToken) {
            return response()->json(['message' => 'Invalid or expired password reset token.'], 422);
        }

        // Validate token expiration
        $expirationTime = now()->subHour(); // Subtract one hour from the current time

        if ($passwordResetToken->created_at < $expirationTime) {
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();
            return response()->json(['message' => 'The password reset token has expired.'], 422);
        }

        $user = User::where('email', $validated['email'])->first();

        $user->password = Hash::make($validated['password']);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

        return response()->json(['message' => 'Password has been successfully reset.']);
    }
}
