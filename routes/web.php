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

Route::get('assegnazione/{id}/index', 'ProjectController@query1');
Route::get('assegnazione/{id}/index2', 'ClienteController@query2');
Route::get('user/{id}/index2', 'UserController@query3');
Route::get('assegnazione/{id}/createv1', 'AssegnazioneController@createv1');
Route::get('assegnazione/{id}/createv2', 'AssegnazioneController@createv2');
Route::get('user/{id}/index2', 'UserController@query3');
Route::resource('diario', 'DiarioController', ['except' => ['destroy']]);
Route::resource('user', 'UserController', ['except' => ['destroy']]);
Route::resource('cliente', 'ClienteController', ['except' => ['destroy']]);
Route::resource('project', 'ProjectController', ['except' => ['destroy']]);
Route::resource('assegnazione', 'AssegnazioneController', ['except' => ['destroy']]);
Route::get('user/{id}/destroy', 'UserController@destroy');
Route::get('cliente/{id}/destroy', 'ClienteController@destroy');
Route::get('project/{id}/destroy', 'ProjectController@destroy');
Route::get('assegnazione/{id}/destroy', 'AssegnazioneController@destroy');
Route::get('diario/{id}/destroy', 'DiarioController@destroy');
