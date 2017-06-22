@extends('layout.base')

@section('titulo')
    Minhas Turmas
@endsection

@section('descricao')
    Essa é a lista com todas as turmas as quais você está matriculado.    
@endsection

@push('extra-css')
{!! HTML::style('js/plugins/datatables/dataTables.bootstrap.css') !!}
@endpush

@push('extra-scripts')
{!! HTML::script('js/plugins/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('js/plugins/datatables/dataTables.bootstrap.min.js') !!}
<script>
    $(document).ready(function () {
        $("#table").DataTable( {
            "bSort" : false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(Filtrado de _MAX_ registros)",
                "search": "Procurar:",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            },
            "autoWidth" : true,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]]
        });
    });
</script>
@endpush

@section('conteudo')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <div class="table">
                        <table id="table" class="table table-bordered table-hover table-responsive table-striped text-center">
                            <thead>
                            <tr>
                                <th>Código da Disciplina</th>
                                <th>Disciplina</th>
                                <th>Turma</th>
                                <th>Ano</th>
                                <th>Período</th>
                                <th>Status</th>
                                @if(auth()->user()->isAluno())
                                <th>Faltas</th>
                                @endif
                                <th>Ação</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($turmas as $vinculo)
                                <tr>
                                    <td>{!! $vinculo->turma->disciplina->codigo !!}</td>
                                    <td>{!! $vinculo->turma->disciplina->nome !!}</td>
                                    <td>{!! $vinculo->turma->codigo !!}</td>
                                    <td>{!! $vinculo->turma->periodo->ano !!}</td>
                                    <td>{!! $vinculo->turma->periodo->periodo !!}</td>
                                    <td>
                                    <span class="text-bold
                                    @if($vinculo->turma->finalizada)
                                            text-danger">Finalizada
                                        @else
                                            text-success">Ativa
                                        @endif
                                    </span>

                                    </td>

                                    <td>
                                      <?php $aluno = auth()->user()->id?>
                                      <?php $qtde = DB::table('faltas')->where('aluno_id', $aluno)->where('turma_id', $vinculo->turma->id)->count();?>
                                        {!! $qtde !!}
                                    </td>
                                    <td>
                                        @if(!auth()->user()->isAluno())
                                            <a href="{{ route('detalheTurma', $vinculo->turma->id) }}" class="btn btn-ufop btn-xs" role="button">
                                                <i class="fa fa-search-plus"></i> Detalhes
                                            </a>

                                            <a href="{{ route('atualizarTurma', $vinculo->turma->id) }}" class="btn btn-ufop btn-xs" role="button">
                                                <i class="fa fa-search-plus"></i> Atualizar
                                            </a>
                                        @endif
                                        <a href="{{ route('visualizarFaltas', $vinculo->turma->id) }}" class="btn btn-ufop btn-xs" role="button">
                                            <i class="fa fa-calendar"></i> Visualizar diário
                                        </a>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
