@extends('layout.base')

@section('titulo')
    Anexar Atestado
@endsection

@section('descricao')
    Escolha o arquivo .pdf que contenha o atestado e selecione escolha a falta que deseja abonar.
    Disciplina {{ $turma->disciplina->nome }}
@endsection

@section('mapa')
    <li><i class="fa fa-users"></i> Turmas</li>
    <li><i class="fa fa-calendar"></i> Faltas</li>
    <li><i class="fa fa-hand-o-up"></i> Selecionar data(s)</li>
@endsection

@push('extra-css')
{!! HTML::style('js/plugins/jQueryUI/jquery-ui.min.css') !!}
@endpush

@push('extra-scripts')
{!! HTML::script('js/plugins/jQueryUI/jquery-ui.min.js') !!}
{!! HTML::script('js/plugins/jQueryUI/datepicker-pt-BR.js') !!}

<script>
    $(".datepicker").datepicker($.datepicker.regional['pt-BR']);
</script>
@endpush


@section('conteudo')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="text-center" action="{{ route('gerenciarFaltas') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="turma" value="{{ $turma->id }}" required>

                        <div class="form-group {{ $errors->has('diaInicial') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" value="{{ old('dataFinal') }}" minlength="10" maxlength="10" class="form-control datepicker" name="dataFinal" title="Dia final do intervalo" placeholder="Dia final do intervalo no formato dd/mm/aaaa">
                            </div>


                            @if($errors->has('dataFinal'))
                                <div class="help-block">
                                    {!! $errors->first('dataFinal') !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group" >
                              <textarea name="comment" cols='75' rows='3' name='texto' maxlength="250">Deixe aqui um comentário para o professor, se necessário...</textarea>
                        </div>

                        <label for="dia" class="radio-inline">
                            <input id="dia" type="radio" name="opcao" value="dia">
                            Somente um dia
                        </label>

                        <label for="intervalo" class="radio-inline">
                            <input type="radio" id="intervalo" name="opcao" value="intervalo" checked>
                            Intervalo
                        </label>

                        @if($errors->has('opcao'))
                            <div class="help-block has-error">
                                {{ $errors->first('opcao') }}
                            </div>
                        @endif


                    </div>

                    <form id="criarabono" class="form-horizontal" method="POST" action="{{ route('criarAbono', ['turma' => $turma, 'aluno' => auth()->id()]) }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group {{ $errors->has('file') || $errors->has('disciplina') ? 'has-error' : '' }}">
                            <label for="file" class="col-sm-2 control-label">Selecione o atestado</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="file" name="file" >
                                @if($errors->has('file') || $errors->has('disciplina'))
                                    <p class="text-help text-danger">
                                        @if($errors->has('file'))
                                            {!! $errors->first('file') !!}
                                        @else
                                            {!! $errors->first('disciplina') !!}
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                        <br>
                            <div class="text-center">
                                <button type="button" onclick="submitModal();" class="btn btn-success"><i class="fa fa-upload"></i> Solicitar Abono</button>
                            </div>
                        </div>
                    </form>

                    <p class="text-left">
                        Se você selecionar apenas um dia, não é necessário preencher a segunda entrada relativa ao dia final do intervalo
                    </p>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-ufop" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                        <button type="reset" class="btn btn-warning"><i class="fa fa-eraser"></i> Limpar</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Selecionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Aguarde</h4>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('img/bigloading.gif') }}" />
                <br />
                Validando as informações dos alunos e realizando a importação.
                <br />
                Isso pode levar algum tempo de acordo com o tamanho da turma.
                <br />
                Não feche nem recarregue a página durante a importação.

            </div>
        </div>
    </div>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
