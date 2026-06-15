<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\HandlerController;
use App\Http\Controllers\PairController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('handler', HandlerController::class);

Route::resource('dog', DogController::class);

Route::resource('pair', PairController::class);

Route::resource('competition', CompetitionController::class);

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('auth.register');
    Route::get('/login', 'showLogin')->name('auth.login');
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
