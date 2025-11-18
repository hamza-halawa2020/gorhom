<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViewController;
use App\Http\Controllers\Email\EmailContactFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// contact
Route::post('/contact', [EmailContactFormController::class, 'send']);

// login
Route::post('login', [LoginController::class, 'login']);

// logout
Route::post('logout', [LoginController::class, 'logout']);

// categories
Route::apiResource('categories', CategoryController::class);


// users
Route::apiResource('users', UserController::class);


// products
Route::apiResource('products', ProductController::class);


// views
Route::apiResource('views', ViewController::class)->only(['index', 'show', 'destroy']);
