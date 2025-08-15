<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportCommentController as AdminReportCommentController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\CommentController as UserCommentController;
use App\Http\Controllers\User\ExploreController as UserExploreController;
use App\Http\Controllers\User\LikeController as UserLikeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\ReportCommentController as UserReportCommentController;

use App\Http\Controllers\User\ReportController as UserReportController;




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

// Redirect home based on role
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('home');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('user-detail');
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::get('/posts/{id}', [AdminController::class, 'postDetail'])->name('post-detail');

    // User management
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
    Route::post('/comments/{comment}/unban', [AdminController::class, 'unbanComment'])->name('unban-comment');
    Route::delete('/comments/{comment}', [AdminController::class, 'deleteComment'])->name('delete-comment');

    // Reports review by admin
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/post/{id}/{action}', [AdminController::class, 'reviewPostReport'])->name('review-post-report');
    Route::post('/reports/comment/{id}/{action}', [AdminController::class, 'reviewCommentReport'])->name('review-comment-report');
    Route::post('/reports/user/{id}/{action}', [AdminController::class, 'reviewUserReport'])->name('review-user-report');

    // Comment Report Management
    Route::get('/report-comments', [AdminReportCommentController::class, 'index'])->name('report-comments.index');
    Route::post('/report-comments/{report}/{action}', [AdminReportCommentController::class, 'review'])->name('report-comments.review');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check.banned'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\User\UserController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [\App\Http\Controllers\User\UserController::class, 'updateProfile'])->name('profile.update');

        // Album & Posts
        Route::resource('albums', \App\Http\Controllers\User\AlbumController::class);
        Route::resource('posts', \App\Http\Controllers\User\PostController::class);
    });

    // Explore & Search
    Route::get('/explore', [UserExploreController::class, 'index'])->name('explore');
    Route::get('/search/users', [SearchController::class, 'users'])->name('search.users');

    // Post detail & interactions
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/like', [UserLikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/comments', [UserCommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [UserCommentController::class, 'destroy'])->name('comments.destroy');

    // Public profile
    Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user.show');

    // User report & comment report
    Route::post('/report/post/{postFoto}', [UserReportController::class, 'reportPost'])->name('report.post');
    Route::post('/report/user/{user}', [UserReportController::class, 'reportUser'])->name('report.user');
    Route::post('/comments/{comment}/report', [UserReportCommentController::class, 'store'])->name('comments.report');
});
