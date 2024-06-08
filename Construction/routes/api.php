<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('postes', App\Http\Controllers\API\PosteAPIController::class)
    ->except(['create', 'edit']);

Route::resource('sous-travauxes', App\Http\Controllers\API\SousTravauxAPIController::class)
    ->except(['create', 'edit']);

Route::resource('finitions', App\Http\Controllers\API\finitionAPIController::class)
    ->except(['create', 'edit']);