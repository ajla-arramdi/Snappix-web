<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\CommentController as UserCommentController;
use App\Http\Controllers\User\ExploreController as UserExploreController;
use App\Http\Controllers\User\LikeController as UserLikeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register']);
});

Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('home');

    // Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('user-detail');
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::get('/posts/{id}', [AdminController::class, 'postDetail'])->name('post-detail');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        
        // User management routes
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('ban-user');
        Route::post('/users/{user}/unban', [UserController::class, 'unban'])->name('unban-user');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('delete-user');
        Route::post('/users/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('make-admin');
        Route::post('/users/{user}/remove-admin', [UserController::class, 'removeAdmin'])->name('remove-admin');
        
        // Post management
        Route::post('/posts/{post}/ban', [AdminController::class, 'banPost'])->name('ban-post');
        Route::post('/posts/{post}/unban', [AdminController::class, 'unbanPost'])->name('unban-post');
        Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('delete-post');
        
        // Comment management
        Route::post('/comments/{comment}/ban', [AdminController::class, 'banComment'])->name('ban-comment');
        Route::delete('/comments/{comment}', [AdminController::class, 'deleteComment'])->name('delete-comment');
        
        // Report management
        Route::post('/reports/post/{id}/{action}', [AdminController::class, 'reviewPostReport'])->name('review-post-report');
        Route::post('/reports/comment/{id}/{action}', [AdminController::class, 'reviewCommentReport'])->name('review-comment-report');
        Route::post('/reports/user/{id}/{action}', [AdminController::class, 'reviewUserReport'])->name('review-user-report');
    });
});

// User routes with banned check
Route::middleware(['auth', 'check.banned'])->group(function () {
    // User dashboard
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    
    // User management routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\User\UserController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [\App\Http\Controllers\User\UserController::class, 'updateProfile'])->name('profile.update');
        
        // Album routes
        Route::resource('albums', \App\Http\Controllers\User\AlbumController::class);
        
        // Post routes
        Route::resource('posts', \App\Http\Controllers\User\PostController::class);
    });
    
    // Search routes
    Route::get('/search/users', [SearchController::class, 'users'])->name('search.users');
    
    // Explore page
    Route::get('/explore', [UserExploreController::class, 'index'])->name('explore');
    
    // Post detail
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    
    // Profile public - bisa lihat profile user lain
    Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user.show');
    
    // Like and Comment routes
    Route::post('/posts/{post}/like', [UserLikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/comments', [UserCommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [UserCommentController::class, 'destroy'])->name('comments.destroy');
});

// Report routes
Route::middleware('auth')->group(function () {
    Route::post('/report/post/{id}', [ReportController::class, 'reportPost'])->name('report.post');
    Route::post('/report/user/{id}', [ReportController::class, 'reportUser'])->name('report.user');
    Route::post('/report/comment/{id}', [ReportController::class, 'reportComment'])->name('report.comment');
});

// Admin Report Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/reports/post/{id}/{action}', [App\Http\Controllers\Admin\AdminController::class, 'reviewPostReport']);
    Route::post('/reports/comment/{id}/{action}', [App\Http\Controllers\Admin\AdminController::class, 'reviewCommentReport']);
    Route::post('/reports/user/{id}/{action}', [App\Http\Controllers\Admin\AdminController::class, 'reviewUserReport']);
});







