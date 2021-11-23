<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
});

require __DIR__.'/auth.php';
