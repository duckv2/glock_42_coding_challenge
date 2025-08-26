<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'email' => $request->name,
            'name' => $request->email,
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
}
