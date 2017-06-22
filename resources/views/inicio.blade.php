@extends('layout.base')

@section('titulo')
    Início
@endsection

@section('descricao')
    Bem-vindo {!! auth()->user()->nome !!}, você está na página inicial.
@endsection

@section('conteudo')

<h4>Um ambiente virtual de controle de faltas para auxílio aos alunos e professores dos cursos de graduação presencial da UFOP.</h4>

<!-- Calendar -->

<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
<div class="row">
@foreach($turmas as $vinculo)
<?php $aluno = auth()->user()->id?>
<?php $qtde = DB::table('faltas')->where('aluno_id', $aluno)->where('turma_id', $vinculo->turma->id)->count();?>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
<!-- small box -->
@if($qtde <= 18)
<div class="small-box bg-gray">
@endif
@if($qtde > 18)
<div class="small-box bg-ufop">
@endif
<div class="inner">
  <p><b>{!! $vinculo->turma->disciplina->nome !!}</b>
    <br>
  <p>Turma:
    {!! $vinculo->turma->codigo !!}<br>
  <p>Período:
    {!! $vinculo->turma->periodo->ano !!}.{!! $vinculo->turma->periodo->periodo !!}<br>
  <p>Situação:
    @if($qtde <= 18)
    Aprovado
    @endif
    @if($qtde > 18)
    Reprovado
    @endif
    <p>Faltas:
      {!! $qtde !!}

</div>
<div class="icon">
  <i class="ion ion-pie-graph"></i>
</div>
<a href="{{ route('visualizarFaltas', $vinculo->turma->id) }}" class="small-box-footer" role="button">
    <i class="fa fa-calendar"></i> Visualizar diário
</a>
</div>
</div>
<!-- ./col -->
@endforeach
@endsection
