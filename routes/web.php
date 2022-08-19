<?php

use Illuminate\Support\Facades\Route;

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


//crea tutte le rotte per l autenticazione e gestione degli utenti
Auth::routes();

//crea una rotto per la home-page pubblica
Route::get('/', 'HomeController@index')->name('home');

//crea una rotta per la home-page amministrativa
Route::get('/admin', 'Admin\HomeController@index')->name('admin.index');
