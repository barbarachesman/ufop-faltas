@extends('layout.base')

@section('titulo')
    UFOP Faltas da turma {{ $turma->codigo }}
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
{!! HTML::style('js/plugins/jQueryUI/jquery-ui.min.css') !!}
{!! HTML::style('js/plugins/datatables/dataTables.bootstrap.css') !!}

{{-- Correção para usar o datepicker dentro de um modal --}}
<style>
    .datepicker{z-index:1151 !important;}
</style>
@endpush

@push('extra-scripts')
{!! HTML::script('js/plugins/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('js/plugins/datatables/dataTables.bootstrap.min.js') !!}
{!! HTML::script('js/plugins/jQueryUI/jquery-ui.min.js') !!}
{!! HTML::script('js/plugins/jQueryUI/datepicker-pt-BR.js') !!}

<script>
    $(".datepicker").datepicker($.datepicker.regional['pt-BR']);
</script>

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
                            @if(!auth()->user()->isAluno())
                                <th>Matrícula</th>

                                <th>Aluno</th>

                                @foreach($faltas->keys() as $data)
                                    <th>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y') }}</th>
                                @endforeach

                                <th>Número de faltas</th>
                            @endif
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($matriculados as $matriculado)
                                <tr>
                                    @if(!auth()->user()->isAluno())
                                        <td>{!! $matriculado->aluno->matricula ? $matriculado->aluno->matricula : 'Desconhecida' !!}</td>
                                        <td>{!! $matriculado->aluno->nome !!}</td>
                                    @endif
                                    @if(auth()->user()->isAluno() and auth()->user()->id == $matriculado->aluno_id)
                                        @foreach($faltas->keys() as $data)
                                            <tr>
                                                <th>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y') }}</th>
                                                <td>
                                                    <?php $presenca = true; ?>
                                                    @foreach($faltas[$data]->values() as $falta)
                                                        @if($falta->aluno->id == $matriculado->aluno_id and (auth()->user()->isAluno() and auth()->user()->id == $matriculado->aluno_id))
                                                            <span class="text-danger text-bold"><i class="fa fa-times"></i> Ausente</span>
                                                            <?php $presenca = false; ?>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if($presenca and (auth()->user()->isAluno() and auth()->user()->id == $matriculado->aluno_id))
                                                        <span class="text-success text-bold"><i class="fa fa-check"></i> Presente</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                </tr>

                                      @endif
                                        @if(!auth()->user()->isAluno())
                                              @foreach($faltas->keys() as $data)
                                                  <td>
                                                      <?php $presenca = true; ?>
                                                      @foreach($faltas[$data]->values() as $falta)
                                                          @if($falta->aluno->id == $matriculado->aluno_id )
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
                                              @endif

                                              @if(!auth()->user()->isAluno())
                                                <td>
                                                  <?php $qtde = DB::table('faltas')->where('aluno_id', $matriculado->aluno->id)->where('turma_id', $turma->id)->count();?>
                                                    {!! $qtde !!}
                                                </td>
                                              @endif
                                </tr>

                            @endforeach
                            </tbody>

                            @if(auth()->user()->isAluno())
                            <th>Número de faltas</th>
                            <td>
                                <?php $qtde = DB::table('faltas')->where('aluno_id', $matriculado->aluno->id)->where('turma_id', $turma->id)->count();?>
                                {!! $qtde !!}
                            </td>
                            @endif

                        </table>

                    @endif

                      <div class="text-center">

                          <button type="button" class="btn btn-warning" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>

                          @if(auth()->user()->isAluno())
                          <a class="btn btn-ufop" role="button" href="{{ route('abonarFalta', ['turma' => $turma, 'aluno' => auth()->id()]) }}">

                          <i class="fa fa-pencil-square-o"></i> Solicitar Justificativa
                          </a>
                          @endif

                          @can('manipular_turma', $turma)
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#relatorioModal">
                                  <i class="fa fa-table"></i> Gerar Diário de Frequência
                              </button>

                              <a class="btn btn-ufop" role="button" href="{{ route('selecionarFaltas', $turma->id) }}">
                                  <i class="fa fa-pencil-square-o"></i> Gerenciar faltas
                              </a>

                              <div class="modal fade" id="relatorioModal" tabindex="-1" role="dialog">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <h4 class="modal-title">Gerar Diário de Frequência</h4>
                                          </div>
                                          <form action="{{ route('gerarDiario', $turma->id) }}" method="POST">
                                              {{ csrf_field() }}
                                              <div class="modal-body">
                                                  <p class="text-center">Informe o dia inicial e final a serem considerados no diário:</p>

                                                  <div class="form-group {{ $errors->has('diaInicial') ? 'has-error' : '' }}">
                                                      <div class="input-group">
                                                          <span class="input-group-addon">Data inicial</span>
                                                          <input type="text" value="{{ old('dataInicial') }}" minlength="10" maxlength="10" class="form-control datepicker" name="dataInicial" title="Dia inicial do intervalo" placeholder="Dia inicial do intervalo no formato dd/mm/aaaa" required>
                                                      </div>
                                                      @if($errors->has('dataInicial'))
                                                          <div class="help-block">
                                                              {!! $errors->first('dataInicial') !!}
                                                          </div>
                                                      @endif
                                                  </div>

                                                  <div class="form-group" {{ $errors->has('dataFinal') ? 'has-error' : '' }}>
                                                      <div class="input-group">
                                                          <span class="input-group-addon">Data Final</span>
                                                          <input type="text" value="{{ old('dataFinal') }}" minlength="10" maxlength="10" class="form-control datepicker" name="dataFinal" title="Dia final do intervalo" placeholder="Dia final do intervalo no formato dd/mm/aaaa" required>
                                                      </div>
                                                      @if($errors->has('dataFinal'))
                                                          <div class="help-block">
                                                              {!! $errors->first('dataFinal') !!}
                                                          </div>
                                                      @endif
                                                  </div>

                                                  <div class="form-group">
                                                      <div class="input-group text-left">
                                                          <span class="input-group-addon">Dias da semana</span>
                                                          <input type="checkbox" name="dias[]" value="1"> Segunda-feira<br>
                                                          <input type="checkbox" name="dias[]" value="2"> Terça-feira<br>
                                                          <input type="checkbox" name="dias[]" value="3"> Quarta-feira<br>
                                                          <input type="checkbox" name="dias[]" value="4"> Quinta-feira<br>
                                                          <input type="checkbox" name="dias[]" value="5"> Sexta-feira<br>
                                                          <input type="checkbox" name="dias[]" value="6"> Sábado<br>
                                                          <input type="checkbox" name="dias[]" value="0"> Domingo<br>
                                                      </div>
                                                  </div>

                                                  <p class="text-center">Se nenhum dia da semana for considerado, serão considerados todos os dias, de segunda a domingo.</p>
                                              </div>

                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-primary pull-right">Gerar</button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          @endcan
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection
