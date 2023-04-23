<?php

use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\ComplainController;
use App\Http\Controllers\Clients\ProfileController;
use Illuminate\Support\Facades\Route;

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

/* Auth::start */
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('loginForm');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('registerForm');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});
/* Auth::end */

Route::group(['middleware' => 'user.auth'], function () {
    /* Information::start */
    Route::group(['prefix' => '/profile'], function () {
        Route::get('/', [ProfileController::class, 'getProfile'])->name('profile.personal-information');
        Route::get('/password', [ProfileController::class, 'getUpdatePage'])->name('profile.change-password');
        Route::post('/update', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
    /* Information::end */

    /* Complain::start*/
    Route::group(['prefix' => '/complain'], function () {
        Route::post('/', [ComplainController::class, 'store'])->name('complain.store');
    });

    /* Complain::end*/
});

Route::get('/complain', [ComplainController::class, 'submitComplainForm'])->name('complain.form');
Route::get('/complain/{id}', [ComplainController::class, 'show'])->name('complain.detail');

Route::get('/', [ComplainController::class, 'index'])->name('home');
Route::get('/history', [ComplainController::class, 'history'])->name('history');
Route::get('/all-district', [ComplainController::class, 'getAllDistrict']);




