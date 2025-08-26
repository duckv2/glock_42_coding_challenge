<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class UserController
{
    public function signUp(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $user = User::create([
            'email' => $request->name,
            'name' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->create_token()->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->email
            ],
            'token' => $token,
        ]);
    }
}
