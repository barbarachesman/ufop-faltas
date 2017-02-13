@extends('layout.base')

@section('titulo')
    Criar Turma
@endsection

@section('descricao')
    {!! Auth::user()->nome !!}
@endsection
@extends('layout.base')

@section('titulo')
    Criar Turma
@endsection

@section('descricao')
    {!! Auth::user()->nome !!}
@endsection


@section('conteudo')
    <div class='col-lg-12'>
      <div class='col-lg-12'>

        <form class="form-horizontal" method="POST" action="/ascents/upload" enctype="multipart/form-data">>
    {!! csrf_field() !!}
    <div class="form-group">
        <label for="file" class="col-sm-3 control-label">Select CSV File</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" id="file" name="file" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-default">Upload</button>
        </div>
    </div>
</form>

        <br>
      </br>
        </div>
    </div>
@endsection
