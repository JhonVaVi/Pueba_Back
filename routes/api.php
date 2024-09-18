<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); 

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::Resource('productos', ProductoController::class);
    Route::Resource('users', UserController::class); 
    Route::get('/welcome/{id}', [AuthController::class, 'welcome']);
    Route::post('/productos/add/{id}', [ProductoController::class, 'addStock']);
    Route::post('/productos/remove/{id}', [ProductoController::class, 'removeStock']);
    
});


