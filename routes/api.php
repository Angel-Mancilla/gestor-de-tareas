<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('tasks',TaskController::class)->middleware('auth:sanctum');
Route::post('login',[AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('register',[AuthController::class, 'create'])->name('auth.register');
// Route::apiResource('tasks',[TaskController::class,'create']);
