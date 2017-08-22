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

    // Rotas específicas para administradores
    Route::group(['middleware' => 'can:administrar'], function (){

        // Manipulação de disciplinas
        Route::group(['prefix' => 'disciplina'], function (){
            Route::get('/', ['as' => 'visualizarDisciplinas', 'uses' => 'DisciplinaController@index']);
            Route::get('detalhe/{disciplina}', ['as' => 'detalhesDisciplina', 'uses' => 'DisciplinaController@show']);
            Route::get('editar/{disciplina}', ['as' => 'editarDisciplina', 'uses' => 'DisciplinaController@edit']);
            Route::post('editar', ['as' => 'atualizarDisciplina', 'uses' => 'DisciplinaController@update']);
            Route::get('criar', ['as' => 'criarDisciplina', 'uses' => 'DisciplinaController@create']);
            Route::post('armazenar', ['as' => 'armazenarDisciplina', 'uses' => 'DisciplinaController@store']);
            Route::get('deletar/{disciplina}', ['as' => 'apagarDisciplina', 'uses' => 'DisciplinaController@destroy']);
        });

        // Manipulação de períodos
        Route::group(['prefix' => 'periodo'], function(){
            Route::get('/', ['as' => 'visualizarPeriodos', 'uses' => 'PeriodoController@index']);
            Route::get('detalhe/{periodo}', ['as' => 'detalhesPeriodo', 'uses' => 'PeriodoController@show']);
            Route::get('editar/{periodo}', ['as' => 'editarPeriodo', 'uses' => 'PeriodoController@edit']);
            Route::post('editar', ['as' => 'atualizarPeriodo', 'uses' => 'PeriodoController@update']);
            Route::get('criar', ['as' => 'criarPeriodo', 'uses' => 'PeriodoController@create']);
            Route::post('armazenar', ['as' => 'armazenarPeriodo', 'uses' => 'PeriodoController@store']);
            Route::get('deletar/{periodo}', ['as' => 'apagarPeriodo', 'uses' => 'PeriodoController@destroy']);
        });

        Route::get('logs', ['as' => 'logs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    });

    // Rotas específicas para professores
    Route::group(['middleware' => 'can:lecionar'], function (){

        // Rotas envolvendo turmas
        Route::group(['prefix' => 'turma'], function (){
            Route::get('listar', ['as' => 'visualizarTurmasProfessor', 'uses' => 'TurmaController@index']);
            Route::get('criar', ['as' => 'criarTurma', 'uses' => 'TurmaController@create']);
            Route::get('atualizar/{turma}', ['as' => 'atualizarTurma', 'uses' => 'TurmaController@edit']);
            Route::post('importar', ['as' => 'importarTurma', 'uses' => 'TurmaController@importarCSV']);
            Route::post('atualizar', ['as' => 'importarAtualiza', 'uses' => 'TurmaController@atualizarTurma']);
            Route::get('detalhe/{turma}', ['as' => 'detalheTurma', 'uses' => 'TurmaController@show'])->middleware('can:manipular_turma,turma');
            Route::get('finalizar/{turma}', ['as' => 'finalizarTurma', 'uses' => 'TurmaController@finalizar'])->middleware('can:manipular_turma,turma');
        });

        // Rotas envolvendo faltas
        Route::group(['prefix' => 'falta'], function (){
            Route::get('{turma}', ['as' => 'visualizarFaltas', 'uses' => 'FaltaController@show']);
            Route::get('selecionar/{turma}', ['as' => 'selecionarFaltas', 'uses' => 'FaltaController@select']);
            Route::post('gerenciar', ['as' => 'gerenciarFaltas', 'uses' => 'FaltaController@manage']);
            Route::post('atualizar', ['as' => 'atualizarFaltas', 'uses' => 'FaltaController@update']);
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
    Route::group(['middleware' => 'can:assistir_aula'], function (){
        Route::get('turmas', ['as' => 'visualizarTurmasAluno', 'uses' => 'TurmaController@index']);
    });

    Route::get('faltas/{turma}', ['as' => 'visualizarFaltas', 'uses' => 'FaltaController@show']);
    Route::get('faltas/{turma}/pdfview',array('as'=>'pdfview','uses'=>'FaltaController@pdfview'));
    Route::get('falta/justificativa/{turma}/{aluno}', ['as' => 'abonarFalta', 'uses' => 'FaltaController@justificativa']);
    Route::post('abonar', ['as' => 'criarJustificativa', 'uses' => 'FaltaController@store']);
    Route::get('sobre', ['as' => 'sobre', 'uses' => 'PagesController@sobre']);
});

// System home
Route::get('/', ['as' => '/', 'uses' => 'PagesController@index']);


Route::get('/tutorial', ['as' => 'tutorial', 'uses' => 'PagesController@tutorial']);
Route::get('/login', ['as' => 'showLogin', 'uses' => 'Auth\LoginController@showLogin']);
Route::get('/home', ['as' => 'home', 'uses' => 'PagesController@home']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('/sair', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('download', ['as' => 'download', 'uses' => 'FaltaController@download']);
