<?php

namespace App\Http\Controllers;

use App\Data\LoginData;
use App\Data\SignupData;
use App\Services\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController
{
    public function signUp(SignupData $signupData): JsonResponse {
        if ($signupData->password != $signupData->password_confirmation) {
            return response()->json([
                'code' => 400,
                'message' => 'Password does not match the password confirmation.'
            ]);
        }

        $authService = new UserAuthService();
        $authResponse = $authService->signUp($signupData);

        return response()->json($authResponse);
    }

    public function login(LoginData $loginData): JsonResponse {
        $authService = new UserAuthService();

        if ($authService->credentialsValid($loginData->email, $loginData->password)) {
            $authResponse = $authService->login($loginData->email);
            return response()->json($authResponse);
        }

        return response()->json([
            'code' => 401,
            'message' => "You shall not pass."
        ]);
    }
}
