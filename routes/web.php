<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)->name('main');
Route::get('/dados-estatisticos', StatisticsController::class)->name('stats');
