@extends('layout.base')

@section('titulo')
    Períodos
@endsection

@section('descricao')
    Essa é a lista com todos os períodos cadastrados.
@endsection

@section('mapa')
    <li><i class="fa fa-calendar-o"></i> Períodos</li>
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
                                <th>Ano</th>
                                <th>Semestre</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($periodos as $periodo)
                                <tr>
                                    <td>{!! $periodo->ano !!}</td>
                                    <td>{!! $periodo->periodo !!}</td>
                                    <td>
                                        <a class="btn btn-ufop btn-xs" href="{{ route('detalhesPeriodo', $periodo->id) }}" role="button">
                                            <i class="fa fa-search"></i> Detalhes
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ route('editarPeriodo', $periodo->id) }}" role="button">
                                            <i class="fa fa-pencil-square-o"></i> Editar
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{ route('apagarPeriodo', $periodo->id) }}" role="button">
                                            <i class="fa fa-times"></i> Apagar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Ano</th>
                                <th>Semetre</th>
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
