<?php

use App\Http\Controllers\GunController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/signup', [UserController::class, 'signUp']);
Route::post('/login', [UserController::class, 'login']);


Route::post('/gun', [GunController::class, 'store'])->middleware('auth:sanctum');
Route::get('/gun', [GunController::class, 'index'])->middleware('auth:sanctum');
Route::get('/gun/{id}', [GunController::class, 'show'])->middleware('auth:sanctum');
Route::put('/gun/{id}', [GunController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/gun/{id}', [GunController::class, 'destroy'])->middleware('auth:sanctum');


Route::post('/inventory', [InventoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('/inventory', [InventoryController::class, 'index'])->middleware('auth:sanctum');
Route::get('/inventory/{id}', [InventoryController::class, 'show'])->middleware('auth:sanctum');
Route::put('/inventory/{id}', [InventoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->middleware('auth:sanctum');
