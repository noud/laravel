<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('v1/adres', App\Http\Controllers\API\AdresAPIController::class);

Route::resource('v1/afbeeldings', App\Http\Controllers\API\AfbeeldingAPIController::class);

Route::resource('v1/locaties', App\Http\Controllers\API\LocatieAPIController::class);

Route::resource('v1/politiebureaus', App\Http\Controllers\API\PolitiebureauAPIController::class);

Route::resource('v1/politiebureaus_locaties', App\Http\Controllers\API\PolitiebureausLocatieAPIController::class);

Route::resource('books', App\Http\Controllers\API\BookAPIController::class);
Route::resource('reviews', App\Http\Controllers\API\ReviewAPIController::class);
