<?php

use App\Http\Controllers\HandlerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
