<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Location API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your domain location.
|
*/

Route::prefix('api/cities')
    ->middleware('api')
    ->group(function () {
        Route::get('/', Domains\Location\Http\Controllers\CityIndexController::class)->name('cities.index');
        Route::post('/', Domains\Location\Http\Controllers\CityStoreController::class)->name('cities.store');
        Route::get('{city}', Domains\Location\Http\Controllers\CityShowController::class)->name('cities.show');
});
