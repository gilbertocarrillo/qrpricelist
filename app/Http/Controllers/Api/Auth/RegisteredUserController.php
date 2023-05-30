<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class RegisteredUserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token =  $user->createToken('apiToken')->plainTextToken;
        $response = [
            'token' => $token,
            'user' => $user,
        ];

        return response($response, 201);
    }
}
