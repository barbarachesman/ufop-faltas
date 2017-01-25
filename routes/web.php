<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Rotas para usuários autenticados
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'PagesController@home']);
    Route::get('logs', ['as' => 'logs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    Route::get('criarturma', ['as' => 'criarturma', 'uses' => 'TurmaController@home']);
    Route::post('import_csv_file', ['as' => 'criarturma', 'uses' => 'TurmaController@import_csv_file']);
    Route::get('visualizarturma', ['as' => 'visualizarturma', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    Route::get('sobre', ['as' => 'sobre', 'uses' => 'PagesController@sobre']);
});

Route::get('/login', ['as' => 'showLogin', 'uses' => 'Auth\LoginController@showLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('/sair', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
