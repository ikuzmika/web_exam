<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\HandlerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;
use App\Models\Competition;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('handler', HandlerController::class);

Route::resource('dog', DogController::class);

Route::resource('pair', PairController::class);

Route::resource('competition', CompetitionController::class);

Route::resource('track', TrackController::class);

Route::resource('organizer', OrganizerController::class);

Route::resource('sponsor', SponsorController::class);

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
    Route::get('/organizer-trashed', [OrganizerController::class, 'trashed'])
        ->name('organizer.trashed');

    Route::get('/sponsor-trashed', [SponsorController::class, 'trashed'])
        ->name('sponsor.trashed');

    Route::get('/handler-trashed', [HandlerController::class, 'trashed'])
        ->name('handler.trashed');

    Route::get('/competition-trashed', [CompetitionController::class, 'trashed'])
        ->name('competition.trashed');

    Route::get('/dog-trashed', [DogController::class, 'trashed'])
        ->name('dog.trashed');

    Route::get('/pair-trashed', [PairController::class, 'trashed'])
        ->name('pair.trashed');

    Route::get('photo-trashed', [PhotoController::class, 'trashed'])
        ->name('photo.trashed');

    Route::get('/result-trashed', [ResultController::class, 'trashed'])
        ->name('result.trashed');

    Route::get('track-trashed', [TrackController::class, 'trashed'])
        ->name('track.trashed');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])
        ->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    Route::patch('/admin/users/{user}/block', [AdminController::class, 'block'])
        ->name('admin.users.block');

    Route::patch('/organizer/{id}/restore', [OrganizerController::class, 'restore'])
        ->name('organizer.restore');

    Route::delete('/organizer/{id}/force-delete', [OrganizerController::class, 'forceDelete'])
        ->name('organizer.forceDelete');

    Route::patch('/sponsor/{id}/restore', [SponsorController::class, 'restore'])
        ->name('sponsor.restore');

    Route::delete('/sponsor/{id}/force-delete', [SponsorController::class, 'forceDelete'])
        ->name('sponsor.forceDelete');

    Route::patch('/handler/{id}/restore', [HandlerController::class, 'restore'])
        ->name('handler.restore');

    Route::delete('/handler/{id}/force-delete', [HandlerController::class, 'forceDelete'])
        ->name('handler.forceDelete');

    Route::patch('/competition/{id}/restore', [CompetitionController::class, 'restore'])
        ->name('competition.restore');

    Route::delete('/competition/{id}/force-delete', [CompetitionController::class, 'forceDelete'])
        ->name('competition.forceDelete');

    Route::patch('/dog/{id}/restore', [DogController::class, 'restore'])
        ->name('dog.restore');

    Route::delete('/dog/{id}/force-delete', [DogController::class, 'forceDelete'])
        ->name('dog.forceDelete');

    Route::patch('/pair/{id}/restore', [PairController::class, 'restore'])
        ->name('pair.restore');

    Route::delete('/pair/{id}/force-delete', [PairController::class, 'forceDelete'])
        ->name('pair.forceDelete');

    Route::get('/photo-pending', [PhotoController::class, 'pending'])
        ->name('photo.pending');

    Route::patch('/photo/{photo}/approve', [PhotoController::class, 'approve'])
        ->name('photo.approve');

    Route::patch('/photo/{photo}/reject', [PhotoController::class, 'reject'])
        ->name('photo.reject');

    Route::patch('photo/{id}/restore', [PhotoController::class, 'restore'])
        ->name('photo.restore');

    Route::delete('photo/{id}/force-delete', [PhotoController::class, 'forceDelete'])
        ->name('photo.forceDelete');

    Route::patch('/result/{id}/restore', [ResultController::class, 'restore'])
        ->name('result.restore');

    Route::delete('/result/{id}/force-delete', [ResultController::class, 'forceDelete'])
        ->name('result.forceDelete');

    Route::patch('track/{id}/restore', [TrackController::class, 'restore'])
        ->name('track.restore');

    Route::delete('track/{id}/force-delete', [TrackController::class, 'forceDelete'])
        ->name('track.forceDelete');
});
