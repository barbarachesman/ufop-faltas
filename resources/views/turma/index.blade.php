@extends('layout.base')

@section('titulo')
    Minhas Turmas
@endsection

@section('descricao')
    Essa é a lista com todas as turmas as quais você é responsável.
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
                                    <span class="text-bold
                                    @if($encarregado->turma->finalizada)
                                        text-danger">Finalizada
                                    @else
                                        text-success">Ativa
                                    @endif
                                    </span>
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
        </div>
    </div>
@endsection
