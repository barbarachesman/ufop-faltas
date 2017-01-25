@extends('layout.base')

@section('titulo')
    Início
@endsection

@section('descricao')
    Bem-vindo {!! Auth::user()->nome !!}, você está na página inicial.
@endsection

@section('conteudo')
    <div class='col-lg-12'>
       <p>
           Crie alguma coisa incrível :)
       </p>
    </div>
@endsection
