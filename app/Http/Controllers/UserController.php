<?php

namespace App\Http\Controllers;

use App\Actions\LoginAction;
use App\Actions\RegisterAction;
use App\Exceptions\CreateUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Exception;

class UserController extends Controller
{
    public function store(RegisterRequest $request, RegisterAction $service)
    {
        try {
            $user = $service->create($request->validated());
            return new UserResource($user);
        } catch (CreateUserException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request, LoginAction $service)
    {
        try{
            $token = $service->login($request->validated());
    
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
