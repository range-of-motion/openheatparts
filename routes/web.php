<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartLinkController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/{brand:slug}/{unit:slug}/{part:slug}/links', [PartLinkController::class, 'store'])
    ->scopeBindings()
    ->middleware('throttle:part-links')
    ->name('part-links.store');

Route::get('/{brand:slug}/{unit:slug}/{part:slug?}', [UnitController::class, 'show'])->name('units.show');
