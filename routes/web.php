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
        ->name('viewProfile');

    Route::get('edit-profile/{profile}', [ProfileController::class, 'edit'])
        ->name('editProfile');

    Route::post('update-profile', [ProfileController::class, 'update'])
        ->name('updateProfile');
});

require __DIR__.'/auth.php';
