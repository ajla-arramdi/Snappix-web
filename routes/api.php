<?php

use App\Http\Controllers\Api\AlbumApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\User\AlbumController;
use Tests\Feature\AlbumApiControllerTest;

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

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);

    
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/albums', [AlbumApiController::class, 'index']);
    Route::post('/albums', [AlbumApiController::class, 'store']);
    Route::get('/albums/{id}', [AlbumApiController::class, 'show']);
    Route::delete('/albums/{id}', [AlbumApiController::class, 'destroy']);

    Route::apiResource('posts', PostApiController::class);
});
