<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\PlanetsController;

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

Route::get('/people/populate', [PeopleController::class, 'populate']);
Route::get('/people/{person}', [PeopleController::class, 'show']);

Route::get('/species/populate', [SpeciesController::class, 'populate']);
Route::get('/species/{species}', [SpeciesController::class, 'show']);

Route::get('/planets/populate', [PlanetsController::class, 'populate']);
Route::get('/planets/{planet}', [PlanetsController::class, 'show']);
