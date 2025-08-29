<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\SignupData;
use App\Events\UserSignup;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthService {
    public function signUp(SignupData $signupData) {
        $user = User::create([
            'email' => $signupData->email,
            'name' => $signupData->name,
            'password' => bcrypt($signupData->password),
        ]);

        UserSignup::dispatch($user);

        $token = $user->createToken('token')->plainTextToken;

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ],
            'token' => $token,
        ];
    }

    // Checks if user exists and if the password is valid
    public function credentialsValid(string $email, string $password): bool {
        $user = User::where('email', $email)->first();

        return $user && Hash::check($password, $user->password);
    }

    public function login(string $email) {
        $user = User::where('email', $email)->first();
        $token = $user->createToken('token')->plainTextToken;

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token
        ];
    }
}
