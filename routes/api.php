<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

// countries
Route::apiResource('countries', CountryController::class);

// cities
Route::apiResource('cities', CityController::class);

// shipments
Route::apiResource('shipments', ShipmentController::class);

// views
Route::apiResource('views', ViewController::class)->only(['index', 'show', 'destroy']);
