<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViewController;
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

// reviews
Route::get('reviews/accepted', [ReviewController::class, 'getAcceptedReviews']);
Route::apiResource('reviews', ReviewController::class);

// views
Route::apiResource('views', ViewController::class)->only(['index', 'show', 'destroy']);

// coupons
Route::apiResource('coupons', CouponController::class);
Route::post('validate-coupon', [CouponController::class, 'validateCoupon']);
Route::get('check-first-order', [CouponController::class, 'checkFirstOrder']);
Route::get('automatic/first-order', [CouponController::class, 'getAutomaticCoupon']);

// clients
Route::apiResource('clients', ClientController::class);
Route::get('clients/phone/{phone}', [ClientController::class, 'getByPhone']);
Route::get('clients/{client}/stats', [ClientController::class, 'stats']);

// orders
Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('orders/{order}', [OrderController::class, 'show']);
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus']);
Route::get('orders/client/{phone}', [OrderController::class, 'getClientOrders']);
Route::get('orders-export', [OrderController::class, 'exportPendingOrders']);
