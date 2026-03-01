<?php

namespace App\Http\Controllers;

use App\Actions\LoginAction;
use App\Actions\RegisterAction;
use App\Exceptions\CreateUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Exception;

class UserController extends Controller
{
    public function store(StoreUserRequest $request, RegisterAction $registerAction)
    {
        $user = $registerAction->handle($request->validated());
        return new UserResource($user);
    }

    public function login(LoginRequest $request, LoginAction $loginAction)
    {
        $token = $loginAction->handle($request->validated());

        return response()->json([
            'token' => $token,
            'type' => 'bearer'
        ]);
    }
}
