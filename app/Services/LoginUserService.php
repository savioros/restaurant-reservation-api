<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    public function login(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            throw new Exception('Invalid Credentials');

        return $user->createToken('token')->plainTextToken;
    }
}
