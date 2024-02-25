<?php

use App\Http\Controllers\Web\PokemonController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::as('pokemons.')
    ->prefix('pokemons')
    ->controller(PokemonController::class)
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('filter', 'filter')->name('filter');
    });
