<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::group(['middleware' => ['auth', 'verified']], function() {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('profile/{profile}', [ProfileController::class, 'show'])
        ->name('view.profile');

    Route::put('update-profile/{profile}', [ProfileController::class, 'update'])
        ->name('update.profile');

    Route::post('upload/{profile}', [ProfileController::class, 'uploadPhoto'])
        ->name('upload.image');

    Route::get('posts', [PostController::class, 'index'])
        ->name('post.index');

    Route::get('post/{post}', [PostController::class, 'show'])
        ->name('post.view');

    Route::post('store', [PostController::class, 'store'])
        ->name('post.store');

    Route::post('storeComment/{post}', [PostController::class, 'storeComment'])
        ->name('post.comment.store');

    Route::post('visibility/{post}/{visibility}', [PostController::class, 'updateVisibility'])
        ->name('post.visibility');
});

require __DIR__.'/auth.php';
