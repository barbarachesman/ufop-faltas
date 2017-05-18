<?php

namespace App\Http\Controllers;

use App\Disciplina;
use App\Http\Requests\AtualizarDisciplinasRequest;
use App\Http\Requests\CriarDisciplinaRequest;

class DisciplinaController extends Controller
{
    /**
     * Renderiza a view com a lista de disciplinas cadastradas.
     */
    public function index()
    {
        return view('disciplina.index')->with('disciplinas', Disciplina::all()->sortBy('codigo'));
    }

    /**
     * Renderiza a view contendo o formulário de criação de umanova disciplina.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('disciplina.create');
    }

    /**
     * Armazena uma nova instância de uma Disciplina.
     * @param CriarDisciplinaRequest $request Requisição com os campos do formulário validados
     * @return \Illuminate\Http\RedirectResponse Página com a lista das disciplinas
     */
    public function store(CriarDisciplinaRequest $request)
    {
        try
        {
            Disciplina::create($request->all());

            session()->flash('tipo', 'success');
            session()->flash('mensagem', 'Disciplina criada com sucesso');

            return redirect()->route('visualizarDisciplinas');
        }
        catch (\Exception $ex)
        {
            session()->flash('tipo', 'error');
            session()->flash('mensagem', 'Erro ao criar disciplina: ' . $ex->getMessage());

            return back()->withInput($request->all());
        }
    }

    /**
     * Renderiza a view com detalhes da disciplina.
     * @param Disciplina $disciplina Instância da disciplina a ser visualizada
     */
    public function show(Disciplina $disciplina)
    {
        $disciplina->load(['turmas.periodo', 'turmas.encarregados.professor']);
        return view('disciplina.show')->with('disciplina', $disciplina);
    }

    /**
     * Renderiza a view contendo o formulário de edição de uma disciplina.
     * @param Disciplina $disciplina Instância da disciplina a ser editada
     */
    public function edit(Disciplina $disciplina)
    {
        return view('disciplina.edit')->with('disciplina', $disciplina);
    }


    /**
     * Atualiza uma instância de disciplina.
     * @param AtualizarDisciplinasRequest $request Requisição com os campos validados
     * @return \Illuminate\Http\RedirectResponse Página anterior
     */
    public function update(AtualizarDisciplinasRequest $request)
    {
        try
        {
            $disciplina = Disciplina::find($request->get('id'));
            $disciplina->update($request->all());

            session()->flash('tipo', 'success');
            session()->flash('mensagem', 'Disciplina editada com sucesso');
        }
        catch (\Exception $ex)
        {
            session()->flash('tipo', 'error');
            session()->flash('mensagem', 'Erro ao atualizar disciplina: ' . $ex->getMessage());
        }

        return back();
    }


    /**
     * Remove uma instância de Disciplina do banco de dados
     * @param Disciplina $disciplina Instância a ser removida
     */
    public function destroy(Disciplina $disciplina)
    {
        try
        {
            $disciplina->delete();

            session()->flash('tipo', 'success');
            session()->flash('mensagem', 'Disciplina removida com sucesso');

            return back();
        }
        catch (\Exception $ex)
        {
            session()->flash('tipo', 'error');
            session()->flash('mensagem', 'Erro ao apagar a disciplina: ' . $ex->getMessage());

            return back()->withErrors(['disciplina' => $ex->getMessage()]);
        }
    }
}
