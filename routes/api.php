<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/signup', [UserController::class, 'signUp']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/gun', function () {});

Route::get('/gun', function () {});

Route::get('/gun/{id}', function () {});

Route::put('/gun/{id}', function () {});

Route::delete('/gun/{id}', function () {});
