<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\HandlerController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('handler', HandlerController::class);

Route::resource('dog', DogController::class);

Route::resource('pair', PairController::class);

Route::resource('competition', CompetitionController::class);

Route::resource('track', TrackController::class);

Route::resource('organizer', OrganizerController::class);

Route::resource('result', ResultController::class);

Route::resource('photo', PhotoController::class);

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('auth.register');
    Route::get('/login', 'showLogin')->name('auth.login');
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/rankings', [RankingController::class, 'rank'])
    ->name('rankings.index');

Route::get('/rankings/filter', [RankingController::class, 'filter'])
    ->name('rankings.filter');

Route::middleware('auth')->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])
        ->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    Route::patch('/admin/users/{user}/block', [AdminController::class, 'block'])
        ->name('admin.users.block');
});
