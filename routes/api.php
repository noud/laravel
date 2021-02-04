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

Route::resource('v1/books', App\Http\Controllers\API\BookAPIController::class);
Route::resource('v1/reviews', App\Http\Controllers\API\ReviewAPIController::class);


Route::resource('adres', App\Http\Controllers\API\AdresAPIController::class);

Route::resource('afbeeldings', App\Http\Controllers\API\AfbeeldingAPIController::class);

Route::resource('locaties', App\Http\Controllers\API\LocatieAPIController::class);

Route::resource('politiebureaus', App\Http\Controllers\API\PolitiebureauAPIController::class);

Route::resource('politiebureaus_locaties', App\Http\Controllers\API\PolitiebureausLocatieAPIController::class);

Route::resource('books', App\Http\Controllers\API\BookAPIController::class);

Route::resource('reviews', App\Http\Controllers\API\ReviewAPIController::class);

Route::resource('adds', App\Http\Controllers\API\AddAPIController::class);

Route::resource('adjective_nouns', App\Http\Controllers\API\AdjectiveNounAPIController::class);

Route::resource('adjectives', App\Http\Controllers\API\AdjectiveAPIController::class);

Route::resource('composition_noun_references', App\Http\Controllers\API\CompositionNounReferenceAPIController::class);

Route::resource('composition_nouns', App\Http\Controllers\API\CompositionNounAPIController::class);

Route::resource('irregular_noun_references', App\Http\Controllers\API\IrregularNounReferenceAPIController::class);

Route::resource('irregular_nouns', App\Http\Controllers\API\IrregularNounAPIController::class);

Route::resource('irregular_proxy_noun_references', App\Http\Controllers\API\IrregularProxyNounReferenceAPIController::class);

Route::resource('irregular_proxy_nouns', App\Http\Controllers\API\IrregularProxyNounAPIController::class);

Route::resource('non_composition_proxy_nouns', App\Http\Controllers\API\NonCompositionProxyNounAPIController::class);

Route::resource('normal_noun_references', App\Http\Controllers\API\NormalNounReferenceAPIController::class);

Route::resource('normal_nouns', App\Http\Controllers\API\NormalNounAPIController::class);

Route::resource('polymorphic_nouns', App\Http\Controllers\API\PolymorphicNounAPIController::class);

Route::resource('references', App\Http\Controllers\API\ReferenceAPIController::class);

Route::resource('replaces', App\Http\Controllers\API\ReplaceAPIController::class);

Route::resource('results', App\Http\Controllers\API\ResultAPIController::class);

Route::resource('rule_references', App\Http\Controllers\API\RuleReferenceAPIController::class);

Route::resource('rules', App\Http\Controllers\API\RuleAPIController::class);