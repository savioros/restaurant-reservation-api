<?php

namespace App\Services;

use App\Exceptions\CreateUserException;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    public function create(array $data): User
    {
        try {
            return DB::transaction(function () use ($data) {
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'phone' => $data['phone'],
                    'role' => $data['role']
                ]);
            });
        } catch (QueryException $e) {
            throw new CreateUserException(
                "Error creating user",
                0,
                $e
            );
        }
    }
}
