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
         <form action="import_csv_file" method="post" enctype="multipart/form-data">
           <input type="file" name="csv_file">
           <br>
           <p>
             <input type="submit" value="Importar Diario">
           </p>
        </form>

        <br>
      </br>
        </div>
    </div>
@endsection
