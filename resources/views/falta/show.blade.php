@extends('layout.base')

@section('titulo')
    Diário de Classe da turma {{ $turma->codigo }}
@endsection

@section('descricao')
    Essa é a lista de chamada da disciplina {{ $turma->disciplina->nome }}
@endsection


@section('mapa')
    <li><i class="fa fa-users"></i> Turmas</li>
    <li><i class="fa fa-search-plus"></i> Detalhes</li>
    <li><i class="fa fa-calendar"></i> Faltas</li>
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
                    @if($faltas->isEmpty())
                        <h3 class="text-center">Nenhuma falta registrada para essa turma</h3>
                    @else
                        <table id="table" class="table table-bordered table-striped table-responsive table-hover text-center">
                            <thead>
                            <tr>
                                <th>Matrícula</th>
                                @if(!auth()->user()->isAluno())
                                <th>Aluno</th>
                                @endif
                                @foreach($faltas->keys() as $data)
                                    <th>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y') }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matriculados as $matriculado)
                                <tr>
                                    <td>{!! $matriculado->aluno->matricula ? $matriculado->aluno->matricula : 'Desconhecida' !!}</td>
                                    @if(!auth()->user()->isAluno())
                                        <td>{!! $matriculado->aluno->nome !!}</td>
                                    @endif
                                    @foreach($faltas->keys() as $data)
                                        <td>
                                            <?php $presenca = true; ?>
                                            @foreach($faltas[$data]->values() as $falta)
                                                @if($falta->aluno->id == $matriculado->aluno_id)
                                                    <span class="text-danger text-bold"><i class="fa fa-times"></i> Ausente</span>
                                                    <?php $presenca = false; ?>
                                                    @break
                                                @endif
                                            @endforeach
                                            @if($presenca)
                                                <span class="text-success text-bold"><i class="fa fa-check"></i> Presente</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    <div class="text-center">
                        <button type="button" class="btn btn-warning" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                        @can('manipular_turma', $turma)
                            <a class="btn btn-ufop" role="button" href="{{ route('selecionarFaltas', $turma->id) }}">
                                <i class="fa fa-pencil-square-o"></i> Gerenciar faltas
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
