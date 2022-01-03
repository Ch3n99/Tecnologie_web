<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** 
 * Rotte per l'autenticazione
 */ 
Auth::routes();

// Personalizzo il percorso del logout per avere il logout come GET e non come POST
Route::get('logout', 'Auth\LoginController@logout'); 

/**
 * Rotta della radice e della Home 
 */
Route::get('/', 'ProjectController@index');
// La rotta home ha anche un "nomiglnolo" per essare chiamata attraverso il metodo route('home')
Route::get('/home', 'ProjectController@index')->name('home');
Route::get('progetto/{id}/prog', 'ProjectController@viewprog');
Route::get('cliente/{id}/cl', 'ClienteController@viewcliente');
Route::get('diario/{id}/index', 'DiarioController@viewdiario');
Route::get('assegnazione/{id}/create', 'AssegnazioneController@createass');
Route::resource('diario', 'DiarioController', ['except' => ['destroy']]);
Route::resource('utente', 'UserController', ['except' => ['destroy']]);
Route::resource('cliente', 'ClienteController', ['except' => ['destroy']]);
Route::resource('progetto', 'ProjectController', ['except' => ['destroy']]);
Route::resource('assegnazione', 'AssegnazioneController', ['except' => ['destroy']]);
Route::get('utente/{id}/destroy', 'UserController@destroy');
Route::get('assegnazione/{id}/destroy', 'AssegnazioneController@destroy');
Route::get('cliente/{id}/destroy', 'ClienteController@destroy');
Route::get('progetto/{id}/destroy', 'ProjectController@destroy');
Route::get('diario/{id}/destroy', 'DiarioController@destroy');