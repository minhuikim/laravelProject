<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('articles', ArticleController::class);

Route::resource('comments', CommentController::class);

Route::get('profile/{user:username}', [ProfileController::class, 'show'])
->name('profile')
->where('user', '^[A-Za-z0-9-]+$');

Route::post('follow/{user}', [FollowController::class, 'store'])->name('follow');
Route::delete('follow/{user}', [FollowController::class, 'destroy'])->name('unfollow');