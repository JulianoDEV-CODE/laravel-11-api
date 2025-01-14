<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(uri: '/register',action: [AuthController::class, 'register']);
Route::post(uri: '/login',action: [AuthController::class, 'login']);


// get all posts no need to authenticate
