<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\FrontEndController;
use App\Http\Controllers\Dashboard\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [FrontEndController::class, 'index'])->name('home');
