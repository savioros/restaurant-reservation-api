<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Hello, word!';
});

Route::post('/auth/register', [UserController::class, 'store']);
Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/restaurant', [RestaurantController::class, 'store']);
});