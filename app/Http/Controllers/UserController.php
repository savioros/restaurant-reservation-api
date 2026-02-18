<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\LoginUserService;
use App\Services\RegisterUserService;
use Exception;

class UserController extends Controller
{
    public function store(RegisterRequest $request, RegisterUserService $service)
    {
        $user = $service->create($request->validated());
        return new UserResource($user);
    }

    public function login(LoginRequest $request, LoginUserService $service)
    {
        try{
            $token = $service->login($request->validated());
    
            return response()->json([
                'token' => $token,
                'type' => 'bearer'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
