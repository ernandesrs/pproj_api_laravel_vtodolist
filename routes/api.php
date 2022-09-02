<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post("login", [AuthController::class, 'login']);
    Route::post("register", [AuthController::class, 'register']);
    Route::post("verify-email", [AuthController::class, 'verifyEmail']);
    Route::post("forgot-password", [AuthController::class, 'forgotPassword']);
    Route::post("reset-password", [AuthController::class, "resetPassword"]);

    Route::prefix('me')->group(function () {
        Route::get('', [MeController::class, "index"]);
    });
});
