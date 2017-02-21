@extends('layout.base')

@section('titulo')
    Minhas Turmas
@endsection

@section('descricao')
    Essa é a lista com todas as turmas as quais você é responsável.
@endsection

@section('conteudo')
    <div class="col-md-12">
        <div class="box box-primary-ufop">
            <table class="table table-bordered table-hover table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Código da Disciplina</th>
                        <th>Disciplina</th>
                        <th>Turma</th>
                        <th>Ano</th>
                        <th>Período</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turmas as $encarregado)
                        <tr>
                            <td>{!! $encarregado->turma->disciplina->codigo !!}</td>
                            <td>{!! $encarregado->turma->disciplina->nome !!}</td>
                            <td>{!! $encarregado->turma->codigo !!}</td>
                            <td>{!! $encarregado->turma->periodo->ano !!}</td>
                            <td>{!! $encarregado->turma->periodo->periodo !!}</td>
                            <td>
                                @if($encarregado->turma->finalizada)
                                    <span class="text-danger">Finalizada</span>
                                @else
                                    <span class="text-success">Ativa</span>
                                @endif
                            </td>
                            <td><a href="{{ route('detalheTurma', $encarregado->turma->id) }}" class="btn btn-ufop btn-xs" role="button"><i class="fa fa-search"></i> Visualizar</a></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Código da Disciplina</th>
                        <th>Disciplina</th>
                        <th>Turma</th>
                        <th>Ano</th>
                        <th>Período</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
