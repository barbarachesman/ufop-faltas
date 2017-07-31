@extends('layout.base')

@section('titulo')
    Disciplinas
@endsection

@section('descricao')
    Essa é a lista com todas as disciplinas cadastradas.
@endsection

@section('mapa')
    <li><i class="fa fa-book"></i> Disciplinas</li>
    <li><i class="fa fa-th-list"></i> Listar</li>
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
                                <th>Código</th>
                                <th>Disciplina</th>
                                <th>Máximo de faltas</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($disciplinas as $disciplina)
                                <tr>
                                    <td>{!! $disciplina->codigo !!}</td>
                                    <td>{!! $disciplina->nome !!}</td>
                                    <td>{!! $disciplina->maximo_faltas !!}</td>
                                    <td>
                                        <a class="btn btn-ufop btn-xs" href="{{ route('detalhesDisciplina', $disciplina->id) }}" role="button">
                                            <i class="fa fa-search"></i> Detalhes
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('editarDisciplina', $disciplina->id) }}" role="button">
                                            <i class="fa fa-pencil-square-o"></i> Editar
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{ route('apagarDisciplina', $disciplina->id) }}" role="button">
                                            <i class="fa fa-times"></i> Apagar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Disciplina</th>
                                <th>Máximo de faltas</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
