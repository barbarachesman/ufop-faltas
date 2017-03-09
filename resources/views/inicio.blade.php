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
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-aqua">
<div class="inner">
  <h3>10</h3>
    Situação: 10/18
    Status: Indefinido
  <p>PROGRAMAÇÃO 1</p>
</div>
<div class="icon">
  <i class="ion ion-bag"></i>
</div>
<a href="#" class="small-box-footer">Ver diário <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-green">
<div class="inner">
  <h3>5</h3>
    Situação: 18/18
    Status: RF
  <p>CALCULO NÚMERICO</p>
</div>
<div class="icon">
  <i class="ion ion-stats-bars"></i>
</div>
<a href="#" class="small-box-footer">Ver diário <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-yellow">
<div class="inner">
  <h3>0</h3>
    Situação: 0/18
    Status: Indefinido
  <p>PROGRAMAÇÃO 2</p>
</div>
<div class="icon">
  <i class="ion ion-person-add"></i>
</div>
<a href="#" class="small-box-footer">Ver diário <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-red">
<div class="inner">
  <h3>1</h3>
    Situação: 1/18
    Status: Indefinido
  <p>ALGÉBRA LINEAR</p>
</div>
<div class="icon">
  <i class="ion ion-pie-graph"></i>
</div>
<a href="#" class="small-box-footer">Ver diário <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
</div>
@endsection
