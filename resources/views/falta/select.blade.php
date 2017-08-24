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
                        @include('falta.formulario')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
