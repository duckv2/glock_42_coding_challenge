<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController
{
    public function signUp(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        Inventory::create([
            'user_id' => $user->id,
        ]);

        // Not really sure what to call the token,
        // I'll just call it "token".
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->email
            ],
            'token' => $token,
        ]);
    }

    public function login(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('token')->plainTextToken;

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token
            ]);
        }

        return response()->json([
            'code' => 401,
            'message' => "You shall not pass."
        ]);
    }
}
