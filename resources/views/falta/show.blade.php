@extends('layout.base')

@section('titulo')
    Faltas da turma {{ $turma->codigo }} da disciplina {{ $turma->disciplina->codigo }}
@endsection

@section('descricao')
    Essas são as faltas da turma {{ $turma->codigo }} da disciplina {{ $turma->disciplina->codigo }} {{ $turma->disciplina->nome }}
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
                                @if(!auth()->user()->isProfessor())
                                    <th>Aluno</th>
                                @endif
                                @foreach($faltas as $falta)
                                    <th>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $falta->data)->format('d/m/Y') }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($matriculados as $matriculado)
                                    <tr>
                                        <td>{!! $matriculado->aluno->matricula !!}</td>
                                        @if(!auth()->user()->isAluno())
                                            <td>{!! $matriculado->aluno->nome !!}</td>
                                        @endif
                                            @foreach($faltas as $falta)
                                            <td>
                                                <?php $presenca = true; ?>
                                                @if($falta->aluno->id == $matriculado->aluno_id)
                                                    <span class="text-danger text-bold"><i class="fa fa-times"></i> Ausente</span>
                                                    <?php $presenca = false; ?>
                                                @endif
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
                    @can('manipular_turma', $turma)
                        <div class="text-center">
                            <a class="btn btn-ufop" role="button" href="{{ route('selecionarFaltas', $turma->id) }}"><i class="fa fa-pencil-square-o"></i> Gerenciar faltas</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection