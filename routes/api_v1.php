<?php

use App\Http\Controllers\Api\V1\AuthController;
//use App\Http\Controllers\Api\V1\ProjectController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\API\V1'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/projects', ProjectController::class)->only([
            'index', 'store', 'show', 'update'
        ]);
        Route::apiResource('/tasks', TaskController::class)->only([
            'index', 'store', 'show', 'update'
        ]);
    });

//    Route::get('projects', [ProjectController::class, 'index'])->middleware('auth:sanctum');
//    Route::post('projects', [ProjectController::class, 'store'])->middleware('auth:sanctum');
});
