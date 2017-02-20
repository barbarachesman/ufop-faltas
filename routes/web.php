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

    // Rotas específicas para professores
    Route::group(['middleware' => 'auth:aluno'], function (){
        Route::get('criarturma', ['as' => 'criarTurma', 'uses' => 'TurmaController@create']);
        Route::post('importarturma', ['as' => 'importarTurma', 'uses' => 'TurmaController@importCSV']);
        Route::get('visualizarturma', ['as' => 'visualizarTurma', 'uses' => 'TurmaController@index']);
    });

    // Rotas específicas para alunos
    Route::group(['middleware' => 'auth:aluno'], function (){

    });

    Route::get('sobre', ['as' => 'sobre', 'uses' => 'PagesController@sobre']);
});

Route::get('/login', ['as' => 'showLogin', 'uses' => 'Auth\LoginController@showLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('/sair', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
