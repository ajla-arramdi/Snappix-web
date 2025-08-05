<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;

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
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');
        
        Route::get('/profile', function () {
            return view('user.profile');
        })->name('profile');
        
        Route::get('/photos', function () {
            return view('user.photos.index');
        })->name('photos');
        
        Route::get('/albums', function () {
            return view('user.albums.index');
        })->name('albums');
    });

    // Shared routes
    Route::get('/explore', function () {
        return view('explore');
    })->name('explore');
});






