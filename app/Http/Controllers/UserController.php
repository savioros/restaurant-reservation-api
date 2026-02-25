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
        try {
            $user = $registerAction->handle($request->validated());
            return new UserResource($user);
        } catch (CreateUserException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request, LoginAction $loginAction)
    {
        try{
            $token = $loginAction->handle($request->validated());
    
            return response()->json([
                'token' => $token,
                'type' => 'bearer'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
