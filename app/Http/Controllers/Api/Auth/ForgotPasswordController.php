<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class ForgotPasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        //Create token
        $token = $this->createToken();

        //Save token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send email
        Mail::to($request->email)->send(new PasswordResetMail($token));

        return response()->json(['message' => 'Token sent to your email']);
    }

    public function createToken()
    {
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        return $token;
    }
}
