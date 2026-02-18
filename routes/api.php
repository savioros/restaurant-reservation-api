<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'Hello, word!';
});

Route::post('/auth/register', [UserController::class, 'store']);
