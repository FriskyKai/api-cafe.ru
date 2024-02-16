<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkShiftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'create']);
    Route::post('/work-shift', [WorkShiftController::class, 'create']);
    Route::get('/work-shift/{id}/open', [WorkShiftController::class, 'open']);
    Route::get('/work-shift/{id}/close', [WorkShiftController::class, 'close']);
    Route::post('/work-shift/{id}/user', [WorkShiftController::class, 'userAdd']);
    Route::get('/work-shift/{id}/order', [WorkShiftController::class, 'orderShow']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('/order', [OrderController::class, 'create']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::get('/work-shift/{id}/orders', [WorkShiftController::class, 'index']);
    Route::patch('/order/{id}/change-status', [OrderController::class, 'statusChange']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/order/taken', [OrderController::class, 'index']);
    Route::patch('/order/{id}/change-status', [OrderController::class, 'statusChange']);
});














