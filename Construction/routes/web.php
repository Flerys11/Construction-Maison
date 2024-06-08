<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Admin login
Route::get('/admin', [\App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
Route::post('/log', [\App\Http\Controllers\AuthController::class, 'login'])->name('valide.login');
Route::get('/registre', [\App\Http\Controllers\AuthController::class, 'pageRegistre'])->name('page.registre');
Route::post('/registre', [\App\Http\Controllers\AuthController::class, 'registre'])->name('valide.registre');
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

//client login
Route::get('/', [\App\Http\Controllers\AuthController::class, 'client'])->name('log.client');
Route::post('/client', [\App\Http\Controllers\AuthController::class, 'login_client'])->name('login.client');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('postes', App\Http\Controllers\PosteController::class);
    Route::get('/tableau', [\App\Http\Controllers\TBordController::class, 'index'])->name('tableau');
    Route::get('/List/Devis', [\App\Http\Controllers\DevisControlle::class, 'index'])->name('liste.devis');
    Route::get('/supp', [\App\Http\Controllers\DevisControlle::class, 'supprime_base'])->name('supp.base');
    Route::post('/getChart', [\App\Http\Controllers\TBordController::class, 'getDateChart'])->name('date.chart');
    Route::resource('sous-travauxes', App\Http\Controllers\SousTravauxController::class);

    Route::post('/ImportMT', [\App\Http\Controllers\ImportController::class, 'importMT'])->name('import.mt');
    Route::resource('finitions', App\Http\Controllers\finitionController::class);
    Route::get('/Detail-EnCours/{id}', [\App\Http\Controllers\DevisClientController::class, 'DetailEnCours'])->name('detail.encours');


});


Route::middleware(['client.role'])->group(function () {

    Route::get('/client/logout', [\App\Http\Controllers\AuthController::class, 'logout_client'])->name('logout.client');
    Route::get('/detail/devis', [\App\Http\Controllers\AuthController::class, 'logout_client'])->name('devis.detail');
    Route::get('/home/client', [\App\Http\Controllers\DevisClientController::class, 'index'])->name('home.client');
    Route::get('/export-pdf/{id}', [\App\Http\Controllers\DevisClientController::class, 'expordPDF'])->name('export.pdf');
    Route::get('/choix-devis/{id}', [\App\Http\Controllers\DevisClientController::class, 'creationDevis'])->name('choix.devis');
    Route::get('/travaux', [\App\Http\Controllers\DevisClientController::class, 'getListTravaux'])->name('liste.travaux');
    Route::get('/paiement/{id}', [\App\Http\Controllers\DevisClientController::class, 'getPaiement'])->name('input.paiement');
    Route::post('/creation/devis', [\App\Http\Controllers\DevisClientController::class, 'insertDevis'])->name('insert.devis');
    Route::post('/insert/paiement', [\App\Http\Controllers\DevisClientController::class, 'insertPaiemenet'])->name('insert.paiement');

    Route::post('/ImportPaiement', [\App\Http\Controllers\ImportController::class, 'importP'])->name('import.paiement');

});



