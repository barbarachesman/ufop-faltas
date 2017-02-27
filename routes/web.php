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

        // Rotas envolvendo turmas
        Route::group(['prefix' => 'turma'], function (){
            Route::get('/', ['as' => 'visualizarTurmas', 'uses' => 'TurmaController@index']);
            Route::get('criar', ['as' => 'criarTurma', 'uses' => 'TurmaController@create']);
            Route::post('importar', ['as' => 'importarTurma', 'uses' => 'TurmaController@importarCSV']);
            Route::get('detalhe/{turma}', ['as' => 'detalheTurma', 'uses' => 'TurmaController@show'])->middleware('can:manipular_turma,turma');
            Route::get('finalizar/{turma}', ['as' => 'finalizarTurma', 'uses' => 'TurmaController@finalizar'])->middleware('can:manipular_turma,turma');
        });

        // Rotas envolvendo faltas
        Route::group(['prefix' => 'falta'], function (){
            Route::get('{turma}', ['as' => 'visualizarFaltas', 'uses' => 'FaltaController@show']);
            Route::get('selecionar/{turma}', ['as' => 'selecionarFaltas', 'uses' => 'FaltaController@select']);
            Route::post('gerenciar', ['as' => 'gerenciarFaltas', 'uses' => 'FaltaController@manage']);
            Route::post('atualizar', ['as' => 'atualizarFaltas', 'uses' => 'FaltaController@update']);
        });

        Route::group(['prefix' => 'aluno'], function (){
            Route::get('desmatricular/{aluno}/{turma}', ['as' => 'desmatricularAluno', 'uses' => 'AlunoController@desmatricular'])->middleware('can:manipular_turma,turma');
        });
    });

    // Rotas específicas para alunos
    Route::group(['middleware' => 'auth:aluno'], function (){

    });

    Route::get('sobre', ['as' => 'sobre', 'uses' => 'PagesController@sobre']);
});

Route::get('/login', ['as' => 'showLogin', 'uses' => 'Auth\LoginController@showLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('/sair', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
