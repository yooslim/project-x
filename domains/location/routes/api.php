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

Route::prefix('api')
    ->middleware('api')
    ->group(function () {

});
