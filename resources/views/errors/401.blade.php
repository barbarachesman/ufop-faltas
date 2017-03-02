@extends('layout.base')

@section('titulo')
    Erro 401
@endsection

@section('conteudo')
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-red">401</h2>
            <br />
            <div class="error-content">
                <h3><i class="fa fa-hand-stop-o text-red"></i> Acesso Não Autorizado</h3>

                <p>
                    Você não tem as permissões necessárias para acessar esse conteúdo.
                    Por gentileza, volte para a página <a href="{{url('/')}}">inicial</a> ou voltar para a página <a href="javascript:history.back()">anterior</a> em que você estava.
                </p>
            </div>
        </div>
    </div>
@endsection