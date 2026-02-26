<?php

use App\Http\Controllers\BusinessHourController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Hello, word!';
});

Route::post('/auth/register', [UserController::class, 'store']);
Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::post('/restaurants/{restaurant}/tables', [TableController::class, 'store']);
    Route::post('/restaurants/{restaurant}/business-hours', [BusinessHourController::class, 'store']);
});

Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
Route::get('/restaurants/{restaurant}/tables', [TableController::class, 'index']);
Route::post('/restaurants/{restaurant}/reservations', [ReservationController::class, 'store']);
Route::get('/restaurants/{restaurant}/reservations/{reservation}', [ReservationController::class, 'show']);
Route::get('/reservations/confirm/{token}', [ReservationController::class, 'confirm']);
