<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\PricelistController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::apiResource('pricelists', PricelistController::class)->except(['index', 'show']);
    Route::apiResource('pricelists.categories', CategoryController::class)->shallow()->except(['index',  'show']);
    Route::apiResource('pricelists.products', ProductController::class)->shallow()->except(['index',  'show']);

    Route::put('/password', [PasswordController::class, 'update']);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

Route::get('pricelists/{pricelist}', [PricelistController::class, 'show']);

Route::get('pricelists/{pricelist}/categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('pricelists/{pricelist}/products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'store']);
