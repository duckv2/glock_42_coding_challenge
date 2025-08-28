<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthService {
    public function signUp($userData) {
        $user = User::create([
            'email' => $userData['email'],
            'name' => $userData['name'],
            'password' => bcrypt($userData['password']),
        ]);

        Inventory::create([
            'user_id' => $user->id,
            'name' => 'default'
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->email
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
