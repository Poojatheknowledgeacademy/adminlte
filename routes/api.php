<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\StoreDataController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [ApiAuthController::class, 'login']);
});
Route::middleware('auth:api')->group(function () {
    Route::get('authenticated-user-details', [ApiAuthController::class, 'authenticatedUserDetails']);
    Route::apiResource('users', UserController::class);
    Route::get('/get-categories-topics-courses',             [GetDataController::class, 'data']);
    Route::get('storedata', [StoreDataController::class, 'storedata']);
});
