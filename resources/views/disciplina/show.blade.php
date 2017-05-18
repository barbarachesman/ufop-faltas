@extends('layout.base')

@section('titulo')
    Detalhes da disciplina {!! $disciplina->codigo !!} {!! $disciplina->nome !!}
@endsection

@section('descricao')
    Esses são os detalhes da disciplina {!! $disciplina->codigo !!} {!! $disciplina->nome !!}.
@endsection

@section('mapa')
    <li><i class="fa fa-book"></i> Disciplinas</li>
    <li><i class="fa fa-search-plus"></i> Detalhes</li>
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
                        <table class="table table-bordered table-hover table-responsive table-striped text-center">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Disciplina</th>
                                <th>Máximo de faltas</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{!! $disciplina->codigo !!}</td>
                                    <td>{!! $disciplina->nome !!}</td>
                                    <td>{!! $disciplina->maximo_faltas !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-ufop" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                        <a class="btn btn-primary" href="{{ route('editarDisciplina', $disciplina->id) }}" role="button">
                            <i class="fa fa-pencil-square-o"></i> Editar
                        </a>
                        <a class="btn btn-danger" href="{{ route('apagarDisciplina', $disciplina->id) }}" role="button">
                            <i class="fa fa-times"></i> Apagar
                        </a>
                    </div>

                    <br />

                    @if(!$disciplina->turmas->isEmpty())
                        <h4 class="text-center">Existem {!! $disciplina->turmas->count() !!} turma(s) relacionadas com essa disciplina.</h4>
                        <div class="table table-responsive">
                            <table id="table" class="table table-bordered table-hover table-responsive table-striped text-center">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Periodo</th>
                                    <th>Status</th>
                                    <th>Professor(es)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($disciplina->turmas as $turma)
                                    <tr>
                                        <td>{!! $turma->codigo !!}</td>
                                        <td>{!! $turma->periodo->ano !!}.{!! $turma->periodo->periodo !!}</td>
                                        <td>
                                            <span class="text-bold
                                            @if($turma->finalizada)
                                                text-danger">Finalizada
                                            @else
                                                text-success">Ativa
                                            @endif
                                            </span>
                                        </td>
                                        <td>
                                            @foreach($turma->encarregados as $encarregado)
                                                {!! $encarregado->professor->nome !!},
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Código</th>
                                    <th>Periodo</th>
                                    <th>Status</th>
                                    <th>Professor(es)</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
