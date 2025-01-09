<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdministratorController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //employee
    Route::post('/addemployee', [AdministratorController::class, 'addemployee']);
    Route::get('/viewemployee', [AdministratorController::class, 'viewemployee']);
    Route::get('/updateemployee', [AdministratorController::class, 'updateemployee']);

  

    
    

});

// Uncomment this route if you need to access the authenticated user directly
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




