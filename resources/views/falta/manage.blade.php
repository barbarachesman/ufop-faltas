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
    <li><i class="fa fa-pencil-square-o"></i> Gerenciar</li>
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
            "aLengthMenu": [[-1], ["Tudo"]]
        });
    });
</script>
@endpush

@section('conteudo')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form action="{{ route('atualizarFaltas') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="turma" value="{{ $turma->id }}">

                        <div class="form-group text-center">
                            <button type="button" onclick="history.back()" class="btn btn-ufop"><i class="fa fa-arrow-left"></i> Voltar</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Resetar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Aplicar</button>
                        </div>

                        <div class="table table-responsive">
                            <table id="table" class="table table-bordered table-striped table-responsive table-hover text-center">
                                <thead>
                                <tr>
                                    <th>Matrícula</th>
                                    <th>Aluno</th>
                                    @foreach($datas as $data)
                                        <th>{!! $data !!}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($matriculados as $matriculado)
                                    <tr>
                                        <td>{!! $matriculado->aluno->matricula !!}</td>
                                        <td>{!! $matriculado->aluno->nome !!}</td>
                                        @foreach($datas as $data)
                                            <td>
                                                @php
                                                    $presenca = true;
                                                    foreach ($faltas as $falta)
                                                    {
                                                        if($falta->aluno_id == $matriculado->aluno_id && \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d') == $falta->data)
                                                        {
                                                            $presenca = false;
                                                            break;
                                                        }
                                                    }
                                                @endphp

                                                <label class="radio-inline">
                                                    <input type="radio" name="falta[{{ $matriculado->aluno->id }}][{{ $data }}]" value="presenca" {{ $presenca ? 'checked' : '' }}>
                                                    Presente
                                                </label>

                                                <label class="radio-inline">
                                                    <input type="radio" name="falta[{{ $matriculado->aluno->id }}][{{ $data }}]" value="falta" {{ !$presenca ? 'checked' : '' }}>
                                                    Ausente
                                                </label>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="form-group text-center">
                            <button type="button" onclick="history.back()" class="btn btn-ufop"><i class="fa fa-arrow-left"></i> Voltar</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Resetar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
