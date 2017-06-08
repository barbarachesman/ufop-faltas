@extends('layout.base')

@section('titulo')
    Anexar Atestado
@endsection

@section('descricao')
    Escolha o arquivo .pdf que contenha o atestado
@endsection

@push('extra-scripts')
{{-- Modal de loading --}}
{!! HTML::script('js/plugins/jQueryUI/jquery-ui.min.js') !!}
{!! HTML::script('js/plugins/jQueryUI/datepicker-pt-BR.js') !!}
<script>
    submitModal = function(){
        $('#loadingModal').modal({backdrop: 'static', keyboard: false});
        document.forms['importaratestado'].submit();
    }
</script>

<script>
    $(".datepicker").datepicker($.datepicker.regional['pt-BR']);
</script>
@endpush


@push('extra-css')
{!! HTML::style('js/plugins/jQueryUI/jquery-ui.min.css') !!}
@endpush


@section('conteudo')
    <div class="row">
        <div class='col-md-12'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form id="importaratestado" class="form-horizontal" method="POST" action="{{ route('abonarFalta') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                            <label for="file" class="col-sm-2 control-label">Selecione o atestado</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="file" name="file" >
                                @if($errors->has('file'))
                                    <p class="text-help text-danger">
                                        @if($errors->has('file'))
                                            {!! $errors->first('file') !!}
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <label for="file" class="col-sm-2 control-label">Turma</label>
                            <div class="col-sm-10">
                            <div class="input-group">
                              <select class="form-control m-bot15" name="turma_id">
                              @foreach($turmas as $turma)
                                <option value="{{$turma->id}}"</option>
                               @endForeach
                              </select>

                              </div>
                            </div>
                            <label for="file" class="col-sm-2 control-label">Data da falta</label>
                            <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" style="width:430px;font-size: 13px"  value="{{ old('dataFalta') }}" minlength="10" maxlength="10" class="form-control datepicker" name="dataFalta" title="Dia inicial do intervalo" placeholder="Dia da falta no formato dd/mm/aaaa" required>
                            </div>
                            </div>
                            <label for="file" class="col-sm-2 control-label">Observação</label>
                              <div class="col-sm-10">
                                <textarea name="comment" cols='75' rows='3' name='texto' maxlength="250">Deixe aqui um comentário para o professor, se necessário...</textarea>
                              </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="button" onclick="submitModal();" class="btn btn-success"><i class="fa fa-upload"></i> Anexar</button>
                            </div>
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
@endsection
