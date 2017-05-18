@extends('layout.base')

@section('titulo')
    Seleção das datas
@endsection

@section('descricao')
    Selecione as datas que deseja gerenciar as faltas da turma {{ $turma->codigo }} da disciplina {{ $turma->disciplina->nome }}
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

                        <div class="help-block">
                            <p class="text-center">
                                Se você selecionar apenas um dia, não é necessário preencher a segunda entrada relativa ao dia final do intervalo
                            </p>
                        </div>

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
@endsection
