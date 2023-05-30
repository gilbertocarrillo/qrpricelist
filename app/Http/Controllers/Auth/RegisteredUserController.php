<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        // Validate data
        $validated = $request->validated();

        // Create new user
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Authenticate new user
        Auth::login($user);

        // Redirect to homepage
        return redirect(RouteServiceProvider::HOME);
    }
}
