<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'signUp']);

Route::post('/login', function () {});

Route::post('/gun', function () {});

Route::get('/gun', function () {});

Route::get('/gun/{id}', function () {});

Route::put('/gun/{id}', function () {});

Route::delete('/gun/{id}', function () {});
