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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/manifest')->group(function(){
	Route::get('/', 'ManifestsController@index');
	Route::post('/', 'ManifestsController@store');
	Route::put('/{id}', 'ManifestsController@update');
	Route::delete('/{id}', 'ManifestsController@destory');
});
