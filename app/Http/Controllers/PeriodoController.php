<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarPeriodoRequest;
use App\Http\Requests\CriarPeriodoRequest;
use App\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    /**
     * Renderiza a view contendo a listagem de todos os períodos.
     */
    public function index()
    {
        return view('periodo.index')->with('periodos', Periodo::all()->sortBy('ano'));
    }

    /**
     * Renderiza a view contendo o formulário de criação
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('periodo.create');
    }


    /**
     * Adiciona uma nova instância de Periodo no banco de dados.
     * @param CriarPeriodoRequest $request Requisição com os campos validados
     * @return \Illuminate\Http\RedirectResponse Página da listagem dos períodos
     */
    public function store(CriarPeriodoRequest $request)
    {
        try
        {
            Periodo::create($request->all());

            session()->flash('tipo', 'success');
            session()->flash('mensagem', 'Período criado com sucesso');

            return redirect()->route('visualizarPeriodos');
        }
        catch (\Exception $ex)
        {
            session()->flash('tipo', 'error');
            session()->flash('mensagem', 'Erro ao criar período: ' . $ex->getMessage());

            return back()->withInput($request->all());
        }
    }

    /**
     * Renderiza a view com detalhes sobre o periodo
     * @param Periodo $periodo Instância de Periodo a ser visualizada
     */
    public function show(Periodo $periodo)
    {
        $periodo->load(['turmas.disciplina', 'turmas.encarregados.professor']);
        return view('periodo.show')->with('periodo', $periodo);
    }

    /**
     * Renderiza a view com o formulário de edição de um Periodo
     * @param Periodo $periodo Instância de Periodo a ser editada
     */
    public function edit(Periodo $periodo)
    {
        return view('periodo.edit')->with('periodo', $periodo);
    }


    /**
     * Atualiza uma instância de Periodo no banco de dados
     * @param AtualizarPeriodoRequest $request Requisição com os campos do formulário validados
     * @return \Illuminate\Http\RedirectResponse Página anterior
     */
    public function update(AtualizarPeriodoRequest $request)
    {
        try
        {
            $periodo = Periodo::find($request->get('id'));
            $periodo->update($request->all());

            session()->flash('tipo', 'success');
            session()->flash('mensagem', 'Período atualizado com sucesso.');
        }
        catch (\Exception $ex)
        {
            session()->flash('tipo', 'error');
            session()->flash('mensagem', 'Erro ao atualizar o período: ' . $ex->getMessage());
        }

        return back();
    }

    /**
     * Apaga uma instância de Periodo do banco de dados.
     * @param Periodo $periodo Instância do período que será apagada
     */
    public function destroy(Periodo $periodo)
    {
        try
        {
            $periodo->delete();

            session()->flash('tipo', 'success');
            session()->flash('mensagem', 'Período apagado com sucesso.');

            return redirect()->route('visualizarPeriodos');
        }
        catch (\Exception $ex)
        {
            session()->flash('tipo', 'error');
            session()->flash('mensagem', 'Erro ao apagar o período: ' . $ex->getMessage());

            return back()->withErrors(['periodo' => $ex->getMessage()]);
        }
    }
}
