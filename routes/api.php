<?php

use App\Http\Controllers\Api\AlbumApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\SocialApiController;
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
    Route::get('/albums/{id}/posts', [AlbumApiController::class, 'getPostsByAlbum']);

    // User API routes
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserApiController::class, 'profile']);
        Route::put('/profile', [UserApiController::class, 'updateProfile']);
        Route::put('/change-password', [UserApiController::class, 'changePassword']);
        Route::get('/my-posts', [UserApiController::class, 'myPosts']);
        Route::get('/my-albums', [UserApiController::class, 'myAlbums']);
        Route::get('/liked-posts', [UserApiController::class, 'likedPosts']);
        Route::get('/my-comments', [UserApiController::class, 'myComments']);
        Route::get('/search', [UserApiController::class, 'searchUsers']);
        Route::get('/username/{username}', [UserApiController::class, 'getUserByUsername']);
        Route::get('/stats', [UserApiController::class, 'getStats']);
        Route::delete('/delete-account', [UserApiController::class, 'deleteAccount']);
        Route::get('/{userId}/albums', [AlbumApiController::class, 'getAlbumsByUserId']);
    });

    // Social API routes
    Route::prefix('social')->group(function () {
        Route::post('/posts/{postId}/like', [SocialApiController::class, 'likePost']);
        Route::delete('/posts/{postId}/unlike', [SocialApiController::class, 'unlikePost']);
        Route::post('/posts/{postId}/comments', [SocialApiController::class, 'addComment']);
        Route::put('/comments/{commentId}', [SocialApiController::class, 'updateComment']);
        Route::delete('/comments/{commentId}', [SocialApiController::class, 'deleteComment']);
        Route::post('/posts/{postId}/report', [SocialApiController::class, 'reportPost']);
        Route::post('/comments/{commentId}/report', [SocialApiController::class, 'reportComment']);
        Route::post('/users/{userId}/report', [SocialApiController::class, 'reportUser']);
        Route::get('/posts/{postId}/comments', [SocialApiController::class, 'getPostComments']);
        Route::get('/posts/{postId}/likes', [SocialApiController::class, 'getPostLikes']);
        Route::get('/posts/{postId}/like-status', [SocialApiController::class, 'checkLikeStatus']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/albums', [AlbumApiController::class, 'index']);
    Route::post('/albums', [AlbumApiController::class, 'store']);
    Route::get('/albums/{id}', [AlbumApiController::class, 'show']);
    Route::delete('/albums/{id}', [AlbumApiController::class, 'destroy']);

    Route::apiResource('posts', PostApiController::class);
});


