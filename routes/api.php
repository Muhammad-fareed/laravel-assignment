<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;

// Authenticated routes for accessing user information and logging out
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

// Auth Routes - Registration and Login are public
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']); // Public
    Route::post('/register', [AuthController::class, 'register']); // Public
});

// Category and Product Listing Routes (no authentication required)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
