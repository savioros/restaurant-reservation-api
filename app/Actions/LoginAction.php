<?php

namespace App\Actions;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function handle(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            throw new InvalidCredentialsException('Invalid Credentials');

        return $user->createToken('token')->plainTextToken;
    }
}
