<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/{brand:slug}/{unit:slug}/{part:slug?}', [UnitController::class, 'show'])->name('units.show');
