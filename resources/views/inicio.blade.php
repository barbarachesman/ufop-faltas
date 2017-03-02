@extends('layout.base')

@section('titulo')
    Início
@endsection

@section('descricao')
    Bem-vindo {!! auth()->user()->nome !!}, você está na página inicial.
@endsection

@section('conteudo')
@endsection
