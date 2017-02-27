@extends('layout.base')

@section('titulo')
    Criar Disciplina
@endsection

@section('descricao')
    Complete os campos para criar uma nova disciplina.
@endsection

@section('mapa')
    <li><i class="fa fa-book"></i> Disciplinas</li>
    <li><i class="fa fa-plus"></i> Criar</li>
@endsection

@section('conteudo')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form action="{{ route('armazenarDisciplina') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('codigo') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}" placeholder="Código da disciplina" title="Código da disciplina" required>
                            </div>
                            @if($errors->has('codigo'))
                                <p class="help-block">{!! $errors->first('codigo') !!}</p>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" placeholder="Nome da disciplina" title="Nome da disciplina" required>
                            </div>
                            @if($errors->has('nome'))
                                <p class="help-block">{!! $errors->first('nome') !!}</p>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('maximo_faltas') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                                <input type="number" name="maximo_faltas" class="form-control" value="{!! old('maximo_faltas') !!}" placeholder="Quantidade máxima de faltas" title="Quantidade máxima de faltas" required>
                            </div>
                            @if($errors->has('maximo_faltas'))
                                <p class="help-block">{!! $errors->first('maximo_faltas') !!}</p>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-ufop" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Resetar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
