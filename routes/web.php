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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/travels', 'TravelsController@index');
    Route::get('/travels/create', 'TravelsController@create');
    Route::get('/travels/{travel}', 'TravelsController@show');
    Route::get('/travels/{travel}/edit', 'TravelsController@edit');
    Route::post('/travels', 'TravelsController@store');
    Route::patch('/travels/{travel}', 'TravelsController@update');

    Route::post('/travels/{travel}/tasks', 'TravelTasksController@store');
    Route::patch('/travels/{travel}/tasks/{task}', 'TravelTasksController@update');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

