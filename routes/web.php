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

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('proyecto','StarWarsController@find');
Route::get('api/find/{type}/{name}','StarWarsController@find')->name('buscar');
Route::get('api/setCount/{type}/{name}/{count}','StarWarsController@setCount')->name('actualizar');
Route::get('api/setCount/{type}/{name}/{count}/{mov}','StarWarsController@setCount')->name('actualizar');

