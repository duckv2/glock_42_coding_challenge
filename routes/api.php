<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\GunController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/signup', [UserController::class, 'signUp']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/gun', [GunController::class, 'store'])->middleware('auth:sanctum');

Route::get('/gun', [GunController::class, 'index'])->middleware('auth:sanctum');

Route::get('/gun/{id}', [GunController::class, 'show'])->middleware('auth:sanctum');

Route::put('/gun/{id}', [GunController::class, 'update'])->middleware('auth:sanctum');

Route::delete('/gun/{id}', function () {});
