<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomePageController;



Route::get('/', [HomePageController::class, 'category'])->name('front.category');
Route::get('/products/{id}', [HomePageController::class, 'products'])->name('front.products');
Route::get('/products/detail/{id}', [HomePageController::class, 'productDetail'])->name('product.detail');
Route::post('/products/{id}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::post('/products/{id}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('Dashboard.modules.index');
    })->name('dashboard');

    Route::get('product-fetch-products', [ProductController::class, "fetchProducts"])->name('product.fetch.products');
    // Product resource routes
    Route::resource('product', ProductController::class);
    // web.php
    Route::get('category-fetch-categories', [CategoryController::class, "fetchCategories"])->name('category.fetch.categories');
    Route::resource('category', CategoryController::class);

    // Profile routes
});
Route::middleware('auth')->group(function(){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Auth routes
require __DIR__ . '/auth.php';
