<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\User\PostController as UserPostController;
use App\Http\Controllers\User\AlbumController;
use App\Http\Controllers\LikeFotoController;
use App\Http\Controllers\KomentarFotoController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        if (auth()->user()->hasRole('admin')) {
            return view('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('home');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::get('/posts/{id}', [AdminController::class, 'postDetail'])->name('post-detail');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        
        // User management routes
        Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('ban-user');
        Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('unban-user');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');
        Route::post('/users/{user}/make-admin', [AdminController::class, 'makeAdmin'])->name('make-admin');
        Route::post('/users/{user}/remove-admin', [AdminController::class, 'removeAdmin'])->name('remove-admin');
        
        // Post management routes
        Route::post('/posts/{post}/ban', [AdminController::class, 'banPost'])->name('ban-post');
        Route::post('/posts/{post}/unban', [AdminController::class, 'unbanPost'])->name('unban-post');
        Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('delete-post');
        
        // Comment management routes
        Route::post('/comments/{comment}/ban', [AdminController::class, 'banComment'])->name('ban-comment');
        Route::delete('/comments/{comment}', [AdminController::class, 'deleteComment'])->name('delete-comment');
    });

    // User routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [App\Http\Controllers\User\UserController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [App\Http\Controllers\User\UserController::class, 'updateProfile'])->name('profile.update');
        
        // Album routes
        Route::resource('albums', App\Http\Controllers\User\AlbumController::class);
        
        // Post routes
        Route::resource('posts', App\Http\Controllers\User\PostController::class);
    });

    // Shared routes
    Route::get('/explore', function () {
        return view('explore');
    })->name('explore');
});

Route::middleware(['auth', 'check.banned'])->group(function () {
    // ... existing routes ...
    
    // Like foto routes
    Route::post('/post-fotos/{postFoto}/like', [LikeFotoController::class, 'toggle'])->name('post-fotos.like');
    
    // Komentar foto routes
    Route::post('/post-fotos/{postFoto}/komentar', [KomentarFotoController::class, 'store'])->name('komentar-fotos.store');
    Route::delete('/komentar-fotos/{komentarFoto}', [KomentarFotoController::class, 'destroy'])->name('komentar-fotos.destroy');
    
    // Report routes
    Route::post('/post-fotos/{postFoto}/report', [ReportController::class, 'reportPost'])->name('posts.report');
    Route::post('/komentar-fotos/{komentarFoto}/report', [ReportController::class, 'reportComment'])->name('comments.report');
    Route::post('/users/{user}/report', [ReportController::class, 'reportUser'])->name('users.report');
});















