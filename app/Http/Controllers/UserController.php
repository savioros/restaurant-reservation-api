<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\RegisterUserService;

class UserController extends Controller
{
    public function store(RegisterRequest $request, RegisterUserService $service)
    {
        $user = $service->create($request->validated());
        return new UserResource($user);
    }
}
