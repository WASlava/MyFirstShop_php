<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InfoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('/infos', [AuthController::class, 'logout']);
    });

    Route::get('/infos', [InfoController::class, 'index']);
    Route::get('/info/{info}', [InfoController::class, 'one']);
    Route::post('/info/{info}', [InfoController::class, 'update']);
//    Route::post('/info/{info}/feedback', [InfoController::class, 'feedback']);
//    Route::post('/feedback/{feedback}', [InfoController::class, 'feedback']);
//        Route::post('/info/{id}/feedback', [InfoController::class, 'store']);
});
