@extends('layout.base')

@section('titulo')
    Detalhes Turma {!! $turma->codigo !!} de {!! $turma->disciplina->codigo !!}
@endsection

@section('descricao')
    Essa é a lista com os alunos matriculados na turma {!! $turma->codigo !!} da disciplina {{ $turma->disciplina->nome }}
@endsection

@section('mapa')
    <li><i class="fa fa-users"></i> Turmas</li>
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
    <div class="col-md-12">
        <div class="box box-primary-ufop">
            <div class="box-header"><h3 class="box-title">Atualmente {{ $alunos->count() }} alunos estão matriculados</h3></div>
            <div class="box-body">
                <div class="table">
                    <table id="table" class="table table-bordered table-hover table-responsive table-striped text-center">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>E-mail</th>
                                <th>Curso</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($alunos as $matriculado)
                            <tr>
                                <td>{!! $matriculado->aluno->nome !!}</td>
                                <td>{!! $matriculado->aluno->email !!}</td>
                                <td>{!! $matriculado->aluno->grupo_nome !!}</td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-xs" role="button"><i class="fa fa-trash"></i> Desmatricular</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Aluno</th>
                                <th>E-mail</th>
                                <th>Curso</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <br />

                <div class="text-center">
                    <a class="btn btn-ufop" role="button" href="#"><i class="fa fa-pencil-square-o"></i> Gerenciar Faltas</a>
                    @if(!$turma->finalizada)
                        <a class="btn bg-black" role="button" href="{{ route('finalizarTurma', $turma->id) }}"><i class="fa fa-lock"></i> Finalizar Turma</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
