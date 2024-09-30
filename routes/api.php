<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public routes for user registration and login
Route::controller(LoginRegisterController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Protected routes (Require authentication)
Route::middleware('auth:sanctum')->group(function () {

    // User management routes
    Route::get('/user', [LoginRegisterController::class, 'user']);
    Route::post('/logout', [LoginRegisterController::class, 'logout']);

    // Post routes
    Route::get('/posts', [PostController::class, 'index']);  // List posts with pagination
    Route::get('/posts/{id}', [PostController::class, 'show']);  // Get a specific post
    Route::post('/posts', [PostController::class, 'store']);  // Create a post (authenticated users only)
    Route::put('/posts/{id}', [PostController::class, 'update']);  // Update a post (only the post's creator)
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);  // Delete a post (only the post's creator)

    // Comment routes (nested under posts)
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']);  // List comments for a specific post
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);  // Add a comment to a post
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);  // Delete a comment (only the comment's creator)
});
