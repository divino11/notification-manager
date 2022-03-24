<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NotificationController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('client', ClientController::class)->only(['store', 'update', 'destroy']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('client', ClientController::class)->only(['index', 'show']);
    Route::apiResource('notification', NotificationController::class)->only(['index', 'store', 'show']);
});
