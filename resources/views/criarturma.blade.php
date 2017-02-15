@extends('layout.base')

@section('titulo')
    Criar Turma
@endsection

@section('descricao')
    Escolha o arquivo CSV que contenha os dados da turma.
@endsection

@section('conteudo')
    <div class='col-lg-12'>
        <div class='col-lg-12'>
            <form class="form-horizontal" method="POST" action="{{ route('importarTurma') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                    <label for="file" class="col-sm-3 control-label">Selecione o arquivo CSV</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="file" name="file" >
                        @if($errors->has('file'))
                            <p class="text-help">{!! $errors->first('file') !!}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Enviar</button>
                    </div>
                </div>
            </form>
            <br />
        </div>
    </div>
@endsection
