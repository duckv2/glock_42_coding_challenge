<?php

namespace App\Http\Controllers;

use App\Services\UserAuthService;
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

        if ($request->password != $request->password_confirmation) {
            return response()->json([
                'code' => 400,
                'message' => 'Password does not match the password confirmation.'
            ]);
        }

        $authService = new UserAuthService();
        $authResponse = $authService->signUp([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($authResponse);
    }

    public function login(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $authService = new UserAuthService();

        if ($authService->credentialsValid($request->email, $request->password)) {
            $authResponse = $authService->login($request->email);
            return response()->json($authResponse);
        }

        return response()->json([
            'code' => 401,
            'message' => "You shall not pass."
        ]);
    }
}
